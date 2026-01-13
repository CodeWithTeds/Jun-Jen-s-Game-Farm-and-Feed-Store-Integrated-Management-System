<x-layouts.app>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Record Feed Usage') }}</h1>
        <a href="{{ route('staff.feed-usages.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 dark:bg-zinc-700 dark:text-gray-300 dark:hover:bg-zinc-600">
            {{ __('Back to List') }}
        </a>
    </div>

    <div class="bg-white dark:bg-zinc-900 overflow-hidden shadow-sm sm:rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
        <form method="POST" action="{{ route('staff.feed-usages.store') }}" class="space-y-6">
            @csrf

            <!-- Used Date -->
            <div>
                <label for="used_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Date') }}</label>
                <input id="used_date" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" type="date" name="used_date" value="{{ old('used_date', date('Y-m-d')) }}" required autofocus />
                @error('used_date')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Chick Group -->
            <div>
                <label for="chick_rearing_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Chick Group / Pen') }}</label>
                <select id="chick_rearing_id" name="chick_rearing_id" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                    <option value="">Select Chick Group</option>
                    @foreach($chickRearings as $chick)
                        <option value="{{ $chick->id }}" {{ old('chick_rearing_id') == $chick->id ? 'selected' : '' }}>
                            ID: {{ $chick->chick_tag_id }} ({{ $chick->age_days }} days old) - {{ $chick->growth_stage }}
                        </option>
                    @endforeach
                </select>
                @error('chick_rearing_id')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">
                    Guide: 0–21 days → Starter, 22–45 days → Grower
                </p>
            </div>

            <!-- Feed -->
            <div>
                <label for="feed_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Feed Used') }}</label>
                <select id="feed_id" name="feed_id" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                    <option value="">Select Feed</option>
                    @foreach($feeds as $feed)
                        <option value="{{ $feed->id }}" {{ old('feed_id') == $feed->id ? 'selected' : '' }}>
                            {{ $feed->feed_name }} ({{ $feed->feed_type }}) - {{ $feed->quantity }} {{ $feed->unit }} available
                        </option>
                    @endforeach
                </select>
                @error('feed_id')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Quantity -->
            <div>
                <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Quantity Given') }}</label>
                <input id="quantity" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" type="number" step="0.01" name="quantity" value="{{ old('quantity') }}" required />
                @error('quantity')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remarks -->
            <div>
                <label for="remarks" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Remarks') }}</label>
                <textarea id="remarks" name="remarks" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" rows="3">{{ old('remarks') }}</textarea>
                @error('remarks')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end mt-4">
                <a href="{{ route('staff.feed-usages.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 underline rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 mr-4">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Record Usage') }}
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
