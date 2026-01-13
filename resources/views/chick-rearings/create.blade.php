<x-layouts.app>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Create Chick Rearing Record') }}</h1>
        <a href="{{ route('staff.chick-rearings.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 dark:bg-zinc-700 dark:text-gray-300 dark:hover:bg-zinc-600">
            {{ __('Back to List') }}
        </a>
    </div>

    <div class="bg-white dark:bg-zinc-900 overflow-hidden shadow-sm sm:rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
        <form method="POST" action="{{ route('staff.chick-rearings.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Chick Tag ID -->
                <div>
                    <label for="chick_tag_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Chick Tag ID') }}</label>
                    <input id="chick_tag_id" type="text" name="chick_tag_id" value="{{ old('chick_tag_id') }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required autofocus />
                    @error('chick_tag_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Hatch Date -->
                <div>
                    <label for="hatch_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Hatch Date') }}</label>
                    <input id="hatch_date" type="date" name="hatch_date" value="{{ old('hatch_date') }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required />
                    @error('hatch_date')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Age (Days) -->
                <div>
                    <label for="age_days" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Age (Days)') }}</label>
                    <input id="age_days" type="number" name="age_days" value="{{ old('age_days') }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required min="0" />
                    @error('age_days')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Growth Stage -->
                <div>
                    <label for="growth_stage" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Growth Stage') }}</label>
                    <select id="growth_stage" name="growth_stage" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow">
                        <option value="" disabled selected>Select Stage</option>
                        <option value="Brooder" {{ old('growth_stage') == 'Brooder' ? 'selected' : '' }}>Brooder</option>
                        <option value="Starter" {{ old('growth_stage') == 'Starter' ? 'selected' : '' }}>Starter</option>
                        <option value="Grower" {{ old('growth_stage') == 'Grower' ? 'selected' : '' }}>Grower</option>
                    </select>
                    @error('growth_stage')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Feed Type -->
                <div>
                    <label for="feed_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Feed Type') }}</label>
                    <input id="feed_type" type="text" name="feed_type" value="{{ old('feed_type') }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required />
                    @error('feed_type')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Feeding Schedule -->
                <div>
                    <label for="feeding_schedule" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Feeding Schedule') }}</label>
                    <input id="feeding_schedule" type="text" name="feeding_schedule" value="{{ old('feeding_schedule') }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required />
                    @error('feeding_schedule')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Health Status -->
                <div>
                    <label for="health_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Health Status') }}</label>
                    <select id="health_status" name="health_status" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow">
                        <option value="" disabled selected>Select Status</option>
                        <option value="Healthy" {{ old('health_status') == 'Healthy' ? 'selected' : '' }}>Healthy</option>
                        <option value="Weak" {{ old('health_status') == 'Weak' ? 'selected' : '' }}>Weak</option>
                        <option value="Sick" {{ old('health_status') == 'Sick' ? 'selected' : '' }}>Sick</option>
                    </select>
                    @error('health_status')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Vaccination Status -->
                <div>
                    <label for="vaccination_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Vaccination Status') }}</label>
                    <select id="vaccination_status" name="vaccination_status" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow">
                        <option value="" disabled selected>Select Status</option>
                        <option value="Pending" {{ old('vaccination_status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Completed" {{ old('vaccination_status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    @error('vaccination_status')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Last Vaccination Date -->
                <div>
                    <label for="last_vaccination_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Last Vaccination Date') }}</label>
                    <input id="last_vaccination_date" type="date" name="last_vaccination_date" value="{{ old('last_vaccination_date') }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" />
                    @error('last_vaccination_date')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mortality Status -->
                <div>
                    <label for="mortality_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Mortality Status') }}</label>
                    <select id="mortality_status" name="mortality_status" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow">
                        <option value="Alive" {{ old('mortality_status') == 'Alive' ? 'selected' : '' }}>Alive</option>
                        <option value="Deceased" {{ old('mortality_status') == 'Deceased' ? 'selected' : '' }}>Deceased</option>
                    </select>
                    @error('mortality_status')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Treatment Notes -->
            <div class="mt-6">
                <label for="treatment_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Treatment Notes') }}</label>
                <textarea id="treatment_notes" name="treatment_notes" rows="3" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow">{{ old('treatment_notes') }}</textarea>
                @error('treatment_notes')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remarks -->
            <div class="mt-6">
                <label for="remarks" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Remarks') }}</label>
                <textarea id="remarks" name="remarks" rows="3" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow">{{ old('remarks') }}</textarea>
                @error('remarks')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end mt-8">
                <a href="{{ route('staff.chick-rearings.index') }}" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                    {{ __('Cancel') }}
                </a>

                <button type="submit" class="ms-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Save') }}
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
