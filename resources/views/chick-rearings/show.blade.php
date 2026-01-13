<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Chick Rearing Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">{{ __('Chick Tag ID: ') }} {{ $chickRearing->chick_tag_id }}</h3>
                        <div class="flex gap-2">
                            <a href="{{ route('staff.chick-rearings.edit', $chickRearing) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Edit') }}
                            </a>
                            <a href="{{ route('staff.chick-rearings.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white">
                                {{ __('Back to List') }}
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 dark:bg-zinc-900 p-4 rounded-lg">
                            <h4 class="font-semibold mb-2 text-indigo-600 dark:text-indigo-400">{{ __('Basic Information') }}</h4>
                            <div class="grid grid-cols-2 gap-2 text-sm">
                                <div class="text-gray-500 dark:text-gray-400">{{ __('Hatch Date:') }}</div>
                                <div>{{ $chickRearing->hatch_date->format('M d, Y') }}</div>

                                <div class="text-gray-500 dark:text-gray-400">{{ __('Age:') }}</div>
                                <div>{{ $chickRearing->age_days }} {{ __('days') }}</div>

                                <div class="text-gray-500 dark:text-gray-400">{{ __('Growth Stage:') }}</div>
                                <div>{{ $chickRearing->growth_stage }}</div>

                                <div class="text-gray-500 dark:text-gray-400">{{ __('Mortality Status:') }}</div>
                                <div>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $chickRearing->mortality_status == 'Alive' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                                        {{ $chickRearing->mortality_status }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-zinc-900 p-4 rounded-lg">
                            <h4 class="font-semibold mb-2 text-indigo-600 dark:text-indigo-400">{{ __('Feeding & Health') }}</h4>
                            <div class="grid grid-cols-2 gap-2 text-sm">
                                <div class="text-gray-500 dark:text-gray-400">{{ __('Feed Type:') }}</div>
                                <div>{{ $chickRearing->feed_type }}</div>

                                <div class="text-gray-500 dark:text-gray-400">{{ __('Feeding Schedule:') }}</div>
                                <div>{{ $chickRearing->feeding_schedule }}</div>

                                <div class="text-gray-500 dark:text-gray-400">{{ __('Health Status:') }}</div>
                                <div>{{ $chickRearing->health_status }}</div>

                                <div class="text-gray-500 dark:text-gray-400">{{ __('Vaccination Status:') }}</div>
                                <div>{{ $chickRearing->vaccination_status }}</div>

                                <div class="text-gray-500 dark:text-gray-400">{{ __('Last Vaccination:') }}</div>
                                <div>{{ $chickRearing->last_vaccination_date ? $chickRearing->last_vaccination_date->format('M d, Y') : 'N/A' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                         <div class="bg-gray-50 dark:bg-zinc-900 p-4 rounded-lg">
                            <h4 class="font-semibold mb-2 text-indigo-600 dark:text-indigo-400">{{ __('Treatment Notes') }}</h4>
                            <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $chickRearing->treatment_notes ?? 'No notes available.' }}</p>
                        </div>

                        <div class="bg-gray-50 dark:bg-zinc-900 p-4 rounded-lg">
                            <h4 class="font-semibold mb-2 text-indigo-600 dark:text-indigo-400">{{ __('Remarks') }}</h4>
                            <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $chickRearing->remarks ?? 'No remarks available.' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
