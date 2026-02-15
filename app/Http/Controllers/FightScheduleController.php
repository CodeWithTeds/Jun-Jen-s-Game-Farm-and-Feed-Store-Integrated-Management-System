<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFightScheduleRequest;
use App\Http\Requests\UpdateFightScheduleRequest;
use App\Repositories\Contracts\FightScheduleRepositoryInterface;
use App\Repositories\Contracts\GameFowlRepositoryInterface;
use Illuminate\Http\Request;

class FightScheduleController extends Controller
{
    protected $fightScheduleRepository;
    protected $gameFowlRepository;

    public function __construct(
        FightScheduleRepositoryInterface $fightScheduleRepository,
        GameFowlRepositoryInterface $gameFowlRepository
    ) {
        $this->fightScheduleRepository = $fightScheduleRepository;
        $this->gameFowlRepository = $gameFowlRepository;
    }

    public function index()
    {
        $upcomingSchedules = $this->fightScheduleRepository->getUpcoming();
        $historySchedules = $this->fightScheduleRepository->getHistory();
        return view('fight_schedules.index', compact('upcomingSchedules', 'historySchedules'));
    }

    public function create()
    {
        $gameFowls = $this->gameFowlRepository->getAll(['sex' => 'Male', 'all' => true]);
        return view('fight_schedules.create', compact('gameFowls'));
    }

    public function store(StoreFightScheduleRequest $request)
    {
        $this->fightScheduleRepository->create($request->validated());

        $prefix = request()->routeIs('admin.*') ? 'admin.' : 'staff.';
        return redirect()->route($prefix . 'fight-schedules.index')
            ->with('success', 'Fight Schedule created successfully.');
    }

    public function edit($id)
    {
        $schedule = $this->fightScheduleRepository->find($id);
        $gameFowls = $this->gameFowlRepository->getAll(['sex' => 'Male', 'all' => true]);
        
        return view('fight_schedules.edit', compact('schedule', 'gameFowls'));
    }

    public function update(UpdateFightScheduleRequest $request, $id)
    {
        $this->fightScheduleRepository->update($id, $request->validated());

        $prefix = request()->routeIs('admin.*') ? 'admin.' : 'staff.';
        return redirect()->route($prefix . 'fight-schedules.index')
            ->with('success', 'Fight Schedule updated successfully.');
    }

    public function destroy($id)
    {
        $this->fightScheduleRepository->delete($id);

        $prefix = request()->routeIs('admin.*') ? 'admin.' : 'staff.';
        return redirect()->route($prefix . 'fight-schedules.index')
            ->with('success', 'Fight Schedule deleted successfully.');
    }
}
