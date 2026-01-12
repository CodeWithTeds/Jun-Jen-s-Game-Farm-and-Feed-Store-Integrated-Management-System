<x-layouts.app>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Edit Game Fowl') }}</h1>
        <a href="{{ route('staff.game-fowls.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 dark:bg-zinc-700 dark:text-gray-300 dark:hover:bg-zinc-600">
            {{ __('Back to List') }}
        </a>
    </div>

    <div class="bg-white dark:bg-zinc-900 overflow-hidden shadow-sm sm:rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
        <form action="{{ route('staff.game-fowls.update', $gameFowl) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tag ID -->
                <div>
                    <label for="tag_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tag ID</label>
                    <input type="text" name="tag_id" id="tag_id" value="{{ old('tag_id', $gameFowl->tag_id) }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                    @error('tag_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $gameFowl->name) }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sex -->
                <div>
                    <label for="sex" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sex</label>
                    <select name="sex" id="sex" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                        <option value="">Select Sex</option>
                        <option value="Male" {{ old('sex', $gameFowl->sex) == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('sex', $gameFowl->sex) == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('sex')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date Hatched -->
                <div>
                    <label for="date_hatched" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date Hatched</label>
                    <input type="date" name="date_hatched" id="date_hatched" value="{{ old('date_hatched', $gameFowl->date_hatched->format('Y-m-d')) }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                    @error('date_hatched')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Growth Phase -->
                <div>
                    <label for="stage_growth_phase" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Stage / Growth Phase</label>
                    <input type="text" name="stage_growth_phase" id="stage_growth_phase" value="{{ old('stage_growth_phase', $gameFowl->stage_growth_phase) }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                    @error('stage_growth_phase')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Color / Feather Pattern -->
                <div>
                    <label for="color_feather_pattern" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Color / Feather Pattern</label>
                    <input type="text" name="color_feather_pattern" id="color_feather_pattern" value="{{ old('color_feather_pattern', $gameFowl->color_feather_pattern) }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                    @error('color_feather_pattern')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Distinctive Markings -->
                <div>
                    <label for="distinctive_markings" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Distinctive Markings (Optional)</label>
                    <input type="text" name="distinctive_markings" id="distinctive_markings" value="{{ old('distinctive_markings', $gameFowl->distinctive_markings) }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow">
                    @error('distinctive_markings')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Acquisition Date -->
                <div>
                    <label for="acquisition_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Acquisition Date</label>
                    <input type="date" name="acquisition_date" id="acquisition_date" value="{{ old('acquisition_date', $gameFowl->acquisition_date->format('Y-m-d')) }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                    @error('acquisition_date')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Initial Health Status -->
                <div>
                    <label for="initial_health_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Initial Health Status</label>
                    <input type="text" name="initial_health_status" id="initial_health_status" value="{{ old('initial_health_status', $gameFowl->initial_health_status) }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                    @error('initial_health_status')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sexual Maturity Status -->
                <div>
                    <label for="sexual_maturity_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sexual Maturity Status</label>
                    <input type="text" name="sexual_maturity_status" id="sexual_maturity_status" value="{{ old('sexual_maturity_status', $gameFowl->sexual_maturity_status) }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                    @error('sexual_maturity_status')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Special Notes -->
                <div class="md:col-span-2">
                    <label for="special_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Special Notes (Optional)</label>
                    <textarea name="special_notes" id="special_notes" rows="3" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow">{{ old('special_notes', $gameFowl->special_notes) }}</textarea>
                    @error('special_notes')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('staff.game-fowls.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 dark:bg-zinc-800 dark:border-zinc-600 dark:text-gray-300 dark:hover:bg-zinc-700">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Update Game Fowl') }}
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
