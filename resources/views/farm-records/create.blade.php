<x-layouts.app>
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Create Farm Record') }}</h1>
            <a href="{{ route('staff.farm-records.index') }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                &larr; {{ __('Back to List') }}
            </a>
        </div>

        <div class="bg-white dark:bg-zinc-900 overflow-hidden shadow-sm sm:rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
            <form method="POST" action="{{ route('staff.farm-records.store') }}">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Record Type -->
                    <div>
                        <label for="record_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Record Type') }}</label>
                        <select id="record_type" name="record_type" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required autofocus>
                            <option value="">Select Type</option>
                            <option value="Feeding" {{ old('record_type') == 'Feeding' ? 'selected' : '' }}>Feeding</option>
                            <option value="Cleaning" {{ old('record_type') == 'Cleaning' ? 'selected' : '' }}>Cleaning</option>
                            <option value="Mortality" {{ old('record_type') == 'Mortality' ? 'selected' : '' }}>Mortality</option>
                            <option value="Inspection" {{ old('record_type') == 'Inspection' ? 'selected' : '' }}>Inspection</option>
                        </select>
                        @error('record_type')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Record Date -->
                    <div>
                        <label for="record_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Record Date') }}</label>
                        <input id="record_date" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" type="date" name="record_date" value="{{ old('record_date', date('Y-m-d')) }}" required />
                        @error('record_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Related Module -->
                    <div>
                        <label for="related_module" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Related Module') }}</label>
                        <select id="related_module" name="related_module" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                            <option value="">Select Module</option>
                            <option value="Chick Rearing" {{ old('related_module') == 'Chick Rearing' ? 'selected' : '' }}>Chick Rearing</option>
                            <option value="Feeding" {{ old('related_module') == 'Feeding' ? 'selected' : '' }}>Feeding</option>
                            <option value="Medical" {{ old('related_module') == 'Medical' ? 'selected' : '' }}>Medical</option>
                            <option value="General" {{ old('related_module') == 'General' ? 'selected' : '' }}>General</option>
                        </select>
                        @error('related_module')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Reference ID -->
                    <div>
                        <label for="reference_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Reference ID (Optional)') }}</label>
                        <input id="reference_id" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" type="number" name="reference_id" value="{{ old('reference_id') }}" />
                        <p class="text-xs text-gray-500 mt-1">ID of the related record (e.g., Pen ID, Batch ID)</p>
                        @error('reference_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Description') }}</label>
                        <textarea id="description" name="description" rows="3" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Quantity -->
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Quantity (Optional)') }}</label>
                        <input id="quantity" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" type="number" step="0.01" name="quantity" value="{{ old('quantity') }}" />
                        @error('quantity')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Status') }}</label>
                        <select id="status" name="status" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow" required>
                            <option value="Normal" {{ old('status') == 'Normal' ? 'selected' : '' }}>Normal</option>
                            <option value="Issue" {{ old('status') == 'Issue' ? 'selected' : '' }}>Issue</option>
                            <option value="Critical" {{ old('status') == 'Critical' ? 'selected' : '' }}>Critical</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remarks -->
                    <div class="col-span-2">
                        <label for="remarks" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('Remarks (Optional)') }}</label>
                        <textarea id="remarks" name="remarks" rows="2" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow">{{ old('remarks') }}</textarea>
                        @error('remarks')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-4">
                    <a href="{{ route('staff.farm-records.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 dark:bg-zinc-800 dark:border-zinc-600 dark:text-gray-300 dark:hover:bg-zinc-700">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        {{ __('Save Record') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
