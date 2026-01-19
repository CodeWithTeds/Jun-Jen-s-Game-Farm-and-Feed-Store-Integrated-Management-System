<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <flux:heading size="xl" class="leading-tight">{{ __('System Settings') }}</flux:heading>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">{{ __('Manage global application configurations.') }}</p>
        </div>
        <div class="flex gap-2">
             <flux:button wire:click="export" icon="arrow-down-tray">{{ __('Export') }}</flux:button>
             <flux:button wire:click="$set('showImportModal', true)" icon="arrow-up-tray">{{ __('Import') }}</flux:button>
        </div>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar/Tabs -->
        <div class="w-full lg:w-64 flex-shrink-0">
             <nav class="flex flex-col space-y-1">
                @foreach($settingsGrouped->keys() as $group)
                    <button 
                        wire:click="$set('activeTab', '{{ $group }}')"
                        class="px-4 py-2 text-left rounded-lg text-sm font-medium transition-colors {{ $activeTab === $group ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/50 dark:text-indigo-300' : 'text-zinc-600 hover:bg-zinc-50 dark:text-zinc-400 dark:hover:bg-zinc-800' }}"
                    >
                        {{ ucfirst($group) }}
                    </button>
                @endforeach
                
                <div class="border-t border-zinc-200 dark:border-zinc-700 my-2"></div>
                
                <button 
                    wire:click="$set('activeTab', 'history')"
                    class="px-4 py-2 text-left rounded-lg text-sm font-medium transition-colors {{ $activeTab === 'history' ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-900/50 dark:text-indigo-300' : 'text-zinc-600 hover:bg-zinc-50 dark:text-zinc-400 dark:hover:bg-zinc-800' }}"
                >
                    {{ __('History') }}
                </button>
             </nav>
        </div>

        <!-- Content -->
        <div class="flex-1">
             <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-800 p-6">
                @if($activeTab === 'history')
                    <!-- History Table -->
                    @include('livewire.settings.partials.history')
                @else
                    <!-- Settings Form -->
                    <div class="mb-6">
                        <flux:input wire:model.live.debounce.300ms="search" icon="magnifying-glass" placeholder="{{ __('Search settings...') }}" />
                    </div>

                    <form wire:submit="save">
                        <div class="space-y-6">
                            @if(isset($settingsGrouped[$activeTab]))
                                @php
                                    // Filter settings if search is active (client-side filtering for display within group)
                                    // Actually the query already filters, so if a group is shown, it has matching items.
                                    // However, loadSettings() groups by 'group'. If search is active, only matching settings are in the group.
                                    $currentSettings = $settingsGrouped[$activeTab];
                                @endphp

                                @if($currentSettings->isEmpty())
                                     <p class="text-zinc-500">{{ __('No settings match your search.') }}</p>
                                @else
                                    @foreach($currentSettings as $setting)
                                        <div class="grid gap-2 border-b border-zinc-100 dark:border-zinc-800 pb-6 last:border-0 last:pb-0">
                                            <div class="flex items-center justify-between">
                                                <label class="block text-sm font-medium text-zinc-900 dark:text-zinc-100">
                                                    {{ $setting->label }}
                                                </label>
                                                @if($setting->is_system)
                                                    <span title="{{ __('This setting may require a system restart to take effect.') }}" class="cursor-help text-xs text-amber-600 bg-amber-50 dark:bg-amber-900/30 dark:text-amber-400 px-2 py-0.5 rounded-full">{{ __('System') }}</span>
                                                @endif
                                            </div>
                                            
                                            @if($setting->description)
                                                <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-1">{{ $setting->description }}</p>
                                            @endif

                                            @if($setting->type === 'boolean')
                                                <div class="flex items-center mt-1">
                                                     <!-- Using standard toggle switch since flux:switch might not exist -->
                                                     <label class="relative inline-flex items-center cursor-pointer">
                                                        <input type="checkbox" wire:model="form.{{ $setting->key }}" class="sr-only peer">
                                                        <div class="w-11 h-6 bg-zinc-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-zinc-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600"></div>
                                                        <span class="ml-3 text-sm font-medium text-zinc-900 dark:text-zinc-300">{{ $setting->value ? 'Enabled' : 'Disabled' }}</span>
                                                      </label>
                                                </div>
                                            @elseif($setting->type === 'textarea')
                                                 <textarea 
                                                    wire:model="form.{{ $setting->key }}"
                                                    rows="4"
                                                    class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow"
                                                 ></textarea>
                                            @else
                                                 <flux:input wire:model="form.{{ $setting->key }}" type="{{ $setting->type === 'integer' ? 'number' : 'text' }}" />
                                            @endif
                                            
                                            @error('form.'.$setting->key) <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                    @endforeach
                                @endif
                            @else
                                <p class="text-zinc-500">{{ __('No settings found in this group.') }}</p>
                            @endif
                        </div>

                        <div class="mt-8 flex justify-end pt-6 border-t border-zinc-200 dark:border-zinc-700">
                            <flux:button type="submit" variant="primary" wire:confirm="{{ __('Are you sure you want to save these settings? Critical system configurations may be affected.') }}">{{ __('Save Changes') }}</flux:button>
                        </div>
                    </form>
                @endif
             </div>
        </div>
    </div>
    
    <!-- Import Modal -->
    <flux:modal name="import-settings" :show="$showImportModal">
        <div class="p-6 space-y-6">
            <div>
                <flux:heading size="lg">{{ __('Import Settings') }}</flux:heading>
                <flux:subheading>{{ __('Upload a JSON file to restore settings.') }}</flux:subheading>
            </div>
            
            <div class="space-y-2">
                <input type="file" wire:model="importFile" class="block w-full text-sm text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900/30 dark:file:text-indigo-300" />
                @error('importFile') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            
            <div class="flex justify-end space-x-2">
                <flux:button wire:click="$set('showImportModal', false)">{{ __('Cancel') }}</flux:button>
                <flux:button wire:click="import" variant="primary">{{ __('Import') }}</flux:button>
            </div>
        </div>
    </flux:modal>
</div>