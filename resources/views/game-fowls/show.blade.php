<x-layouts.app>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Game Fowl Details') }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('staff.game-fowls.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 dark:bg-zinc-700 dark:text-gray-300 dark:hover:bg-zinc-600">
                {{ __('Back to List') }}
            </a>
            <a href="{{ route('staff.game-fowls.edit', $gameFowl) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Edit') }}
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-zinc-900 overflow-hidden shadow-sm sm:rounded-lg border border-zinc-200 dark:border-zinc-700">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white mb-4">Basic Information</h3>
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tag ID</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $gameFowl->tag_id }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $gameFowl->name }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Sex</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $gameFowl->sex === 'Male' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200' }}">
                                    {{ $gameFowl->sex }}
                                </span>
                            </dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Age</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $gameFowl->current_age }}</dd>
                        </div>
                    </dl>
                </div>

                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white mb-4">Physical Characteristics</h3>
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Growth Phase</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $gameFowl->stage_growth_phase }}</dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Feather Pattern</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $gameFowl->color_feather_pattern }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Distinctive Markings</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $gameFowl->distinctive_markings ?? 'None' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <div class="mt-8 border-t border-gray-200 dark:border-zinc-700 pt-8">
                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white mb-4">Health & Status</h3>
                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-3">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Date Hatched</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $gameFowl->date_hatched->format('F j, Y') }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Acquisition Date</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $gameFowl->acquisition_date->format('F j, Y') }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Initial Health Status</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $gameFowl->initial_health_status }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Sexual Maturity</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $gameFowl->sexual_maturity_status }}</dd>
                    </div>
                </dl>
            </div>

            @if($gameFowl->special_notes)
                <div class="mt-8 border-t border-gray-200 dark:border-zinc-700 pt-8">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white mb-4">Special Notes</h3>
                    <div class="text-sm text-gray-900 dark:text-gray-200 bg-gray-50 dark:bg-zinc-800 p-4 rounded-lg">
                        {{ $gameFowl->special_notes }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
