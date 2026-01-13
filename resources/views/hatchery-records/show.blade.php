<x-layouts.app>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-gray-100 leading-tight">
                    {{ __('Hatchery Record Details') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Viewing incubation details for collection #{{ $hatcheryRecord->egg_collection_id }}
                </p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('staff.hatchery-records.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-lg font-medium text-sm text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to List
                </a>
                <a href="{{ route('staff.hatchery-records.edit', $hatcheryRecord) }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-medium text-sm text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Record
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Incubator Details -->
            <div class="bg-white dark:bg-zinc-900 shadow-sm rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                        Incubator Settings
                    </h3>
                </div>
                <div class="px-6 py-4">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Egg Collection</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                <a href="{{ route('staff.egg-collections.show', $hatcheryRecord->egg_collection_id) }}" class="text-indigo-600 hover:text-indigo-900">
                                    #{{ $hatcheryRecord->egg_collection_id }}
                                </a>
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Incubator ID</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $hatcheryRecord->incubator_id }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Temperature</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $hatcheryRecord->temperature }}°C</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Humidity</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $hatcheryRecord->humidity }}%</dd>
                        </div>
                         <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Turning Schedule</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $hatcheryRecord->turning_schedule }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Monitoring Progress -->
            <div class="bg-white dark:bg-zinc-900 shadow-sm rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Monitoring Progress
                    </h3>
                </div>
                <div class="px-6 py-4">
                     <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Candling Date</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $hatcheryRecord->candling_date ? \Carbon\Carbon::parse($hatcheryRecord->candling_date)->format('M d, Y') : 'N/A' }}
                            </dd>
                        </div>
                         <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fertility Rate</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $hatcheryRecord->fertility_rate ? $hatcheryRecord->fertility_rate . '%' : 'N/A' }}
                            </dd>
                        </div>
                         <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Hatch Rate</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $hatcheryRecord->hatch_rate ? $hatcheryRecord->hatch_rate . '%' : 'N/A' }}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Result</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($hatcheryRecord->hatch_result === 'Successful') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($hatcheryRecord->hatch_result === 'Partial') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                    @elseif($hatcheryRecord->hatch_result === 'Failed') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif">
                                    {{ $hatcheryRecord->hatch_result ?? 'Pending' }}
                                </span>
                            </dd>
                        </div>
                     </dl>
                </div>
            </div>

             <!-- Remarks -->
            @if($hatcheryRecord->remarks)
                <div class="bg-white dark:bg-zinc-900 shadow-sm rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden">
                    <div class="px-6 py-4 border-b border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                            </svg>
                            Remarks
                        </h3>
                    </div>
                    <div class="px-6 py-4">
                        <p class="text-sm text-gray-900 dark:text-gray-100">{{ $hatcheryRecord->remarks }}</p>
                    </div>
                </div>
            @endif
            
            <!-- Delete Action -->
            <div class="mt-8 flex justify-end">
                <form action="{{ route('staff.hatchery-records.destroy', $hatcheryRecord) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-900 font-medium text-sm">
                        Delete Hatchery Record
                    </button>
                </form>
            </div>
            
        </div>
    </div>
</x-layouts.app>
