<x-layouts.app>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-gray-100 leading-tight">
                    {{ __('New Egg Collection') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Record a new batch of eggs collected from breeders.
                </p>
            </div>
            <a href="{{ route('staff.egg-collections.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-700 rounded-lg font-medium text-sm text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('staff.egg-collections.store') }}" method="POST">
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
                                    <h3 class="text-sm font-medium text-red-800 dark:text-red-200">There were errors with your submission</h3>
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

                    {{-- Info banner about the flow --}}
                    <div class="rounded-xl bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 p-4 flex gap-3">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="text-sm text-emerald-800 dark:text-emerald-300">
                            <p class="font-semibold">Collection → Incubation → Results</p>
                            <p class="mt-1 opacity-80">Record how many eggs were collected today. After saving, you can track incubation and hatching from the Edit page.</p>
                        </div>
                    </div>

                    <!-- Section 1: Collection Details -->
                    <div class="bg-white dark:bg-slate-900 shadow-sm rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                                Collection Details
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Basic information about the egg collection.</p>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- Collection Date -->
                            <div>
                                <label for="collection_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Collection Date <span class="text-red-500">*</span></label>
                                <input type="date" name="collection_date" id="collection_date" value="{{ old('collection_date', date('Y-m-d')) }}" class="block w-full rounded-lg border-gray-300 dark:border-slate-700 dark:bg-slate-900/50 dark:text-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm py-2.5" required>
                            </div>

                            <!-- Egg Count -->
                            <div>
                                <label for="egg_count" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Total Eggs Collected <span class="text-red-500">*</span></label>
                                <input type="number" name="egg_count" id="egg_count" value="{{ old('egg_count') }}" min="1" placeholder="e.g. 50" class="block w-full rounded-lg border-gray-300 dark:border-slate-700 dark:bg-slate-900/50 dark:text-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm py-2.5" required>
                            </div>

                            <!-- Breeding Selection -->
                            <div class="md:col-span-2">
                                <label for="breeding_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Completed Breeding <span class="text-red-500">*</span></label>
                                <select name="breeding_id" id="breeding_id" class="block w-full rounded-lg border-gray-300 dark:border-slate-700 dark:bg-slate-900/50 dark:text-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm py-2.5" required>
                                    <option value="">Select Breeding</option>
                                    @foreach($breedings as $breeding)
                                        <option value="{{ $breeding->id }}" {{ old('breeding_id') == $breeding->id ? 'selected' : '' }}>
                                            Pen {{ $breeding->pen_number }} | Sire: {{ $breeding->sire->name ?? 'Unknown' }} × Dam: {{ $breeding->dam->name ?? 'Unknown' }} ({{ $breeding->breeding_date ? \Carbon\Carbon::parse($breeding->breeding_date)->format('M d, Y') : '' }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Egg Condition -->
                            <div>
                                <label for="egg_condition" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Egg Condition <span class="text-red-500">*</span></label>
                                <select name="egg_condition" id="egg_condition" class="block w-full rounded-lg border-gray-300 dark:border-slate-700 dark:bg-slate-900/50 dark:text-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm py-2.5" required>
                                    <option value="">Select Condition</option>
                                    <option value="Normal" {{ old('egg_condition') == 'Normal' ? 'selected' : '' }}>Normal</option>
                                    <option value="Cracked" {{ old('egg_condition') == 'Cracked' ? 'selected' : '' }}>Cracked</option>
                                    <option value="Deformed" {{ old('egg_condition') == 'Deformed' ? 'selected' : '' }}>Deformed</option>
                                </select>
                            </div>

                            <!-- Collection Staff -->
                            <div>
                                <label for="collection_staff" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Collection Staff <span class="text-red-500">*</span></label>
                                <input type="text" name="collection_staff" id="collection_staff" value="{{ old('collection_staff', auth()->user()->name) }}" class="block w-full rounded-lg border-gray-300 dark:border-slate-700 dark:bg-slate-900/50 dark:text-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm py-2.5" required>
                            </div>

                            <!-- Storage Location -->
                            <div>
                                <label for="storage_location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Storage Location <span class="text-red-500">*</span></label>
                                <select name="storage_location" id="storage_location" class="block w-full rounded-lg border-gray-300 dark:border-slate-700 dark:bg-slate-900/50 dark:text-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm py-2.5" required>
                                    <option value="">Select Location</option>
                                    <option value="Incubator" {{ old('storage_location') == 'Incubator' ? 'selected' : '' }}>Incubator</option>
                                    <option value="Storage Room" {{ old('storage_location') == 'Storage Room' ? 'selected' : '' }}>Storage Room</option>
                                </select>
                            </div>

                            <!-- Remarks -->
                            <div class="md:col-span-2">
                                <label for="remarks" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Remarks</label>
                                <textarea name="remarks" id="remarks" rows="3" placeholder="Optional notes about this collection…" class="block w-full rounded-lg border-gray-300 dark:border-slate-700 dark:bg-slate-900/50 dark:text-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm py-2.5">{{ old('remarks') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-4">
                        <a href="{{ route('staff.egg-collections.index') }}" class="px-6 py-2.5 border border-gray-300 dark:border-slate-700 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 border border-transparent text-white font-medium rounded-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-colors shadow-lg shadow-emerald-500/20">
                            Save Collection
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
