<x-layouts.app>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Edit Medical Record') }}</h1>
        <a href="{{ route('staff.medical-records.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 dark:bg-zinc-700 dark:text-gray-300 dark:hover:bg-zinc-600">
            {{ __('Back to List') }}
        </a>
    </div>

    <div class="bg-white dark:bg-zinc-900 overflow-hidden shadow-sm sm:rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
        <form action="{{ route('staff.medical-records.update', $medicalRecord) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Game Fowl Selection -->
                <div class="md:col-span-2">
                    <label for="game_fowl_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Game Fowl</label>
                    <select name="game_fowl_id" id="game_fowl_id" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                        <option value="">Select Game Fowl</option>
                        @foreach($gameFowls as $fowl)
                            <option value="{{ $fowl->id }}" {{ (old('game_fowl_id') ?? $medicalRecord->game_fowl_id) == $fowl->id ? 'selected' : '' }}>
                                {{ $fowl->tag_id }} - {{ $fowl->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('game_fowl_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date -->
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date</label>
                    <input type="date" name="date" id="date" value="{{ old('date', $medicalRecord->date->format('Y-m-d')) }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                    @error('date')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Record Type</label>
                    <select name="type" id="type" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                        <option value="">Select Type</option>
                        <option value="Vaccination" {{ (old('type') ?? $medicalRecord->type) == 'Vaccination' ? 'selected' : '' }}>Vaccination</option>
                        <option value="Treatment" {{ (old('type') ?? $medicalRecord->type) == 'Treatment' ? 'selected' : '' }}>Treatment</option>
                        <option value="Injury" {{ (old('type') ?? $medicalRecord->type) == 'Injury' ? 'selected' : '' }}>Injury</option>
                        <option value="Checkup" {{ (old('type') ?? $medicalRecord->type) == 'Checkup' ? 'selected' : '' }}>Checkup</option>
                        <option value="Deworming" {{ (old('type') ?? $medicalRecord->type) == 'Deworming' ? 'selected' : '' }}>Deworming</option>
                        <option value="Vitamin" {{ (old('type') ?? $medicalRecord->type) == 'Vitamin' ? 'selected' : '' }}>Vitamin</option>
                    </select>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Medication Name -->
                <div>
                    <label for="medication_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Medication / Treatment Name</label>
                    <input type="text" name="medication_name" id="medication_name" value="{{ old('medication_name', $medicalRecord->medication_name) }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow">
                    @error('medication_name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dosage -->
                <div>
                    <label for="dosage" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Dosage</label>
                    <input type="text" name="dosage" id="dosage" value="{{ old('dosage', $medicalRecord->dosage) }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow">
                    @error('dosage')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Administered By -->
                <div>
                    <label for="administered_by" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Administered By</label>
                    <input type="text" name="administered_by" id="administered_by" value="{{ old('administered_by', $medicalRecord->administered_by) }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow">
                    @error('administered_by')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Technician Name -->
                <div>
                    <label for="technician_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Technician / Vet Name</label>
                    <input type="text" name="technician_name" id="technician_name" value="{{ old('technician_name', $medicalRecord->technician_name) }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow">
                    @error('technician_name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                    <select name="status" id="status" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                        <option value="Completed" {{ (old('status') ?? $medicalRecord->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                        <option value="Pending" {{ (old('status') ?? $medicalRecord->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Scheduled" {{ (old('status') ?? $medicalRecord->status) == 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Next Schedule Date -->
                <div>
                    <label for="next_schedule_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Next Schedule Date</label>
                    <input type="date" name="next_schedule_date" id="next_schedule_date" value="{{ old('next_schedule_date', $medicalRecord->next_schedule_date?->format('Y-m-d')) }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow">
                    @error('next_schedule_date')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cost -->
                <div>
                    <label for="cost" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cost</label>
                    <input type="number" step="0.01" name="cost" id="cost" value="{{ old('cost', $medicalRecord->cost) }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow">
                    @error('cost')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Location / Clinic</label>
                    <input type="text" name="location" id="location" value="{{ old('location', $medicalRecord->location) }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow">
                    @error('location')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notes -->
                <div class="md:col-span-2">
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Notes / Observations</label>
                    <textarea name="notes" id="notes" rows="3" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow">{{ old('notes', $medicalRecord->notes) }}</textarea>
                    @error('notes')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('staff.medical-records.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 dark:bg-zinc-800 dark:border-zinc-600 dark:text-gray-300 dark:hover:bg-zinc-700">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Update Record') }}
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
