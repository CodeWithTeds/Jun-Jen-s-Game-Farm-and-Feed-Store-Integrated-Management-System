<x-layouts.app>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Add New Feed') }}</h1>
        <a href="{{ route('staff.feeds.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 dark:bg-zinc-700 dark:text-gray-300 dark:hover:bg-zinc-600">
            {{ __('Back to List') }}
        </a>
    </div>

    <div class="bg-white dark:bg-zinc-900 overflow-hidden shadow-sm sm:rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
        <form method="POST" action="{{ route('staff.feeds.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Feed Name -->
                <div>
                    <label for="feed_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Feed Name') }}</label>
                    <input id="feed_name" type="text" name="feed_name" value="{{ old('feed_name') }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required autofocus />
                    @error('feed_name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Feed Type -->
                <div>
                    <label for="feed_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Feed Type') }}</label>
                    <select id="feed_type" name="feed_type" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                        <option value="" disabled selected>Select Type</option>
                        <option value="Starter" {{ old('feed_type') == 'Starter' ? 'selected' : '' }}>Starter</option>
                        <option value="Grower" {{ old('feed_type') == 'Grower' ? 'selected' : '' }}>Grower</option>
                        <option value="Finisher" {{ old('feed_type') == 'Finisher' ? 'selected' : '' }}>Finisher</option>
                        <option value="Breeder" {{ old('feed_type') == 'Breeder' ? 'selected' : '' }}>Breeder</option>
                    </select>
                    @error('feed_type')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Brand -->
                <div>
                    <label for="brand" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Brand') }}</label>
                    <input id="brand" type="text" name="brand" value="{{ old('brand') }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required />
                    @error('brand')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Quantity -->
                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Quantity') }}</label>
                    <input id="quantity" type="number" step="0.01" name="quantity" value="{{ old('quantity') }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required min="0" />
                    @error('quantity')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Unit -->
                <div>
                    <label for="unit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Unit') }}</label>
                    <select id="unit" name="unit" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                        <option value="" disabled selected>Select Unit</option>
                        <option value="Sack" {{ old('unit') == 'Sack' ? 'selected' : '' }}>Sack</option>
                        <option value="Kg" {{ old('unit') == 'Kg' ? 'selected' : '' }}>Kg</option>
                    </select>
                    @error('unit')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Batch Number -->
                <div>
                    <label for="batch_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Batch Number') }}</label>
                    <input id="batch_number" type="text" name="batch_number" value="{{ old('batch_number') }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required />
                    @error('batch_number')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Expiration Date -->
                <div>
                    <label for="expiration_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Expiration Date') }}</label>
                    <input id="expiration_date" type="date" name="expiration_date" value="{{ old('expiration_date') }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required />
                    @error('expiration_date')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Supplier -->
                <div>
                    <label for="supplier" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Supplier') }}</label>
                    <input id="supplier" type="text" name="supplier" value="{{ old('supplier') }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required />
                    @error('supplier')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date Received -->
                <div>
                    <label for="date_received" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Date Received') }}</label>
                    <input id="date_received" type="date" name="date_received" value="{{ old('date_received') }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required />
                    @error('date_received')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Reorder Level -->
                <div>
                    <label for="reorder_level" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Reorder Level') }}</label>
                    <input id="reorder_level" type="number" name="reorder_level" value="{{ old('reorder_level') }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required min="0" />
                    @error('reorder_level')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Storage Location -->
                <div>
                    <label for="storage_location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Storage Location') }}</label>
                    <select id="storage_location" name="storage_location" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                        <option value="" disabled selected>Select Location</option>
                        <option value="Warehouse" {{ old('storage_location') == 'Warehouse' ? 'selected' : '' }}>Warehouse</option>
                        <option value="Feed room" {{ old('storage_location') == 'Feed room' ? 'selected' : '' }}>Feed room</option>
                    </select>
                    @error('storage_location')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Status') }}</label>
                    <select id="status" name="status" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                        <option value="" disabled selected>Select Status</option>
                        <option value="Available" {{ old('status') == 'Available' ? 'selected' : '' }}>Available</option>
                        <option value="Low Stock" {{ old('status') == 'Low Stock' ? 'selected' : '' }}>Low Stock</option>
                        <option value="Expired" {{ old('status') == 'Expired' ? 'selected' : '' }}>Expired</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remarks -->
                <div class="md:col-span-2">
                    <label for="remarks" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Remarks') }}</label>
                    <textarea id="remarks" name="remarks" rows="3" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow">{{ old('remarks') }}</textarea>
                    @error('remarks')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Save Feed') }}
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
