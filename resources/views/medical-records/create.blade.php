<x-layouts.app>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-gray-100 leading-tight">
                    {{ __('New Medical Record') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Log a health event, treatment, or checkup for a game fowl.
                </p>
            </div>
            <a href="{{ route('staff.medical-records.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-lg font-medium text-sm text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('staff.medical-records.store') }}" method="POST">
                @csrf
                
                <!-- Main Layout -->
                <div class="space-y-8">

                    @if ($errors->any())
                        <div class="rounded-lg bg-red-50 dark:bg-red-900/50 p-4 border border-red-200 dark:border-red-800">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                                        There were errors with your submission
                                    </h3>
                                    <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Section 1: Record Information -->
                    <div class="bg-white dark:bg-zinc-900 shadow-sm rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
                        <div class="px-6 py-4 border-b border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                                Record Information
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Basic details about the medical event.</p>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Game Fowl Selection -->
                            <div class="md:col-span-2">
                                <label for="game_fowl_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Game Fowl <span class="text-red-500">*</span></label>
                                <select name="game_fowl_id" id="game_fowl_id" class="block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 transition-colors" required>
                                    <option value="">Select Game Fowl</option>
                                    @foreach($gameFowls as $fowl)
                                        <option value="{{ $fowl->id }}" {{ (old('game_fowl_id') ?? ($selectedGameFowl?->id)) == $fowl->id ? 'selected' : '' }}>
                                            {{ $fowl->tag_id }} - {{ $fowl->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Date -->
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date <span class="text-red-500">*</span></label>
                                <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" class="block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5" required>
                            </div>

                            <!-- Type -->
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Record Type <span class="text-red-500">*</span></label>
                                <select name="type" id="type" class="block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5" required>
                                    <option value="">Select Type</option>
                                    <option value="Vaccination" {{ old('type') == 'Vaccination' ? 'selected' : '' }}>Vaccination</option>
                                    <option value="Treatment" {{ old('type') == 'Treatment' ? 'selected' : '' }}>Treatment</option>
                                    <option value="Injury" {{ old('type') == 'Injury' ? 'selected' : '' }}>Injury</option>
                                    <option value="Checkup" {{ old('type') == 'Checkup' ? 'selected' : '' }}>Checkup</option>
                                    <option value="Deworming" {{ old('type') == 'Deworming' ? 'selected' : '' }}>Deworming</option>
                                    <option value="Vitamin" {{ old('type') == 'Vitamin' ? 'selected' : '' }}>Vitamin</option>
                                </select>
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status <span class="text-red-500">*</span></label>
                                <select name="status" id="status" class="block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5" required>
                                    <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="Pending" {{ old('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Scheduled" {{ old('status') == 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Treatment Details -->
                    <div class="bg-white dark:bg-zinc-900 shadow-sm rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
                        <div class="px-6 py-4 border-b border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                </svg>
                                Treatment Details
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Medication and personnel involved.</p>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Medication Name -->
                            <div>
                                <label for="medication_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Medication / Treatment Name</label>
                                <input type="text" name="medication_name" id="medication_name" value="{{ old('medication_name') }}" class="block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5">
                            </div>

                            <!-- Dosage -->
                            <div>
                                <label for="dosage" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Dosage</label>
                                <input type="text" name="dosage" id="dosage" value="{{ old('dosage') }}" class="block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5">
                            </div>

                            <!-- Administered By -->
                            <div>
                                <label for="administered_by" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Administered By</label>
                                <input type="text" name="administered_by" id="administered_by" value="{{ old('administered_by', auth()->user()->name) }}" class="block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5">
                            </div>

                            <!-- Technician Name -->
                            <div>
                                <label for="technician_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Technician / Vet Name</label>
                                <input type="text" name="technician_name" id="technician_name" value="{{ old('technician_name') }}" class="block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5">
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Logistics & Follow-up -->
                    <div class="bg-white dark:bg-zinc-900 shadow-sm rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
                        <div class="px-6 py-4 border-b border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Logistics & Follow-up
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Cost tracking and future appointments.</p>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-8">
                            <!-- Location -->
                            <div>
                                <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Location / Clinic</label>
                                <input type="text" name="location" id="location" value="{{ old('location') }}" class="block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5">
                            </div>

                            <!-- Cost -->
                            <div>
                                <label for="cost" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cost</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">₱</span>
                                    </div>
                                    <input type="number" step="0.01" name="cost" id="cost" value="{{ old('cost') }}" class="pl-8 block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5" placeholder="0.00">
                                </div>
                            </div>

                            <!-- Next Schedule Date -->
                            <div>
                                <label for="next_schedule_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Next Schedule Date</label>
                                <input type="date" name="next_schedule_date" id="next_schedule_date" value="{{ old('next_schedule_date') }}" class="block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5">
                            </div>
                        </div>
                    </div>

                    <!-- Section 4: Notes -->
                    <div class="bg-white dark:bg-zinc-900 shadow-sm rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
                        <div class="px-6 py-4 border-b border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Notes
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Any additional observations or comments.</p>
                        </div>
                        <div class="p-6">
                            <textarea name="notes" id="notes" rows="4" class="block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="Write any notes here...">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end gap-4 pt-4">
                        <a href="{{ route('staff.medical-records.index') }}" wire:navigate class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest shadow-lg hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 transform hover:scale-[1.02]">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Save Record
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
