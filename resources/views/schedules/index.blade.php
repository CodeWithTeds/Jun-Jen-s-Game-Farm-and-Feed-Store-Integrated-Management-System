<x-layouts.app>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Schedules / Reminders') }}</h1>
        <a href="{{ route('schedules.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
            {{ __('Add Schedule') }}
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded dark:bg-green-900 dark:border-green-600 dark:text-green-300">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6 bg-white dark:bg-zinc-900 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 shadow-sm">
        <form method="GET" action="{{ route('schedules.index') }}" class="flex flex-wrap gap-4 items-end">
            <div class="w-full max-w-sm">
                <label for="search" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Search</label>
                <input 
                    type="search"
                    id="search"
                    name="search" 
                    placeholder="Search Title, Type, Module..." 
                    value="{{ request('search') }}"
                    class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow"
                />
            </div>

            <div class="w-32">
                <label for="status" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Status</label>
                <select id="status" name="status" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow">
                    <option value="">All</option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                    <option value="Missed" {{ request('status') == 'Missed' ? 'selected' : '' }}>Missed</option>
                </select>
            </div>

            <div class="w-32">
                <label for="priority" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Priority</label>
                <select id="priority" name="priority" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow">
                    <option value="">All</option>
                    <option value="Low" {{ request('priority') == 'Low' ? 'selected' : '' }}>Low</option>
                    <option value="Medium" {{ request('priority') == 'Medium' ? 'selected' : '' }}>Medium</option>
                    <option value="High" {{ request('priority') == 'High' ? 'selected' : '' }}>High</option>
                </select>
            </div>
            
            <div class="flex gap-2">
                <div class="w-32">
                    <label for="date_from" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">From</label>
                    <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow">
                </div>
                <div class="w-32">
                    <label for="date_to" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">To</label>
                    <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow">
                </div>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white">
                    {{ __('Filter') }}
                </button>
                
                @if(request()->anyFilled(['search', 'status', 'priority', 'date_from', 'date_to']))
                    <a href="{{ route('schedules.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 dark:bg-zinc-800 dark:border-zinc-600 dark:text-gray-300 dark:hover:bg-zinc-700">
                        {{ __('Clear') }}
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="bg-white dark:bg-zinc-900 overflow-hidden shadow-sm sm:rounded-lg border border-zinc-200 dark:border-zinc-700">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
                <thead class="bg-gray-50 dark:bg-zinc-900">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Title / Type') }}</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Module / Target') }}</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Schedule') }}</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Priority / Status') }}</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Assigned To') }}</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-zinc-800 divide-y divide-gray-200 dark:divide-zinc-700">
                    @forelse ($schedules as $schedule)
                        <tr class="hover:bg-gray-50 dark:hover:bg-zinc-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $schedule->title }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $schedule->schedule_type }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">{{ $schedule->related_module }}</div>
                                @if($schedule->target_id)
                                    <div class="text-xs text-gray-500 dark:text-gray-400">ID: {{ $schedule->target_id }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-white">{{ $schedule->start_date->format('Y-m-d') }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $schedule->repeat_type !== 'None' ? 'Repeats: ' . $schedule->repeat_type : 'One-time' }}
                                    @if($schedule->due_date)
                                        <br>Due: {{ $schedule->due_date->format('Y-m-d') }}
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col gap-1">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $schedule->priority === 'High' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' : 
                                           ($schedule->priority === 'Medium' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' : 
                                           'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300') }}">
                                        {{ $schedule->priority }}
                                    </span>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $schedule->status === 'Completed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 
                                           ($schedule->status === 'Missed' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' : 
                                           'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300') }}">
                                        {{ $schedule->status }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $schedule->assignee ? $schedule->assignee->name : 'Unassigned' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('schedules.edit', $schedule->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 mr-3">Edit</a>
                                <form action="{{ route('schedules.destroy', $schedule->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this schedule?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                {{ __('No schedules found.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($schedules->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-zinc-700">
                {{ $schedules->links() }}
            </div>
        @endif
    </div>
</x-layouts.app>
