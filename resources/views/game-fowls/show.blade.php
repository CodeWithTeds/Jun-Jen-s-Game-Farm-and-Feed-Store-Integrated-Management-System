<x-layouts.app>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Game Fowl Details') }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('staff.game-fowls.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 dark:bg-zinc-700 dark:text-gray-300 dark:hover:bg-zinc-600">
                {{ __('Back to List') }}
            </a>
            <a href="{{ route('staff.game-fowls.edit', $gameFowl) }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Edit') }}
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-zinc-900 overflow-hidden shadow-sm sm:rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Image & Identity -->
            <div class="space-y-6">
                <!-- Image -->
                <div>
                    <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 dark:bg-zinc-800 xl:aspect-w-7 xl:aspect-h-8">
                        <img src="{{ $gameFowl->image ? Storage::url($gameFowl->image) : 'https://ui-avatars.com/api/?name=' . urlencode($gameFowl->name) . '&background=random&size=512' }}" alt="{{ $gameFowl->name }}" class="h-full w-full object-cover object-center group-hover:opacity-75 rounded-lg shadow-sm">
                    </div>
                </div>

                <!-- Identity Card -->
                <div class="bg-gray-50 dark:bg-zinc-800/50 rounded-lg p-4 border border-gray-100 dark:border-zinc-700/50">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tag ID</label>
                            <div class="mt-1 text-lg font-mono font-bold text-gray-900 dark:text-white">{{ $gameFowl->tag_id }}</div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Name / Alias</label>
                            <div class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $gameFowl->name }}</div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Sex</label>
                            <div class="mt-1">
                                <span class="px-2 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $gameFowl->sex === 'Male' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200' }}">
                                    {{ $gameFowl->sex }}
                                </span>
                            </div>
                        </div>
                         <div>
                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Current Age</label>
                            <div class="mt-1 text-base text-gray-900 dark:text-gray-200">{{ $gameFowl->current_age }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Detailed Info -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Physical Characteristics -->
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <span class="iconify" data-icon="heroicons:sparkles" class="text-indigo-500"></span>
                        Physical Characteristics
                    </h3>
                    <div class="bg-gray-50 dark:bg-zinc-800/30 rounded-lg p-5 border border-gray-100 dark:border-zinc-700/30">
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

                <!-- Health & History -->
                <div>
                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                        <span class="iconify" data-icon="heroicons:heart" class="text-red-500"></span>
                        Health & History
                    </h3>
                    <div class="bg-gray-50 dark:bg-zinc-800/30 rounded-lg p-5 border border-gray-100 dark:border-zinc-700/30">
                        <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
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
                </div>

                <!-- Special Notes -->
                @if($gameFowl->special_notes)
                    <div>
                        <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                            <span class="iconify" data-icon="heroicons:document-text" class="text-yellow-500"></span>
                            Special Notes
                        </h3>
                        <div class="text-sm text-gray-900 dark:text-gray-200 bg-yellow-50 dark:bg-yellow-900/10 border border-yellow-100 dark:border-yellow-900/20 p-4 rounded-lg">
                            {{ $gameFowl->special_notes }}
                        </div>
                    </div>
                @endif
                
                <!-- Medical Records -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white flex items-center gap-2">
                            <span class="iconify" data-icon="heroicons:heart" class="text-red-500"></span>
                            Medical Records
                        </h3>
                        <a href="{{ route('staff.medical-records.create', ['game_fowl_id' => $gameFowl->id]) }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                            + Add Record
                        </a>
                    </div>
                    
                    @if($gameFowl->medicalRecords->count() > 0)
                        <div class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                            <ul class="divide-y divide-gray-200 dark:divide-zinc-700">
                                @foreach($gameFowl->medicalRecords as $record)
                                    <li class="p-4 hover:bg-gray-50 dark:hover:bg-zinc-700/50 transition-colors">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                    {{ $record->type }}
                                                    @if($record->medication_name)
                                                        - {{ $record->medication_name }}
                                                    @endif
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $record->date->format('M d, Y') }} &bull; {{ $record->status }}
                                                </p>
                                            </div>
                                            <a href="{{ route('staff.medical-records.show', $record) }}" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                                                <span class="iconify" data-icon="heroicons:chevron-right" data-width="20" data-height="20"></span>
                                            </a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div class="text-sm text-gray-500 dark:text-gray-400 italic bg-gray-50 dark:bg-zinc-800/30 p-4 rounded-lg border border-gray-100 dark:border-zinc-700/30">
                            No medical records found.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
