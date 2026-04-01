<x-layouts.app>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-gray-100 leading-tight">
                    {{ __('Egg Collection Details') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Batch #{{ $eggCollection->id }} — collected {{ $eggCollection->collection_date->format('M d, Y') }}
                </p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('staff.egg-collections.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-700 rounded-lg font-medium text-sm text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to List
                </a>
                <a href="{{ route('staff.egg-collections.edit', $eggCollection) }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg font-medium text-sm text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Update Tracking
                </a>
            </div>
        </div>
    </x-slot>

    @php
        $statusConfig = [
            'Pending'    => ['bg' => 'bg-slate-100 dark:bg-slate-800',         'text' => 'text-slate-600 dark:text-slate-300',   'label' => 'Pending'],
            'Incubating' => ['bg' => 'bg-amber-100 dark:bg-amber-900/40',      'text' => 'text-amber-700 dark:text-amber-300',   'label' => 'Incubating'],
            'Completed'  => ['bg' => 'bg-emerald-100 dark:bg-emerald-900/40',  'text' => 'text-emerald-700 dark:text-emerald-300','label' => 'Completed'],
        ];
        $status = $statusConfig[$eggCollection->incubation_status] ?? $statusConfig['Pending'];
    @endphp

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ── Egg Lifecycle Summary Cards ─────────────────────────────── --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                {{-- Total --}}
                <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 p-5 text-center shadow-sm">
                    <div class="flex justify-center mb-2">
                        <div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8l1 12a2 2 0 002 2h8a2 2 0 002-2L19 8"/></svg>
                        </div>
                    </div>
                    <div class="text-4xl font-black text-slate-800 dark:text-slate-100">{{ $eggCollection->egg_count }}</div>
                    <div class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-widest mt-2">Total Collected</div>
                </div>

                {{-- Not Incubated --}}
                <div class="bg-blue-50 dark:bg-blue-900/30 rounded-xl border border-blue-200 dark:border-blue-800 p-5 text-center shadow-sm">
                    <div class="flex justify-center mb-2">
                        <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                    </div>
                    <div class="text-4xl font-black text-blue-700 dark:text-blue-300">{{ $eggCollection->remaining_eggs }}</div>
                    <div class="text-xs font-semibold text-blue-600 dark:text-blue-400 uppercase tracking-widest mt-2">Not Incubated</div>
                </div>

                {{-- Hatched --}}
                <div class="bg-emerald-50 dark:bg-emerald-900/30 rounded-xl border border-emerald-200 dark:border-emerald-800 p-5 text-center shadow-sm">
                    <div class="flex justify-center mb-2">
                        <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <div class="text-4xl font-black text-emerald-700 dark:text-emerald-300">{{ $eggCollection->hatched_count ?? 0 }}</div>
                    <div class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest mt-2">Hatched</div>
                </div>

                {{-- Failed --}}
                <div class="bg-red-50 dark:bg-red-900/30 rounded-xl border border-red-200 dark:border-red-800 p-5 text-center shadow-sm">
                    <div class="flex justify-center mb-2">
                        <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                    <div class="text-4xl font-black text-red-700 dark:text-red-300">{{ $eggCollection->failed_count ?? 0 }}</div>
                    <div class="text-xs font-semibold text-red-600 dark:text-red-400 uppercase tracking-widest mt-2">Failed</div>
                </div>
            </div>

            {{-- ── Auto-computed Calculations ───────────────────────────────── --}}
            <div class="bg-white dark:bg-slate-900 shadow-sm rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 11h.01M12 11h.01M15 11h.01M4 19h16a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Auto-computed Calculations
                    </h3>
                </div>
                <div class="p-6">
                    @php
                        $incubated = $eggCollection->incubated_count ?? 0;
                        $hatched   = $eggCollection->hatched_count   ?? 0;
                        $failed    = $eggCollection->failed_count    ?? 0;
                        $remaining = $eggCollection->remaining_eggs;
                        $balance   = $eggCollection->incubation_balance;
                    @endphp

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm mb-5">
                        <div class="flex flex-col gap-1">
                            <span class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">Incubated</span>
                            <span class="font-bold text-gray-900 dark:text-white text-lg">{{ $incubated }}</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">Remaining (not incubated)</span>
                            <span class="font-bold text-blue-700 dark:text-blue-300 text-lg">{{ $remaining }}</span>
                            <span class="text-xs text-gray-400 font-mono">= {{ $eggCollection->egg_count }} − {{ $incubated }}</span>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">Incubation Balance</span>
                            <span class="font-bold text-lg {{ $balance === 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-amber-600 dark:text-amber-400' }}">{{ $balance }}</span>
                            <span class="text-xs text-gray-400 font-mono">= {{ $incubated }} − ({{ $hatched }} + {{ $failed }})</span>
                        </div>
                    </div>

                    @if($incubated > 0)
                    <div class="mt-2">
                        <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mb-1">
                            <span>Incubation results</span>
                            <span>{{ $hatched + $failed }} / {{ $incubated }} resolved</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-slate-700 rounded-full h-4 overflow-hidden flex">
                            <div class="bg-emerald-500 h-4 flex items-center justify-center text-[10px] font-bold text-white transition-all" style="width: {{ round(($hatched / max(1,$incubated)) * 100) }}%">
                                @if($hatched > 0) {{ $hatched }} @endif
                            </div>
                            <div class="bg-red-500 h-4 flex items-center justify-center text-[10px] font-bold text-white transition-all" style="width: {{ round(($failed / max(1,$incubated)) * 100) }}%">
                                @if($failed > 0) {{ $failed }} @endif
                            </div>
                        </div>
                        <div class="flex gap-4 mt-2 text-xs text-gray-500">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-3 h-3 text-emerald-500" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="4"/></svg>
                                Hatched
                            </span>
                            <span class="flex items-center gap-1.5">
                                <svg class="w-3 h-3 text-red-500" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="4"/></svg>
                                Failed
                            </span>
                            <span class="flex items-center gap-1.5">
                                <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="4"/></svg>
                                Still Incubating
                            </span>
                        </div>
                    </div>
                    @endif

                    {{-- Status badge --}}
                    <div class="mt-4 flex items-center gap-2">
                        <span class="text-xs text-gray-500 dark:text-gray-400">Auto-status:</span>
                        <span class="px-3 py-1 text-xs font-bold rounded-full {{ $status['bg'] }} {{ $status['text'] }}">
                            {{ $status['label'] }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- ── Collection Information ────────────────────────────────────── --}}
            <div class="bg-white dark:bg-slate-900 shadow-sm rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        Collection Information
                    </h3>
                </div>
                <div class="px-6 py-4">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 text-sm">
                        <div>
                            <dt class="text-gray-500 dark:text-gray-400">Dam (Hen)</dt>
                            <dd class="mt-1 font-medium text-gray-900 dark:text-white">{{ $eggCollection->dam->tag_id }} — {{ $eggCollection->dam->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 dark:text-gray-400">Sire (Rooster)</dt>
                            <dd class="mt-1 font-medium text-gray-900 dark:text-white">{{ $eggCollection->sire->tag_id }} — {{ $eggCollection->sire->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 dark:text-gray-400">Egg Condition</dt>
                            <dd class="mt-1">
                                <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full
                                    @if($eggCollection->egg_condition === 'Normal') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($eggCollection->egg_condition === 'Cracked') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @endif">
                                    {{ $eggCollection->egg_condition }}
                                </span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 dark:text-gray-400">Collected By</dt>
                            <dd class="mt-1 font-medium text-gray-900 dark:text-white">{{ $eggCollection->collection_staff }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 dark:text-gray-400">Storage Location</dt>
                            <dd class="mt-1 font-medium text-gray-900 dark:text-white">{{ $eggCollection->storage_location }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 dark:text-gray-400">Incubation Start Date</dt>
                            <dd class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $eggCollection->incubation_start_date ? $eggCollection->incubation_start_date->format('M d, Y') : '—' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-gray-500 dark:text-gray-400">Expected Hatch Date</dt>
                            <dd class="mt-1 font-medium text-gray-900 dark:text-white">
                                {{ $eggCollection->expected_hatch_date ? $eggCollection->expected_hatch_date->format('M d, Y') : '—' }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            @if($eggCollection->remarks)
            <div class="bg-white dark:bg-slate-900 shadow-sm rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                        Remarks
                    </h3>
                </div>
                <div class="px-6 py-4">
                    <p class="text-sm text-gray-900 dark:text-gray-100">{{ $eggCollection->remarks }}</p>
                </div>
            </div>
            @endif

            <!-- Delete Action -->
            <div class="flex justify-end">
                <form action="{{ route('staff.egg-collections.destroy', $eggCollection) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium text-sm">
                        Delete Egg Collection
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-layouts.app>
