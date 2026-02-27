<div class="p-6 space-y-8">
    <!-- Header / Info -->
    <div class="flex flex-col md:flex-row gap-6 items-start bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm">
        <div class="w-full md:w-1/4">
             @if($gameFowl->image)
                <img class="w-full h-auto rounded-lg object-cover shadow-md" src="{{ asset('storage/' . $gameFowl->image) }}" alt="{{ $gameFowl->name }}">
            @else
                <div class="w-full aspect-square rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400">
                    <flux:icon icon="photo" class="h-20 w-20" />
                </div>
            @endif
        </div>
        <div class="w-full md:w-3/4 space-y-4">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900 dark:text-white">{{ $gameFowl->name }}</h1>
                    <p class="text-slate-500 dark:text-slate-400 text-lg">Tag ID: <span class="font-mono text-slate-700 dark:text-slate-300">{{ $gameFowl->tag_id }}</span></p>
                </div>
                <flux:button href="{{ auth()->user()->role === 'admin' ? route('admin.reports.game-fowls.index') : route('staff.reports.game-fowls.index') }}" icon="arrow-left" wire:navigate>Back to Reports</flux:button>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-4 border-t border-slate-100 dark:border-slate-800">
                <div>
                    <span class="text-xs text-slate-500 uppercase tracking-wider">Sex</span>
                    <p class="font-medium text-slate-900 dark:text-white capitalize">{{ $gameFowl->sex }}</p>
                </div>
                <div>
                    <span class="text-xs text-slate-500 uppercase tracking-wider">Age</span>
                    <p class="font-medium text-slate-900 dark:text-white">{{ $gameFowl->current_age }}</p>
                </div>
                <div>
                    <span class="text-xs text-slate-500 uppercase tracking-wider">Status</span>
                    <p class="font-medium text-slate-900 dark:text-white">{{ $gameFowl->reproductive_status ?? 'N/A' }}</p>
                </div>
                <div>
                    <span class="text-xs text-slate-500 uppercase tracking-wider">Type</span>
                    <p class="font-medium text-slate-900 dark:text-white">{{ $gameFowl->gender_identification }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Medical Records -->
        <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="p-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 flex items-center gap-2">
                <flux:icon icon="plus-circle" class="text-red-500 h-5 w-5" />
                <h3 class="font-bold text-slate-900 dark:text-white">Medical Records</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                    <thead class="bg-slate-50 dark:bg-slate-800/50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Type</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Medication</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Remarks</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700 bg-white dark:bg-slate-900">
                        @forelse($gameFowl->medicalRecords as $record)
                            <tr>
                                <td class="px-4 py-3 text-sm text-slate-900 dark:text-white whitespace-nowrap">{{ $record->date->format('M d, Y') }}</td>
                                <td class="px-4 py-3 text-sm text-slate-500 dark:text-slate-400 capitalize">{{ $record->type }}</td>
                                <td class="px-4 py-3 text-sm text-slate-500 dark:text-slate-400">{{ $record->medication_name }}</td>
                                <td class="px-4 py-3 text-sm text-slate-500 dark:text-slate-400">{{ Str::limit($record->notes, 30) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-slate-500">No medical records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Fight History -->
        <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
            <div class="p-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 flex items-center gap-2">
                <flux:icon icon="trophy" class="text-orange-500 h-5 w-5" />
                <h3 class="font-bold text-slate-900 dark:text-white">Fight History</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                    <thead class="bg-slate-50 dark:bg-slate-800/50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Event/Location</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Result</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 uppercase">Outcome</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700 bg-white dark:bg-slate-900">
                        @forelse($gameFowl->fightSchedules as $fight)
                            <tr>
                                <td class="px-4 py-3 text-sm text-slate-900 dark:text-white whitespace-nowrap">{{ $fight->date->format('M d, Y') }}</td>
                                <td class="px-4 py-3 text-sm text-slate-500 dark:text-slate-400">{{ $fight->location }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                        {{ $fight->result === 'win' ? 'bg-green-100 text-green-800' : 
                                           ($fight->result === 'loss' ? 'bg-red-100 text-red-800' : 
                                           ($fight->result === 'draw' ? 'bg-yellow-100 text-yellow-800' : 'bg-slate-100 text-slate-800')) }}">
                                        {{ ucfirst($fight->result ?? 'Pending') }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-slate-500 dark:text-slate-400">{{ Str::limit($fight->notes, 30) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-slate-500">No fight history found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
