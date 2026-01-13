<x-layouts.app>
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Edit Schedule / Reminder') }}</h1>
            <a href="{{ route('schedules.index') }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                &larr; {{ __('Back to List') }}
            </a>
        </div>

        <div class="bg-white dark:bg-zinc-900 overflow-hidden shadow-sm sm:rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
            <form method="POST" action="{{ route('schedules.update', $schedule->id) }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Title -->
                    <div class="col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Title') }}</label>
                        <input id="title" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" type="text" name="title" value="{{ old('title', $schedule->title) }}" required autofocus />
                        @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Schedule Type -->
                    <div>
                        <label for="schedule_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Schedule Type') }}</label>
                        <select id="schedule_type" name="schedule_type" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                            <option value="">Select Type</option>
                            <option value="Feeding" {{ old('schedule_type', $schedule->schedule_type) == 'Feeding' ? 'selected' : '' }}>Feeding</option>
                            <option value="Vaccination" {{ old('schedule_type', $schedule->schedule_type) == 'Vaccination' ? 'selected' : '' }}>Vaccination</option>
                            <option value="Cleaning" {{ old('schedule_type', $schedule->schedule_type) == 'Cleaning' ? 'selected' : '' }}>Cleaning</option>
                            <option value="Collection" {{ old('schedule_type', $schedule->schedule_type) == 'Collection' ? 'selected' : '' }}>Collection</option>
                            <option value="Other" {{ old('schedule_type', $schedule->schedule_type) == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('schedule_type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Related Module -->
                    <div>
                        <label for="related_module" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Related Module') }}</label>
                        <select id="related_module" name="related_module" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                            <option value="">Select Module</option>
                            <option value="Chick Rearing" {{ old('related_module', $schedule->related_module) == 'Chick Rearing' ? 'selected' : '' }}>Chick Rearing</option>
                            <option value="Feeding" {{ old('related_module', $schedule->related_module) == 'Feeding' ? 'selected' : '' }}>Feeding</option>
                            <option value="Medical" {{ old('related_module', $schedule->related_module) == 'Medical' ? 'selected' : '' }}>Medical</option>
                            <option value="Hatchery" {{ old('related_module', $schedule->related_module) == 'Hatchery' ? 'selected' : '' }}>Hatchery</option>
                            <option value="General" {{ old('related_module', $schedule->related_module) == 'General' ? 'selected' : '' }}>General</option>
                        </select>
                        @error('related_module')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Target ID -->
                    <div>
                        <label for="target_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Target ID (Optional)') }}</label>
                        <input id="target_id" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" type="number" name="target_id" value="{{ old('target_id', $schedule->target_id) }}" />
                        <p class="text-xs text-gray-500 mt-1">ID of the related record (e.g., Chick Group ID, Feed ID)</p>
                        @error('target_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Assigned To -->
                    <div>
                        <label for="assigned_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Assigned To') }}</label>
                        <select id="assigned_to" name="assigned_to" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow">
                            <option value="">Unassigned</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('assigned_to', $schedule->assigned_to) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                            @endforeach
                        </select>
                        @error('assigned_to')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Start Date -->
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Start Date') }}</label>
                        <input id="start_date" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" type="date" name="start_date" value="{{ old('start_date', $schedule->start_date->format('Y-m-d')) }}" required />
                        @error('start_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Due Date -->
                    <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Due Date (Optional)') }}</label>
                        <input id="due_date" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" type="date" name="due_date" value="{{ old('due_date', $schedule->due_date ? $schedule->due_date->format('Y-m-d') : '') }}" />
                        @error('due_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Repeat Type -->
                    <div>
                        <label for="repeat_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Repeat') }}</label>
                        <select id="repeat_type" name="repeat_type" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                            <option value="None" {{ old('repeat_type', $schedule->repeat_type) == 'None' ? 'selected' : '' }}>None</option>
                            <option value="Daily" {{ old('repeat_type', $schedule->repeat_type) == 'Daily' ? 'selected' : '' }}>Daily</option>
                            <option value="Weekly" {{ old('repeat_type', $schedule->repeat_type) == 'Weekly' ? 'selected' : '' }}>Weekly</option>
                            <option value="Monthly" {{ old('repeat_type', $schedule->repeat_type) == 'Monthly' ? 'selected' : '' }}>Monthly</option>
                        </select>
                        @error('repeat_type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Priority -->
                    <div>
                        <label for="priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Priority') }}</label>
                        <select id="priority" name="priority" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                            <option value="Low" {{ old('priority', $schedule->priority) == 'Low' ? 'selected' : '' }}>Low</option>
                            <option value="Medium" {{ old('priority', $schedule->priority) == 'Medium' ? 'selected' : '' }}>Medium</option>
                            <option value="High" {{ old('priority', $schedule->priority) == 'High' ? 'selected' : '' }}>High</option>
                        </select>
                        @error('priority')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Status') }}</label>
                        <select id="status" name="status" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                            <option value="Pending" {{ old('status', $schedule->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Completed" {{ old('status', $schedule->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                            <option value="Missed" {{ old('status', $schedule->status) == 'Missed' ? 'selected' : '' }}>Missed</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Reminder Time -->
                    <div>
                        <label for="reminder_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Reminder Time (Optional)') }}</label>
                        <input id="reminder_time" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" type="time" name="reminder_time" value="{{ old('reminder_time', $schedule->reminder_time ? date('H:i', strtotime($schedule->reminder_time)) : '') }}" />
                        @error('reminder_time')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notification Method -->
                    <div>
                        <label for="notification_method" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Notification Method') }}</label>
                        <select id="notification_method" name="notification_method" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                            <option value="System" {{ old('notification_method', $schedule->notification_method) == 'System' ? 'selected' : '' }}>System</option>
                            <option value="Email" {{ old('notification_method', $schedule->notification_method) == 'Email' ? 'selected' : '' }}>Email</option>
                        </select>
                        @error('notification_method')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div class="col-span-2">
                        <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Notes') }}</label>
                        <textarea id="notes" name="notes" rows="3" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow">{{ old('notes', $schedule->notes) }}</textarea>
                        @error('notes')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        {{ __('Update Schedule') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
