<x-layouts.app>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-gray-100 leading-tight">
                    {{ __('Edit Egg Collection') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Track incubation progress for this batch.
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
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @php
                $routePrefix = request()->routeIs('admin.*') ? 'admin.' : 'staff.';
            @endphp
            <form action="{{ route($routePrefix . 'egg-collections.update', $eggCollection) }}" method="POST" id="egg-edit-form">
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

                    {{-- Hatch Date Due Alert --}}
                    @if($eggCollection->expected_hatch_date && \Carbon\Carbon::parse($eggCollection->expected_hatch_date)->lte(\Carbon\Carbon::today()) && $eggCollection->incubation_status !== 'Completed')
                        <div class="rounded-xl bg-amber-50 dark:bg-amber-900/30 border border-amber-300 dark:border-amber-700 p-4 flex gap-3">
                            <div class="flex-shrink-0">
                                <div class="w-9 h-9 rounded-full bg-amber-100 dark:bg-amber-900/50 flex items-center justify-center">
                                    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-amber-800 dark:text-amber-300">
                                    Hatch Date Reached — {{ \Carbon\Carbon::parse($eggCollection->expected_hatch_date)->format('M d, Y') }}
                                </p>
                                <p class="text-sm text-amber-700 dark:text-amber-400 mt-0.5">
                                    The expected hatch date has passed. Please enter the <strong>Hatched</strong> and <strong>Failed</strong> counts below to complete this record. Saving this form will automatically set the status to <strong>Completed</strong>.
                                </p>
                            </div>
                        </div>
                    @endif

                    {{-- Live Egg Tracker Summary --}}
                    <div class="bg-white dark:bg-slate-900 shadow-sm rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                Live Egg Tracker
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Updates automatically as you adjust the numbers below.</p>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                {{-- Total --}}
                                <div class="bg-slate-50 dark:bg-slate-800/60 rounded-xl p-4 text-center border border-slate-200 dark:border-slate-700">
                                    <div class="text-3xl font-black text-slate-800 dark:text-slate-100" id="tracker-total">{{ $eggCollection->egg_count }}</div>
                                    <div class="flex items-center justify-center gap-1 mt-2">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8l1 12a2 2 0 002 2h8a2 2 0 002-2L19 8"/></svg>
                                        <div class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Total Collected</div>
                                    </div>
                                </div>
                                {{-- Remaining --}}
                                <div class="bg-blue-50 dark:bg-blue-900/30 rounded-xl p-4 text-center border border-blue-200 dark:border-blue-800">
                                    <div class="text-3xl font-black text-blue-700 dark:text-blue-300" id="tracker-remaining">{{ $eggCollection->remaining_eggs }}</div>
                                    <div class="flex items-center justify-center gap-1 mt-2">
                                        <svg class="w-3.5 h-3.5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                        <div class="text-xs font-semibold text-blue-600 dark:text-blue-400 uppercase tracking-widest">Not Incubated</div>
                                    </div>
                                </div>
                                {{-- Hatched --}}
                                <div class="bg-emerald-50 dark:bg-emerald-900/30 rounded-xl p-4 text-center border border-emerald-200 dark:border-emerald-800">
                                    <div class="text-3xl font-black text-emerald-700 dark:text-emerald-300" id="tracker-hatched">{{ $eggCollection->hatched_count ?? 0 }}</div>
                                    <div class="flex items-center justify-center gap-1 mt-2">
                                        <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <div class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest">Hatched</div>
                                    </div>
                                </div>
                                {{-- Failed --}}
                                <div class="bg-red-50 dark:bg-red-900/30 rounded-xl p-4 text-center border border-red-200 dark:border-red-800">
                                    <div class="text-3xl font-black text-red-700 dark:text-red-300" id="tracker-failed">{{ $eggCollection->failed_count ?? 0 }}</div>
                                    <div class="flex items-center justify-center gap-1 mt-2">
                                        <svg class="w-3.5 h-3.5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <div class="text-xs font-semibold text-red-600 dark:text-red-400 uppercase tracking-widest">Failed</div>
                                    </div>
                                </div>
                            </div>

                            {{-- Progress bar --}}
                            <div class="mt-5">
                                <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mb-1">
                                    <span>Incubation progress</span>
                                    <span id="tracker-balance-label">
                                        @php
                                            $balance = $eggCollection->incubation_balance;
                                        @endphp
                                        @if($balance > 0)
                                            <span class="inline-flex items-center gap-1"><svg class="w-3.5 h-3.5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> {{ $balance }} egg(s) still incubating</span>
                                        @else
                                            <span class="inline-flex items-center gap-1"><svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> All incubated eggs accounted for</span>
                                        @endif
                                    </span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-3 overflow-hidden flex">
                                    @php
                                        $total     = max(1, $eggCollection->incubated_count ?? 0);
                                        $hPct      = round((($eggCollection->hatched_count ?? 0) / $total) * 100);
                                        $fPct      = round((($eggCollection->failed_count  ?? 0) / $total) * 100);
                                    @endphp
                                    <div id="bar-hatched" class="bg-emerald-500 h-3 transition-all" style="width: {{ $hPct }}%"></div>
                                    <div id="bar-failed"  class="bg-red-500 h-3 transition-all"     style="width: {{ $fPct }}%"></div>
                                </div>
                            </div>
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
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- Collection Date -->
                            <div>
                                <label for="collection_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Collection Date <span class="text-red-500">*</span></label>
                                <input type="date" name="collection_date" id="collection_date" value="{{ old('collection_date', $eggCollection->collection_date?->format('Y-m-d')) }}" class="block w-full rounded-lg border-gray-300 dark:border-slate-700 dark:bg-slate-900/50 dark:text-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm py-2.5" required>
                            </div>

                            <!-- Egg Count (Total) -->
                            <div>
                                <label for="egg_count" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Total Eggs Collected <span class="text-red-500">*</span></label>
                                <input type="number" name="egg_count" id="egg_count" value="{{ old('egg_count', $eggCollection->egg_count) }}" min="1" class="block w-full rounded-lg border-gray-300 dark:border-slate-700 dark:bg-slate-900/50 dark:text-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm py-2.5" required>
                            </div>

                            <!-- Dam -->
                            <div>
                                <label for="dam_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Dam (Hen) <span class="text-red-500">*</span></label>
                                <select name="dam_id" id="dam_id" class="block w-full rounded-lg border-gray-300 dark:border-slate-700 dark:bg-slate-900/50 dark:text-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm py-2.5" required>
                                    <option value="">Select Dam</option>
                                    @foreach($dams as $dam)
                                        <option value="{{ $dam->id }}" {{ old('dam_id', $eggCollection->dam_id) == $dam->id ? 'selected' : '' }}>
                                            {{ $dam->tag_id }} - {{ $dam->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Sire -->
                            <div>
                                <label for="sire_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sire (Rooster) <span class="text-red-500">*</span></label>
                                <select name="sire_id" id="sire_id" class="block w-full rounded-lg border-gray-300 dark:border-slate-700 dark:bg-slate-900/50 dark:text-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm py-2.5" required>
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
                                <select name="egg_condition" id="egg_condition" class="block w-full rounded-lg border-gray-300 dark:border-slate-700 dark:bg-slate-900/50 dark:text-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm py-2.5" required>
                                    <option value="">Select Condition</option>
                                    <option value="Normal"   {{ old('egg_condition', $eggCollection->egg_condition) == 'Normal'   ? 'selected' : '' }}>Normal</option>
                                    <option value="Cracked"  {{ old('egg_condition', $eggCollection->egg_condition) == 'Cracked'  ? 'selected' : '' }}>Cracked</option>
                                    <option value="Deformed" {{ old('egg_condition', $eggCollection->egg_condition) == 'Deformed' ? 'selected' : '' }}>Deformed</option>
                                </select>
                            </div>

                            <!-- Collection Staff -->
                            <div>
                                <label for="collection_staff" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Collection Staff <span class="text-red-500">*</span></label>
                                <input type="text" name="collection_staff" id="collection_staff" value="{{ old('collection_staff', $eggCollection->collection_staff) }}" class="block w-full rounded-lg border-gray-300 dark:border-slate-700 dark:bg-slate-900/50 dark:text-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm py-2.5" required>
                            </div>

                            <!-- Storage Location -->
                            <div>
                                <label for="storage_location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Storage Location <span class="text-red-500">*</span></label>
                                <select name="storage_location" id="storage_location" class="block w-full rounded-lg border-gray-300 dark:border-slate-700 dark:bg-slate-900/50 dark:text-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm py-2.5" required>
                                    <option value="">Select Location</option>
                                    <option value="Incubator"    {{ old('storage_location', $eggCollection->storage_location) == 'Incubator'    ? 'selected' : '' }}>Incubator</option>
                                    <option value="Storage Room" {{ old('storage_location', $eggCollection->storage_location) == 'Storage Room' ? 'selected' : '' }}>Storage Room</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Incubation Tracking -->
                    <div class="bg-white dark:bg-slate-900 shadow-sm rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Incubation Tracking
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Track how many eggs moved to incubation and their results. Status is auto-computed.
                            </p>
                        </div>
                        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                            <!-- Incubation Start Date -->
                            <div>
                                <label for="incubation_start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Incubation Start Date</label>
                                <input type="date" name="incubation_start_date" id="incubation_start_date" value="{{ old('incubation_start_date', $eggCollection->incubation_start_date?->format('Y-m-d')) }}" class="block w-full rounded-lg border-gray-300 dark:border-slate-700 dark:bg-slate-900/50 dark:text-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm py-2.5">
                            </div>

                            <!-- Expected Hatch Date -->
                            <div>
                                <label for="expected_hatch_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Expected Hatch Date</label>
                                <input type="date" name="expected_hatch_date" id="expected_hatch_date" value="{{ old('expected_hatch_date', $eggCollection->expected_hatch_date?->format('Y-m-d')) }}" class="block w-full rounded-lg border-gray-300 dark:border-slate-700 dark:bg-slate-900/50 dark:text-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm py-2.5">
                            </div>

                            <!-- Incubated Count -->
                            <div class="md:col-span-2 bg-amber-50 dark:bg-amber-900/20 rounded-xl p-5 border border-amber-200 dark:border-amber-800">
                                <label for="incubated_count" class="block text-sm font-semibold text-amber-800 dark:text-amber-300 mb-1 flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v10.5a3.5 3.5 0 107 0V3m-7 0h7"/></svg>
                                    Eggs Sent to Incubation
                                </label>
                                <p class="text-xs text-amber-600 dark:text-amber-400 mb-3">
                                    Max: <strong id="incubated-max-label">{{ $eggCollection->egg_count }}</strong> (total collected)
                                </p>
                                <input type="number" name="incubated_count" id="incubated_count"
                                    value="{{ old('incubated_count', $eggCollection->incubated_count ?? 0) }}"
                                    min="0" max="{{ $eggCollection->egg_count }}"
                                    class="block w-full rounded-lg border-amber-300 dark:border-amber-700 dark:bg-slate-900/50 dark:text-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm py-2.5">
                                @error('incubated_count') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- Results section --}}
                            <div class="md:col-span-2">
                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Incubation Results</p>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Hatched Count -->
                                    <div class="bg-emerald-50 dark:bg-emerald-900/20 rounded-xl p-5 border border-emerald-200 dark:border-emerald-800">
                                        <label for="hatched_count" class="block text-sm font-semibold text-emerald-800 dark:text-emerald-300 mb-1 flex items-center gap-1.5">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Hatched
                                        </label>
                                        <p class="text-xs text-emerald-600 dark:text-emerald-400 mb-3">Eggs that successfully hatched.</p>
                                        <input type="number" name="hatched_count" id="hatched_count"
                                            value="{{ old('hatched_count', $eggCollection->hatched_count ?? 0) }}"
                                            min="0"
                                            class="block w-full rounded-lg border-emerald-300 dark:border-emerald-700 dark:bg-slate-900/50 dark:text-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm py-2.5">
                                        @error('hatched_count') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>

                                    <!-- Failed Count -->
                                    <div class="bg-red-50 dark:bg-red-900/20 rounded-xl p-5 border border-red-200 dark:border-red-800">
                                        <label for="failed_count" class="block text-sm font-semibold text-red-700 dark:text-red-300 mb-1 flex items-center gap-1.5">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Failed
                                        </label>
                                        <p class="text-xs text-red-500 dark:text-red-400 mb-3">Eggs that did not hatch.</p>
                                        <input type="number" name="failed_count" id="failed_count"
                                            value="{{ old('failed_count', $eggCollection->failed_count ?? 0) }}"
                                            min="0"
                                            class="block w-full rounded-lg border-red-300 dark:border-red-700 dark:bg-slate-900/50 dark:text-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm py-2.5">
                                        @error('failed_count') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                </div>

                                {{-- Live validation hint --}}
                                <div id="results-hint" class="mt-3 hidden rounded-lg p-3 text-sm font-medium"></div>
                            </div>

                            <!-- Remarks -->
                            <div class="md:col-span-2">
                                <label for="remarks" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Remarks</label>
                                <textarea name="remarks" id="remarks" rows="3" class="block w-full rounded-lg border-gray-300 dark:border-slate-700 dark:bg-slate-900/50 dark:text-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm py-2.5">{{ old('remarks', $eggCollection->remarks) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-4">
                        <a href="{{ route('staff.egg-collections.index') }}" class="px-6 py-2.5 border border-gray-300 dark:border-slate-700 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-colors">
                            Cancel
                        </a>
                        <button type="submit" class="px-6 py-2.5 bg-emerald-600 border border-transparent text-white font-medium rounded-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-colors shadow-lg shadow-emerald-500/20">
                            Update Collection
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        (function() {
            const totalInput     = document.getElementById('egg_count');
            const incubatedInput = document.getElementById('incubated_count');
            const hatchedInput   = document.getElementById('hatched_count');
            const failedInput    = document.getElementById('failed_count');

            const trackerTotal     = document.getElementById('tracker-total');
            const trackerRemaining = document.getElementById('tracker-remaining');
            const trackerHatched   = document.getElementById('tracker-hatched');
            const trackerFailed    = document.getElementById('tracker-failed');
            const balanceLabel     = document.getElementById('tracker-balance-label');
            const barHatched       = document.getElementById('bar-hatched');
            const barFailed        = document.getElementById('bar-failed');
            const hint             = document.getElementById('results-hint');

            function update() {
                const total     = parseInt(totalInput.value)     || 0;
                const incubated = parseInt(incubatedInput.value) || 0;
                const hatched   = parseInt(hatchedInput.value)   || 0;
                const failed    = parseInt(failedInput.value)    || 0;

                const remaining = Math.max(0, total - incubated);
                const balance   = Math.max(0, incubated - (hatched + failed));

                // Update tracker cards
                trackerTotal.textContent     = total;
                trackerRemaining.textContent = remaining;
                trackerHatched.textContent   = hatched;
                trackerFailed.textContent    = failed;

                // Balance label
                if (incubated === 0) {
                    balanceLabel.textContent = '—';
                } else if (balance > 0) {
                    balanceLabel.textContent = `${balance} egg(s) still incubating`;
                } else {
                    balanceLabel.textContent = 'All incubated eggs accounted for';
                }

                // Progress bar
                const denominator = incubated > 0 ? incubated : 1;
                barHatched.style.width = Math.round((hatched / denominator) * 100) + '%';
                barFailed.style.width  = Math.round((failed  / denominator) * 100) + '%';

                // Hint validation
                if (incubated > total) {
                    showHint(`Incubated (${incubated}) exceeds total collected (${total}).`, 'error');
                } else if ((hatched + failed) > incubated) {
                    showHint(`Hatched + Failed (${hatched + failed}) exceeds incubated (${incubated}).`, 'error');
                } else if (incubated > 0 && balance === 0) {
                    showHint(`All ${incubated} incubated eggs accounted for — ${hatched} hatched + ${failed} failed.`, 'success');
                } else {
                    hint.classList.add('hidden');
                }
            }

            function showHint(msg, type) {
                hint.textContent = msg;
                hint.className = 'mt-3 rounded-lg p-3 text-sm font-medium ' + (
                    type === 'error'
                        ? 'bg-red-50 text-red-700 border border-red-200 dark:bg-red-900/30 dark:text-red-300'
                        : 'bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-300'
                );
            }

            [totalInput, incubatedInput, hatchedInput, failedInput].forEach(el => {
                el.addEventListener('input', update);
            });

            update(); // run on page load
        })();
    </script>
</x-layouts.app>
