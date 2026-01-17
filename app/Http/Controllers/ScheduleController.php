<?php

namespace App\Http\Controllers;

use App\Services\ScheduleService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    protected $scheduleService;

    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    public function index(Request $request)
    {
        $filters = $request->all();

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->isAdmin()) {
            $filters['assigned_to'] = $user->id;
        }

        $schedules = $this->scheduleService->getAllSchedules($filters);
        return view('schedules.index', compact('schedules'));
    }

    public function create()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $users = User::all();
        return view('schedules.create', compact('users'));
    }

    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'schedule_type' => 'required|string',
            'related_module' => 'required|string',
            'target_id' => 'nullable|integer',
            'start_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:start_date',
            'repeat_type' => 'required|string',
            'priority' => 'required|string',
            'status' => 'required|string',
            'assigned_to' => 'nullable|exists:users,id',
            'reminder_time' => 'nullable',
            'notification_method' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $this->scheduleService->createSchedule($validated);

        return redirect()->route('schedules.index')->with('success', 'Schedule created successfully.');
    }

    public function edit($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $schedule = $this->scheduleService->getScheduleById($id);
        $users = User::all();
        return view('schedules.edit', compact('schedule', 'users'));
    }

    public function update(Request $request, $id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'schedule_type' => 'required|string',
            'related_module' => 'required|string',
            'target_id' => 'nullable|integer',
            'start_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:start_date',
            'repeat_type' => 'required|string',
            'priority' => 'required|string',
            'status' => 'required|string',
            'assigned_to' => 'nullable|exists:users,id',
            'reminder_time' => 'nullable',
            'notification_method' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $this->scheduleService->updateSchedule($id, $validated);

        return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully.');
    }

    public function destroy($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $this->scheduleService->deleteSchedule($id);
        return redirect()->route('schedules.index')->with('success', 'Schedule deleted successfully.');
    }
}
