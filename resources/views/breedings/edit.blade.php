<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Breeding Record') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-zinc-900 overflow-hidden shadow-sm sm:rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
                
                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded dark:bg-red-900 dark:border-red-600 dark:text-red-300">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('staff.breedings.update', $breeding) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Sire -->
                        <div>
                            <label for="sire_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sire (Male)</label>
                            <select name="sire_id" id="sire_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-zinc-700 dark:bg-zinc-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                <option value="">Select Sire</option>
                                @foreach($sires as $sire)
                                    <option value="{{ $sire->id }}" {{ (old('sire_id') ?? $breeding->sire_id) == $sire->id ? 'selected' : '' }}>{{ $sire->name }} ({{ $sire->tag_id }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Dam -->
                        <div>
                            <label for="dam_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dam (Female)</label>
                            <select name="dam_id" id="dam_id" class="mt-1 block w-full rounded-md border-gray-300 dark:border-zinc-700 dark:bg-zinc-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                <option value="">Select Dam</option>
                                @foreach($dams as $dam)
                                    <option value="{{ $dam->id }}" {{ (old('dam_id') ?? $breeding->dam_id) == $dam->id ? 'selected' : '' }}>{{ $dam->name }} ({{ $dam->tag_id }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Breeding Date -->
                        <div>
                            <label for="breeding_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Breeding Date</label>
                            <input type="date" name="breeding_date" id="breeding_date" value="{{ old('breeding_date', $breeding->breeding_date->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-zinc-700 dark:bg-zinc-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                        </div>

                        <!-- Expected Hatch Date -->
                        <div>
                            <label for="expected_hatch_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Expected Hatch Date</label>
                            <input type="date" name="expected_hatch_date" id="expected_hatch_date" value="{{ old('expected_hatch_date', optional($breeding->expected_hatch_date)->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-zinc-700 dark:bg-zinc-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <!-- Type -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Breeding Method</label>
                            <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300 dark:border-zinc-700 dark:bg-zinc-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                <option value="Natural" {{ (old('type') ?? $breeding->type) == 'Natural' ? 'selected' : '' }}>Natural Mating</option>
                                <option value="AI" {{ (old('type') ?? $breeding->type) == 'AI' ? 'selected' : '' }}>Artificial Insemination</option>
                                <option value="Trio" {{ (old('type') ?? $breeding->type) == 'Trio' ? 'selected' : '' }}>Trio Mating</option>
                            </select>
                        </div>

                        <!-- Pen Number -->
                        <div>
                            <label for="pen_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pen / Coop Number</label>
                            <input type="text" name="pen_number" id="pen_number" value="{{ old('pen_number', $breeding->pen_number) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-zinc-700 dark:bg-zinc-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                        </div>

                        <!-- Clutch Number -->
                        <div>
                            <label for="clutch_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Clutch / Batch Number</label>
                            <input type="text" name="clutch_number" id="clutch_number" value="{{ old('clutch_number', $breeding->clutch_number) }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-zinc-700 dark:bg-zinc-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 dark:border-zinc-700 dark:bg-zinc-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                <option value="Active" {{ (old('status') ?? $breeding->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Completed" {{ (old('status') ?? $breeding->status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                                <option value="Failed" {{ (old('status') ?? $breeding->status) == 'Failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notes / Observations</label>
                        <textarea name="notes" id="notes" rows="4" class="mt-1 block w-full rounded-md border-gray-300 dark:border-zinc-700 dark:bg-zinc-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('notes', $breeding->notes) }}</textarea>
                    </div>

                    <div class="flex justify-end gap-4">
                        <a href="{{ route('staff.breedings.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-700 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Update Breeding Record
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
