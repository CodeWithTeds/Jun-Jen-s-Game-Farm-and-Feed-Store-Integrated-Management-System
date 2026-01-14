@php
    $routePrefix = request()->routeIs('staff.*') ? 'staff.' : 'admin.';
@endphp
<x-layouts.app>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Edit Feed') }}</h1>
        <a href="{{ route($routePrefix . 'feeds.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 dark:bg-zinc-700 dark:text-gray-300 dark:hover:bg-zinc-600">
            {{ __('Back to List') }}
        </a>
    </div>

    <div class="bg-white dark:bg-zinc-900 overflow-hidden shadow-sm sm:rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
        <form method="POST" action="{{ route($routePrefix . 'feeds.update', $feed->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Image and Basic Info -->
                <div class="space-y-6">
                    <!-- Image Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Feed Image</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-indigo-500 transition-colors dark:border-zinc-700 dark:hover:border-indigo-500 relative group cursor-pointer" onclick="document.getElementById('image').click()">
                            <div class="space-y-1 text-center">
                                <img id="image-preview" src="{{ $feed->image ? asset('storage/' . $feed->image) : '#' }}" alt="Preview" class="mx-auto h-48 w-full object-cover rounded-md {{ $feed->image ? '' : 'hidden' }} mb-4">
                                <div id="upload-placeholder" class="{{ $feed->image ? 'hidden' : '' }}">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 dark:text-gray-400 justify-center">
                                        <span class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500 dark:bg-zinc-900 dark:text-indigo-400">
                                            <span>Upload a file</span>
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                </div>
                            </div>
                            <input id="image" name="image" type="file" class="sr-only" onchange="previewImage(event)">
                        </div>
                        @error('image')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Feed Name -->
                    <div>
                        <label for="feed_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Feed Name</label>
                        <input type="text" name="feed_name" id="feed_name" value="{{ old('feed_name', $feed->feed_name) }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required autofocus>
                        @error('feed_name')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Feed Type -->
                    <div>
                        <label for="feed_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Feed Type</label>
                        <select name="feed_type" id="feed_type" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                            <option value="">Select Type</option>
                            @foreach(['Starter', 'Grower', 'Finisher', 'Breeder'] as $type)
                                <option value="{{ $type }}" {{ old('feed_type', $feed->feed_type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('feed_type')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Brand -->
                    <div>
                        <label for="brand" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Brand</label>
                        <input type="text" name="brand" id="brand" value="{{ old('brand', $feed->brand) }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                        @error('brand')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Right Column: Stock Details -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Quantity -->
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Quantity</label>
                            <input type="number" step="0.01" name="quantity" id="quantity" value="{{ old('quantity', $feed->quantity) }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                            @error('quantity')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Unit -->
                        <div>
                            <label for="unit" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Unit</label>
                            <select name="unit" id="unit" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                                <option value="Sack" {{ old('unit', $feed->unit) == 'Sack' ? 'selected' : '' }}>Sack</option>
                                <option value="Kg" {{ old('unit', $feed->unit) == 'Kg' ? 'selected' : '' }}>Kg</option>
                            </select>
                            @error('unit')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Batch Number -->
                        <div>
                            <label for="batch_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Batch Number</label>
                            <input type="text" name="batch_number" id="batch_number" value="{{ old('batch_number', $feed->batch_number) }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                            @error('batch_number')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Expiration Date -->
                        <div>
                            <label for="expiration_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Expiration Date</label>
                            <input type="date" name="expiration_date" id="expiration_date" value="{{ old('expiration_date', $feed->expiration_date->format('Y-m-d')) }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                            @error('expiration_date')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Supplier -->
                        <div>
                            <label for="supplier" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Supplier</label>
                            <input type="text" name="supplier" id="supplier" value="{{ old('supplier', $feed->supplier) }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                            @error('supplier')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Date Received -->
                        <div>
                            <label for="date_received" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date Received</label>
                            <input type="date" name="date_received" id="date_received" value="{{ old('date_received', $feed->date_received->format('Y-m-d')) }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                            @error('date_received')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Reorder Level -->
                        <div>
                            <label for="reorder_level" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Reorder Level</label>
                            <input type="number" name="reorder_level" id="reorder_level" value="{{ old('reorder_level', $feed->reorder_level) }}" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                            @error('reorder_level')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Storage Location -->
                        <div>
                            <label for="storage_location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Storage Location</label>
                            <select name="storage_location" id="storage_location" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                                <option value="Warehouse" {{ old('storage_location', $feed->storage_location) == 'Warehouse' ? 'selected' : '' }}>Warehouse</option>
                                <option value="Feed room" {{ old('storage_location', $feed->storage_location) == 'Feed room' ? 'selected' : '' }}>Feed room</option>
                            </select>
                            @error('storage_location')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                            <select name="status" id="status" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                                <option value="Available" {{ old('status', $feed->status) == 'Available' ? 'selected' : '' }}>Available</option>
                                <option value="Low Stock" {{ old('status', $feed->status) == 'Low Stock' ? 'selected' : '' }}>Low Stock</option>
                                <option value="Expired" {{ old('status', $feed->status) == 'Expired' ? 'selected' : '' }}>Expired</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Display Status (Admin Only) -->
                        @if($routePrefix === 'admin.')
                            <div>
                                <label for="is_displayed" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Display on Feed Inventory</label>
                                <select name="is_displayed" id="is_displayed" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow">
                                    <option value="1" {{ old('is_displayed', $feed->is_displayed) == '1' ? 'selected' : '' }}>Displayed</option>
                                    <option value="0" {{ old('is_displayed', $feed->is_displayed) == '0' ? 'selected' : '' }}>Hidden</option>
                                </select>
                                @error('is_displayed')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif
                    </div>

                    <!-- Remarks -->
                    <div>
                        <label for="remarks" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Remarks</label>
                        <textarea name="remarks" id="remarks" rows="3" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow">{{ old('remarks', $feed->remarks) }}</textarea>
                        @error('remarks')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Update Feed') }}
                </button>
            </div>
        </form>
    </div>

    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('image-preview');
                var placeholder = document.getElementById('upload-placeholder');
                output.src = reader.result;
                output.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            if(event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }
    </script>
</x-layouts.app>
