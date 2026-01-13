<x-layouts.app>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Medical Records') }}</h1>
        <a href="{{ route('staff.medical-records.create') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
            {{ __('Create Medical Record') }}
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded dark:bg-green-900 dark:border-green-600 dark:text-green-300">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6 bg-white dark:bg-zinc-900 p-4 rounded-xl border border-zinc-200 dark:border-zinc-700 shadow-sm">
        <form method="GET" action="{{ route('staff.medical-records.index') }}" class="flex flex-wrap gap-4 items-end">
            <div class="w-full max-w-sm">
                <label for="search" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Search</label>
                <input 
                    type="search"
                    id="search"
                    name="search" 
                    placeholder="Search by type, medication, or tag ID..." 
                    value="{{ request('search') }}"
                    class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow"
                >
            </div>
            
            <div class="w-full max-w-xs">
                <label for="type" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Type</label>
                <select name="type" id="type" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow">
                    <option value="">All Types</option>
                    <option value="Vaccination" {{ request('type') == 'Vaccination' ? 'selected' : '' }}>Vaccination</option>
                    <option value="Treatment" {{ request('type') == 'Treatment' ? 'selected' : '' }}>Treatment</option>
                    <option value="Injury" {{ request('type') == 'Injury' ? 'selected' : '' }}>Injury</option>
                    <option value="Checkup" {{ request('type') == 'Checkup' ? 'selected' : '' }}>Checkup</option>
                    <option value="Deworming" {{ request('type') == 'Deworming' ? 'selected' : '' }}>Deworming</option>
                    <option value="Vitamin" {{ request('type') == 'Vitamin' ? 'selected' : '' }}>Vitamin</option>
                </select>
            </div>

            <div class="w-full max-w-xs">
                <label for="status" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Status</label>
                <select name="status" id="status" class="w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-300 dark:focus:border-indigo-500 transition-shadow">
                    <option value="">All Statuses</option>
                    <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Scheduled" {{ request('status') == 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 dark:bg-zinc-200 dark:text-zinc-800 dark:hover:bg-white">
                    {{ __('Filter') }}
                </button>
                
                @if(request()->anyFilled(['search', 'type', 'status']))
                    <a href="{{ route('staff.medical-records.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 dark:bg-zinc-800 dark:border-zinc-600 dark:text-gray-300 dark:hover:bg-zinc-700">
                        {{ __('Clear') }}
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg border border-zinc-200 dark:border-zinc-700">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
                <thead class="bg-gray-50 dark:bg-zinc-900">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Date') }}</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Game Fowl') }}</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Type') }}</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Medication') }}</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Status') }}</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-zinc-800 divide-y divide-gray-200 dark:divide-zinc-700">
                    @forelse ($medicalRecords as $record)
                        <tr class="hover:bg-gray-50 dark:hover:bg-zinc-700/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ $record->date->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                <a href="{{ route('staff.game-fowls.show', $record->gameFowl) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">
                                    {{ $record->gameFowl->tag_id }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($record->type === 'Vaccination') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                    @elseif($record->type === 'Treatment') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @elseif($record->type === 'Injury') bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200
                                    @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif">
                                    {{ $record->type }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                {{ $record->medication_name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($record->status === 'Completed') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($record->status === 'Pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                    @else bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200 @endif">
                                    {{ $record->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('staff.medical-records.show', $record) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                        <span class="iconify" data-icon="heroicons:eye" data-width="20" data-height="20"></span>
                                    </a>
                                    <a href="{{ route('staff.medical-records.edit', $record) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                        <span class="iconify" data-icon="heroicons:pencil-square" data-width="20" data-height="20"></span>
                                    </a>
                                    <form action="{{ route('staff.medical-records.destroy', $record) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this medical record?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                            <span class="iconify" data-icon="heroicons:trash" data-width="20" data-height="20"></span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                {{ __('No medical records found.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($medicalRecords->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 dark:border-zinc-700">
                {{ $medicalRecords->links() }}
            </div>
        @endif
    </div>
</x-layouts.app>
