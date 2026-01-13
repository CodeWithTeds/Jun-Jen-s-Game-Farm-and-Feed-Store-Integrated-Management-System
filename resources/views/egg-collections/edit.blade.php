<x-layouts.app>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-gray-100 leading-tight">
                    {{ __('Edit Egg Collection') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Update egg collection details.
                </p>
            </div>
            <a href="{{ route('staff.egg-collections.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-lg font-medium text-sm text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('staff.egg-collections.update', $eggCollection) }}" method="POST">
                @csrf
                @method('PUT')
                
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

                    <!-- Section 1: Collection Details -->
                    <div class="bg-white dark:bg-zinc-900 shadow-sm rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
                        <div class="px-6 py-4 border-b border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                Collection Details
                            </h3>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                            
                            <!-- Collection Date -->
                            <div>
                                <label for="collection_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Collection Date <span class="text-red-500">*</span></label>
                                <input type="date" name="collection_date" id="collection_date" value="{{ old('collection_date', $eggCollection->collection_date) }}" class="block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5" required>
                            </div>

                            <!-- Egg Count -->
                            <div>
                                <label for="egg_count" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Egg Count <span class="text-red-500">*</span></label>
                                <input type="number" name="egg_count" id="egg_count" value="{{ old('egg_count', $eggCollection->egg_count) }}" min="1" class="block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5" required>
                            </div>

                            <!-- Dam Selection -->
                            <div>
                                <label for="dam_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Dam (Hen) <span class="text-red-500">*</span></label>
                                <select name="dam_id" id="dam_id" class="block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5" required>
                                    <option value="">Select Dam</option>
                                    @foreach($dams as $dam)
                                        <option value="{{ $dam->id }}" {{ old('dam_id', $eggCollection->dam_id) == $dam->id ? 'selected' : '' }}>
                                            {{ $dam->tag_id }} - {{ $dam->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Sire Selection -->
                            <div>
                                <label for="sire_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sire (Rooster) <span class="text-red-500">*</span></label>
                                <select name="sire_id" id="sire_id" class="block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5" required>
                                    <option value="">Select Sire</option>
                                    @foreach($sires as $sire)
                                        <option value="{{ $sire->id }}" {{ old('sire_id', $eggCollection->sire_id) == $sire->id ? 'selected' : '' }}>
                                            {{ $sire->tag_id }} - {{ $sire->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Condition -->
                            <div>
                                <label for="egg_condition" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Egg Condition <span class="text-red-500">*</span></label>
                                <select name="egg_condition" id="egg_condition" class="block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5" required>
                                    <option value="">Select Condition</option>
                                    <option value="Normal" {{ old('egg_condition', $eggCollection->egg_condition) == 'Normal' ? 'selected' : '' }}>Normal</option>
                                    <option value="Cracked" {{ old('egg_condition', $eggCollection->egg_condition) == 'Cracked' ? 'selected' : '' }}>Cracked</option>
                                    <option value="Deformed" {{ old('egg_condition', $eggCollection->egg_condition) == 'Deformed' ? 'selected' : '' }}>Deformed</option>
                                </select>
                            </div>

                            <!-- Collection Staff -->
                            <div>
                                <label for="collection_staff" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Collection Staff <span class="text-red-500">*</span></label>
                                <input type="text" name="collection_staff" id="collection_staff" value="{{ old('collection_staff', $eggCollection->collection_staff) }}" class="block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5" required>
                            </div>
                            
                             <!-- Storage Location -->
                             <div>
                                <label for="storage_location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Storage Location <span class="text-red-500">*</span></label>
                                <select name="storage_location" id="storage_location" class="block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5" required>
                                    <option value="">Select Location</option>
                                    <option value="Incubator" {{ old('storage_location', $eggCollection->storage_location) == 'Incubator' ? 'selected' : '' }}>Incubator</option>
                                    <option value="Storage Room" {{ old('storage_location', $eggCollection->storage_location) == 'Storage Room' ? 'selected' : '' }}>Storage Room</option>
                                </select>
                            </div>
                            
                            <!-- Incubation Status -->
                             <div>
                                <label for="incubation_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Incubation Status</label>
                                <select name="incubation_status" id="incubation_status" class="block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5">
                                    <option value="Pending" {{ old('incubation_status', $eggCollection->incubation_status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Incubating" {{ old('incubation_status', $eggCollection->incubation_status) == 'Incubating' ? 'selected' : '' }}>Incubating</option>
                                    <option value="Hatched" {{ old('incubation_status', $eggCollection->incubation_status) == 'Hatched' ? 'selected' : '' }}>Hatched</option>
                                    <option value="Failed" {{ old('incubation_status', $eggCollection->incubation_status) == 'Failed' ? 'selected' : '' }}>Failed</option>
                                </select>
                            </div>

                        </div>
                    </div>
                    
                    <!-- Section 2: Additional Info -->
                    <div class="bg-white dark:bg-zinc-900 shadow-sm rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
                        <div class="px-6 py-4 border-b border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
                             <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Additional Information
                            </h3>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Incubation Start Date -->
                            <div>
                                <label for="incubation_start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Incubation Start Date</label>
                                <input type="date" name="incubation_start_date" id="incubation_start_date" value="{{ old('incubation_start_date', $eggCollection->incubation_start_date) }}" class="block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5">
                            </div>

                            <!-- Expected Hatch Date -->
                            <div>
                                <label for="expected_hatch_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Expected Hatch Date</label>
                                <input type="date" name="expected_hatch_date" id="expected_hatch_date" value="{{ old('expected_hatch_date', $eggCollection->expected_hatch_date) }}" class="block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5">
                            </div>
                            
                            <!-- Hatched Count -->
                            <div>
                                <label for="hatched_count" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hatched Count</label>
                                <input type="number" name="hatched_count" id="hatched_count" value="{{ old('hatched_count', $eggCollection->hatched_count) }}" class="block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5">
                            </div>

                             <!-- Remarks -->
                            <div class="md:col-span-2">
                                <label for="remarks" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Remarks</label>
                                <textarea name="remarks" id="remarks" rows="3" class="block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5">{{ old('remarks', $eggCollection->remarks) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-4">
                        <a href="{{ route('staff.egg-collections.index') }}" class="px-6 py-2.5 border border-gray-300 dark:border-zinc-700 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 border border-transparent text-white font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors shadow-lg shadow-indigo-500/20">
                            Update Collection
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
