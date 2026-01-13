<x-layouts.app>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-gray-100 leading-tight">
                    {{ __('Egg Collection Details') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Viewing details for collection #{{ $eggCollection->id }}
                </p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('staff.egg-collections.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-lg font-medium text-sm text-gray-700 dark:text-gray-300 shadow-sm hover:bg-gray-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to List
                </a>
                <a href="{{ route('staff.egg-collections.edit', $eggCollection) }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-medium text-sm text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Collection
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Collection Details -->
            <div class="bg-white dark:bg-zinc-900 shadow-sm rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        Collection Information
                    </h3>
                </div>
                <div class="px-6 py-4">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Collection Date</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($eggCollection->collection_date)->format('M d, Y') }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Egg Count</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $eggCollection->egg_count }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Dam (Hen)</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $eggCollection->dam->tag_id }} - {{ $eggCollection->dam->name }}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Sire (Rooster)</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $eggCollection->sire->tag_id }} - {{ $eggCollection->sire->name }}
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Condition</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($eggCollection->egg_condition === 'Normal') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($eggCollection->egg_condition === 'Cracked') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @endif">
                                    {{ $eggCollection->egg_condition }}
                                </span>
                            </dd>
                        </div>
                         <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Collected By</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $eggCollection->collection_staff }}</dd>
                        </div>
                         <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Storage Location</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $eggCollection->storage_location }}</dd>
                        </div>
                         <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Incubation Status</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $eggCollection->incubation_status }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Incubation Details -->
            <div class="bg-white dark:bg-zinc-900 shadow-sm rounded-xl border border-zinc-200 dark:border-zinc-800 overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Incubation Progress
                    </h3>
                </div>
                <div class="px-6 py-4">
                     <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Start Date</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $eggCollection->incubation_start_date ? \Carbon\Carbon::parse($eggCollection->incubation_start_date)->format('M d, Y') : 'Not Started' }}
                            </dd>
                        </div>
                         <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Expected Hatch Date</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $eggCollection->expected_hatch_date ? \Carbon\Carbon::parse($eggCollection->expected_hatch_date)->format('M d, Y') : 'N/A' }}
                            </dd>
                        </div>
                         <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Hatched Count</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">{{ $eggCollection->hatched_count ?? 'N/A' }}</dd>
                        </div>
                     </dl>
                </div>
            </div>

             <!-- Remarks -->
            @if($eggCollection->remarks)
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
                        <p class="text-sm text-gray-900 dark:text-gray-100">{{ $eggCollection->remarks }}</p>
                    </div>
                </div>
            @endif
            
            <!-- Delete Action -->
            <div class="mt-8 flex justify-end">
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
