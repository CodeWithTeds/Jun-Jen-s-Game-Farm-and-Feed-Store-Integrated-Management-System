<?php

namespace App\Livewire\Settings;

use App\Models\Setting;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Index extends Component
{
    use WithFileUploads;

    public $activeTab = 'general';
    public $search = '';

    // For form binding
    public $form = [];

    // For import
    public $importFile;
    public $showImportModal = false;

    protected $queryString = ['activeTab'];

    public function mount()
    {
        if (!Gate::allows('manage-settings')) {
            abort(403);
        }

        $this->loadForm();
    }

    public function loadForm()
    {
        $settings = Setting::all();
        foreach ($settings as $setting) {
            $this->form[$setting->key] = $setting->value;
        }
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        $query = Setting::query()->orderBy('group')->orderBy('order', 'asc')->orderBy('id');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('key', 'like', '%' . $this->search . '%')
                    ->orWhere('label', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        $settings = $query->get();
        $settingsGrouped = $settings->groupBy('group');

        $history = collect();
        if ($this->activeTab === 'history') {
            $history = \App\Models\AuditLog::with('user')
                ->where('auditable_type', Setting::class)
                ->latest()
                ->take(50)
                ->get();
        }

        return view('livewire.settings.index', [
            'settingsGrouped' => $settingsGrouped,
            'history' => $history,
        ]);
    }

    public function rollback($id)
    {
        if (!Gate::allows('manage-settings')) {
            abort(403);
        }

        $log = \App\Models\AuditLog::findOrFail($id);

        $setting = Setting::find($log->auditable_id);
        if ($setting && isset($log->old_values['value'])) {
            $setting->value = $log->old_values['value'];
            $setting->save();

            // Update form value
            $this->form[$setting->key] = $setting->value;

            $this->js('Flux.toast({ text: "Setting reverted successfully.", variant: "success" })');
        }
    }

    public function save()
    {
        if (!Gate::allows('manage-settings')) {
            abort(403);
        }

        // Validate? We can iterate and validate based on validation_rules column
        $rules = [];
        foreach (Setting::all() as $setting) {
            if ($setting->validation_rules) {
                $rules['form.' . $setting->key] = $setting->validation_rules;
            }
        }
        
        if (!empty($rules)) {
            $this->validate($rules);
        }

        foreach ($this->form as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            if ($setting && $setting->value != $value) {
                // Determine type casting for value before saving if needed?
                // The mutator in Model handles json encoding if type is json
                $setting->value = $value;
                $setting->save();
            }
        }

        $this->dispatch('settings-saved');
        $this->js('Flux.toast({ text: "Settings saved successfully.", variant: "success" })');
    }

    public function export()
    {
        if (!Gate::allows('manage-settings')) {
            abort(403);
        }

        $settings = Setting::all(['key', 'value', 'group', 'type']);
        $json = $settings->toJson(JSON_PRETTY_PRINT);
        $filename = 'settings-backup-' . date('Y-m-d-H-i-s') . '.json';

        return response()->streamDownload(function () use ($json) {
            echo $json;
        }, $filename);
    }

    public function import()
    {
        if (!Gate::allows('manage-settings')) {
            abort(403);
        }

        $this->validate([
            'importFile' => 'required|file|mimes:json',
        ]);

        $content = file_get_contents($this->importFile->getRealPath());
        $data = json_decode($content, true);

        if (!is_array($data)) {
            $this->addError('importFile', 'Invalid JSON file.');
            return;
        }

        foreach ($data as $item) {
            if (isset($item['key'])) {
                $setting = Setting::where('key', $item['key'])->first();
                if ($setting) {
                    $setting->value = $item['value'];
                    $setting->save();
                } else {
                    // Optional: Create if not exists?
                    // For now, only update existing to avoid garbage
                    // But requirement says "migration purposes", so maybe create?
                    // Let's create if valid structure
                    if (isset($item['group']) && isset($item['type']) && isset($item['label'])) {
                        Setting::create([
                            'key' => $item['key'],
                            'value' => $item['value'],
                            'group' => $item['group'],
                            'type' => $item['type'],
                            'label' => $item['label'] ?? ucfirst(str_replace('_', ' ', $item['key'])),
                            // ... other fields
                        ]);
                    }
                }
            }
        }

        $this->showImportModal = false;
        $this->importFile = null;
        $this->loadForm();
        $this->js('Flux.toast({ text: "Settings imported successfully.", variant: "success" })');
    }
}
