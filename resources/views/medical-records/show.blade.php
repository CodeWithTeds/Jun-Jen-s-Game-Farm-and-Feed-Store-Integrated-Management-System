<x-layouts.app>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Medical Record Details') }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('staff.medical-records.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 dark:bg-zinc-700 dark:text-gray-300 dark:hover:bg-zinc-600">
                {{ __('Back to List') }}
            </a>
            <a href="{{ route('staff.medical-records.edit', $medicalRecord) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                {{ __('Edit') }}
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-zinc-900 overflow-hidden shadow-sm sm:rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Record Information -->
            <div>
                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white mb-4">Record Information</h3>
                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Date</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $medicalRecord->date->format('F j, Y') }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Game Fowl</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                            <a href="{{ route('staff.game-fowls.show', $medicalRecord->gameFowl) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                {{ $medicalRecord->gameFowl->tag_id }} - {{ $medicalRecord->gameFowl->name }}
                            </a>
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Type</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $medicalRecord->type }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Status</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($medicalRecord->status === 'Completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                @elseif($medicalRecord->status === 'Pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                @else bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200 @endif">
                                {{ $medicalRecord->status }}
                            </span>
                        </dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Medication</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $medicalRecord->medication_name ?? 'N/A' }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Dosage</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $medicalRecord->dosage ?? 'N/A' }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Additional Details -->
            <div>
                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white mb-4">Additional Details</h3>
                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Administered By</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $medicalRecord->administered_by ?? 'N/A' }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Technician / Vet</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $medicalRecord->technician_name ?? 'N/A' }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Location</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $medicalRecord->location ?? 'N/A' }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Cost</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $medicalRecord->cost ? number_format($medicalRecord->cost, 2) : 'N/A' }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Next Schedule</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $medicalRecord->next_schedule_date?->format('F j, Y') ?? 'N/A' }}</dd>
                    </div>
                </dl>
            </div>

            <!-- Notes -->
            <div class="md:col-span-2">
                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white mb-4">Notes</h3>
                <div class="bg-gray-50 dark:bg-zinc-800/50 rounded-lg p-4 text-sm text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-zinc-700">
                    {{ $medicalRecord->notes ?? 'No notes available.' }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
