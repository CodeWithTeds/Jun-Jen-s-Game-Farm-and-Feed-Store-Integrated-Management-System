<x-layouts.app>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-gray-100 leading-tight">
                    {{ __('New Breeding Record') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Record a new breeding pair and their details.
                </p>
            </div>
            <a href="{{ route('staff.breedings.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-lg font-medium text-sm text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('staff.breedings.store') }}" method="POST">
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

                    <!-- Section 1: Parentage -->
                    <div class="bg-white dark:bg-zinc-900 shadow-sm rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
                        <div class="px-6 py-4 border-b border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                Parentage
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Select the sire and dam for this breeding record.</p>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Sire -->
                            <div class="relative group">
                                <label for="sire_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sire (Male) <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">♂</span>
                                    </div>
                                    <select name="sire_id" id="sire_id" class="pl-8 mt-1 block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 transition-colors" required>
                                        <option value="">Select Sire</option>
                                        @foreach($sires as $sire)
                                            <option value="{{ $sire->id }}" {{ old('sire_id') == $sire->id ? 'selected' : '' }}>{{ $sire->name }} ({{ $sire->tag_id }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Dam -->
                            <div class="relative group">
                                <label for="dam_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Dam (Female) <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">♀</span>
                                    </div>
                                    <select name="dam_id" id="dam_id" class="pl-8 mt-1 block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 transition-colors" required>
                                        <option value="">Select Dam</option>
                                        @foreach($dams as $dam)
                                            <option value="{{ $dam->id }}" {{ old('dam_id') == $dam->id ? 'selected' : '' }}>{{ $dam->name }} ({{ $dam->tag_id }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Breeding Details -->
                    <div class="bg-white dark:bg-zinc-900 shadow-sm rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
                        <div class="px-6 py-4 border-b border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Breeding Details
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Specify the date, method, and current status.</p>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-8">
                            <!-- Breeding Date -->
                            <div>
                                <label for="breeding_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Breeding Date <span class="text-red-500">*</span></label>
                                <input type="date" name="breeding_date" id="breeding_date" value="{{ old('breeding_date') }}" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5" required>
                            </div>

                            <!-- Type -->
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Breeding Method <span class="text-red-500">*</span></label>
                                <select name="type" id="type" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5" required>
                                    <option value="Natural" {{ old('type') == 'Natural' ? 'selected' : '' }}>Natural Mating</option>
                                    <option value="AI" {{ old('type') == 'AI' ? 'selected' : '' }}>Artificial Insemination</option>
                                    <option value="Trio" {{ old('type') == 'Trio' ? 'selected' : '' }}>Trio Mating</option>
                                </select>
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status <span class="text-red-500">*</span></label>
                                <select name="status" id="status" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5" required>
                                    <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="Failed" {{ old('status') == 'Failed' ? 'selected' : '' }}>Failed</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Management & Location -->
                    <div class="bg-white dark:bg-zinc-900 shadow-sm rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
                        <div class="px-6 py-4 border-b border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Management & Location
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Details about where and when.</p>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-8">
                            <!-- Pen Number -->
                            <div>
                                <label for="pen_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pen / Coop Number <span class="text-red-500">*</span></label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                        </svg>
                                    </div>
                                    <input type="text" name="pen_number" id="pen_number" value="{{ old('pen_number') }}" class="pl-10 mt-1 block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5" placeholder="e.g. A-101" required>
                                </div>
                            </div>

                            <!-- Clutch Number -->
                            <div>
                                <label for="clutch_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Clutch / Batch Number</label>
                                <input type="text" name="clutch_number" id="clutch_number" value="{{ old('clutch_number') }}" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5" placeholder="Optional">
                            </div>

                            <!-- Expected Hatch Date -->
                            <div>
                                <label for="expected_hatch_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Expected Hatch Date</label>
                                <input type="date" name="expected_hatch_date" id="expected_hatch_date" value="{{ old('expected_hatch_date') }}" class="mt-1 block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5">
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
                        <a href="{{ route('staff.breedings.index') }}" wire:navigate class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-widest shadow-lg hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 transform hover:scale-[1.02]">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Create Record
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
