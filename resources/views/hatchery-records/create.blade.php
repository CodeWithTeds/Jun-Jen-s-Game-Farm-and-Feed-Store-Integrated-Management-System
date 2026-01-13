<x-layouts.app>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-gray-100 leading-tight">
                    {{ __('New Hatchery Record') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Track incubation details for an egg collection.
                </p>
            </div>
            <a href="{{ route('staff.hatchery-records.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-lg font-medium text-sm text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('staff.hatchery-records.store') }}" method="POST">
                @csrf
                
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

                    <!-- Section 1: Incubator Setup -->
                    <div class="bg-white dark:bg-zinc-900 shadow-sm rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
                        <div class="px-6 py-4 border-b border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                </svg>
                                Incubator Setup
                            </h3>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                            
                            <!-- Egg Collection ID -->
                            <div class="md:col-span-2">
                                <label for="egg_collection_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Egg Collection <span class="text-red-500">*</span></label>
                                <select name="egg_collection_id" id="egg_collection_id" class="block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5" required>
                                    <option value="">Select Egg Collection</option>
                                    @foreach($eggCollections as $collection)
                                        <option value="{{ $collection->id }}" {{ old('egg_collection_id') == $collection->id ? 'selected' : '' }}>
                                            #{{ $collection->id }} - {{ $collection->collection_date }} ({{ $collection->egg_count }} eggs)
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Incubator ID -->
                            <div>
                                <label for="incubator_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Incubator ID <span class="text-red-500">*</span></label>
                                <input type="text" name="incubator_id" id="incubator_id" value="{{ old('incubator_id') }}" placeholder="e.g. INC-01" class="block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5" required>
                            </div>

                            <!-- Turning Schedule -->
                            <div>
                                <label for="turning_schedule" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Turning Schedule <span class="text-red-500">*</span></label>
                                <input type="text" name="turning_schedule" id="turning_schedule" value="{{ old('turning_schedule', 'Every 4 hours') }}" class="block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5" required>
                            </div>

                            <!-- Temperature -->
                            <div>
                                <label for="temperature" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Temperature (°C) <span class="text-red-500">*</span></label>
                                <input type="number" step="0.1" name="temperature" id="temperature" value="{{ old('temperature', '37.5') }}" class="block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5" required>
                            </div>

                            <!-- Humidity -->
                            <div>
                                <label for="humidity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Humidity (%) <span class="text-red-500">*</span></label>
                                <input type="number" step="0.1" name="humidity" id="humidity" value="{{ old('humidity', '55.0') }}" class="block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5" required>
                            </div>

                        </div>
                    </div>
                    
                    <!-- Section 2: Progress -->
                    <div class="bg-white dark:bg-zinc-900 shadow-sm rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
                        <div class="px-6 py-4 border-b border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
                             <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                Monitoring Progress
                            </h3>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Candling Date -->
                            <div>
                                <label for="candling_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Candling Date</label>
                                <input type="date" name="candling_date" id="candling_date" value="{{ old('candling_date') }}" class="block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5">
                            </div>

                            <!-- Fertility Rate -->
                            <div>
                                <label for="fertility_rate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fertility Rate (%)</label>
                                <input type="number" step="0.01" name="fertility_rate" id="fertility_rate" value="{{ old('fertility_rate') }}" class="block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5">
                            </div>
                            
                            <!-- Hatch Rate -->
                            <div>
                                <label for="hatch_rate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hatch Rate (%)</label>
                                <input type="number" step="0.01" name="hatch_rate" id="hatch_rate" value="{{ old('hatch_rate') }}" class="block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5">
                            </div>
                            
                             <!-- Hatch Result -->
                            <div>
                                <label for="hatch_result" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hatch Result</label>
                                <select name="hatch_result" id="hatch_result" class="block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5">
                                    <option value="">Select Result</option>
                                    <option value="Successful" {{ old('hatch_result') == 'Successful' ? 'selected' : '' }}>Successful</option>
                                    <option value="Partial" {{ old('hatch_result') == 'Partial' ? 'selected' : '' }}>Partial</option>
                                    <option value="Failed" {{ old('hatch_result') == 'Failed' ? 'selected' : '' }}>Failed</option>
                                </select>
                            </div>

                             <!-- Remarks -->
                            <div class="md:col-span-2">
                                <label for="remarks" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Remarks</label>
                                <textarea name="remarks" id="remarks" rows="3" class="block w-full rounded-lg border-gray-300 dark:border-zinc-700 dark:bg-zinc-900/50 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5">{{ old('remarks') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-4">
                        <a href="{{ route('staff.hatchery-records.index') }}" class="px-6 py-2.5 border border-gray-300 dark:border-zinc-700 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 border border-transparent text-white font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors shadow-lg shadow-indigo-500/20">
                            Save Record
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
