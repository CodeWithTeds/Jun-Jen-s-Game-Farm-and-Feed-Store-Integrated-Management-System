<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEggCollectionRequest;
use App\Http\Requests\UpdateEggCollectionRequest;
use App\Services\EggCollectionService;
use App\Services\GameFowlService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EggCollectionController extends Controller
{
    protected $eggCollectionService;
    protected $gameFowlService;

    public function __construct(EggCollectionService $eggCollectionService, GameFowlService $gameFowlService)
    {
        $this->eggCollectionService = $eggCollectionService;
        $this->gameFowlService = $gameFowlService;
    }

    public function index(Request $request)
    {
        // Auto-update any overdue incubating records when viewing the list
        $this->autoUpdateOverdueCollections();

        $eggCollections = $this->eggCollectionService->getAllEggCollections($request->all());
        return view('egg-collections.index', compact('eggCollections'));
    }

    public function create()
    {
        $breedings = \App\Models\Breeding::with(['sire', 'dam'])
            ->where('status', 'Completed')
            ->latest()
            ->get();

        return view('egg-collections.create', compact('breedings'));
    }

    public function store(StoreEggCollectionRequest $request)
    {
        $this->eggCollectionService->createEggCollection($request->validated());
        $prefix = request()->routeIs('admin.*') ? 'admin.' : 'staff.';
        return redirect()->route($prefix . 'egg-collections.index')->with('success', 'Egg collection created successfully.');
    }

    public function show($id)
    {
        $eggCollection = $this->eggCollectionService->getEggCollectionById($id);

        // Auto-update status if the expected hatch date has been reached
        $this->autoUpdateIfHatchDateReached($eggCollection);

        // Re-fetch so the view always sees the latest status
        $eggCollection = $this->eggCollectionService->getEggCollectionById($id);

        return view('egg-collections.show', compact('eggCollection'));
    }

    public function edit($id)
    {
        $eggCollection = $this->eggCollectionService->getEggCollectionById($id);

        // Auto-update status if the expected hatch date has been reached
        $this->autoUpdateIfHatchDateReached($eggCollection);

        // Re-fetch so the form always sees the latest status
        $eggCollection = $this->eggCollectionService->getEggCollectionById($id);

        $breedings = \App\Models\Breeding::with(['sire', 'dam'])
            ->where('status', 'Completed')
            ->latest()
            ->get();

        return view('egg-collections.edit', compact('eggCollection', 'breedings'));
    }

    public function update(UpdateEggCollectionRequest $request, $id)
    {
        $this->eggCollectionService->updateEggCollection($id, $request->validated());
        $prefix = request()->routeIs('admin.*') ? 'admin.' : 'staff.';
        return redirect()->route($prefix . 'egg-collections.index')->with('success', 'Egg collection updated successfully.');
    }

    public function destroy($id)
    {
        $this->eggCollectionService->deleteEggCollection($id);
        $prefix = request()->routeIs('admin.*') ? 'admin.' : 'staff.';
        return redirect()->route($prefix . 'egg-collections.index')->with('success', 'Egg collection deleted successfully.');
    }

    /**
     * Auto-update a single egg collection's status to 'Completed'
     * if its expected hatch date has been reached and it is still 'Incubating'.
     */
    private function autoUpdateIfHatchDateReached($eggCollection): void
    {
        if (
            in_array($eggCollection->incubation_status, ['Pending', 'Incubating'])
            && $eggCollection->expected_hatch_date
            && Carbon::parse($eggCollection->expected_hatch_date)->lte(Carbon::today())
        ) {
            // If no eggs were explicitly incubated, assume all collected eggs were incubated
            $incubated = (int) ($eggCollection->incubated_count ?? 0) > 0
                ? (int) $eggCollection->incubated_count
                : (int) ($eggCollection->egg_count ?? 0);

            $eggCollection->update([
                'incubation_status' => 'Completed',
                'incubated_count'   => $incubated,
                'hatched_count'     => $incubated, // mark ALL as hatched
                'failed_count'      => 0,
            ]);
        }
    }

    /**
     * Bulk auto-update all overdue incubating collections.
     * Called on the index page so staff never sees a stale status in the list.
     */
    private function autoUpdateOverdueCollections(): void
    {
        \App\Models\EggCollection::whereIn('incubation_status', ['Pending', 'Incubating'])
            ->whereNotNull('expected_hatch_date')
            ->whereDate('expected_hatch_date', '<=', Carbon::today())
            ->each(function ($collection) {
                // If no eggs were explicitly incubated, fall back to total egg_count
                $incubated = (int) ($collection->incubated_count ?? 0) > 0
                    ? (int) $collection->incubated_count
                    : (int) ($collection->egg_count ?? 0);

                $collection->update([
                    'incubation_status' => 'Completed',
                    'incubated_count'   => $incubated,
                    'hatched_count'     => $incubated, // mark ALL as hatched
                    'failed_count'      => 0,
                ]);
            });
    }
}
