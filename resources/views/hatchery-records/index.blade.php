<x-layouts.app>
    @php
        $routePrefix = request()->routeIs('admin.*') ? 'admin.' : 'staff.';
    @endphp
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Hatchery Records') }}</h1>
        <a href="{{ route($routePrefix . 'hatchery-records.create') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150">
            {{ __('New Record') }}
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded dark:bg-green-900 dark:border-green-600 dark:text-green-300">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg border border-slate-200 dark:border-slate-700">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                <thead class="bg-gray-50 dark:bg-slate-900">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Collection') }}</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Incubator') }}</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Temp / Hum.') }}</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Eggs') }}</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Hatched') }}</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Hatch %') }}</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                    @forelse ($hatcheryRecords as $record)
                        <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                <div class="font-bold text-slate-800 dark:text-slate-100">#{{ $record->egg_collection_id }}</div>
                                <div class="text-xs text-slate-400">{{ $record->eggCollection->collection_date?->format('M d, Y') ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                {{ $record->incubator_id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                <span class="px-2 py-0.5 rounded bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 text-xs">{{ $record->temperature }}°C</span>
                                <span class="px-2 py-0.5 rounded bg-cyan-100 dark:bg-cyan-900/40 text-cyan-700 dark:text-cyan-300 text-xs ml-1">{{ $record->humidity }}%</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-slate-700 dark:text-slate-300">
                                {{ $record->eggCollection->egg_count ?? 0 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-emerald-600 dark:text-emerald-400">
                                {{ $record->eggCollection->hatched_count ?? 0 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @php
                                    $rate = $record->hatch_rate ?? ($record->eggCollection && $record->eggCollection->incubated_count > 0 
                                        ? round(($record->eggCollection->hatched_count / $record->eggCollection->incubated_count) * 100, 2)
                                        : null);
                                @endphp
                                @if($rate !== null)
                                    <div class="flex items-center gap-2">
                                        <div class="w-12 bg-gray-200 dark:bg-slate-700 rounded-full h-1.5 overflow-hidden">
                                            <div class="bg-emerald-500 h-1.5" style="width: {{ $rate }}%"></div>
                                        </div>
                                        <span class="text-xs font-semibold text-slate-600 dark:text-slate-400">{{ $rate }}%</span>
                                    </div>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route($routePrefix . 'hatchery-records.show', $record) }}" class="text-gray-500 hover:text-emerald-600 dark:text-gray-400 dark:hover:text-emerald-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route($routePrefix . 'hatchery-records.edit', $record) }}" class="text-gray-500 hover:text-green-600 dark:text-gray-400 dark:hover:text-green-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                No hatchery records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($hatcheryRecords->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900">
                {{ $hatcheryRecords->links() }}
            </div>
        @endif
    </div>
</x-layouts.app>
