<div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden shadow-sm">
    <div class="p-6 border-b border-zinc-200 dark:border-zinc-700">
        <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">Recent Medical Treatments</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-zinc-500 dark:text-zinc-400">
            <thead class="bg-zinc-50 dark:bg-zinc-800/50 text-xs uppercase text-zinc-700 dark:text-zinc-300">
                <tr>
                    <th class="px-6 py-3">Date</th>
                    <th class="px-6 py-3">Game Fowl</th>
                    <th class="px-6 py-3">Type</th>
                    <th class="px-6 py-3">Medication</th>
                    <th class="px-6 py-3">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                @forelse($recentMedical as $record)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                        <td class="px-6 py-4">{{ $record->date->format('M d, Y') }}</td>
                        <td class="px-6 py-4 font-medium text-zinc-900 dark:text-zinc-100">
                            {{ $record->gameFowl->name ?? 'Unknown' }} 
                            <span class="text-xs text-zinc-500">({{ $record->gameFowl->tag_id ?? 'N/A' }})</span>
                        </td>
                        <td class="px-6 py-4">{{ Str::limit($record->type, 30) }}</td>
                        <td class="px-6 py-4">{{ Str::limit($record->medication_name, 30) }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium 
                                {{ $record->status === 'Completed' ? 'bg-green-100 text-green-800 dark:bg-green-500/10 dark:text-green-400' : 
                                   ($record->status === 'Follow-up Required' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-500/10 dark:text-yellow-400' : 
                                   'bg-gray-100 text-gray-800 dark:bg-gray-500/10 dark:text-gray-400') }}">
                                {{ $record->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-zinc-500">No recent medical records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 border-t border-zinc-200 dark:border-zinc-700 text-center">
        <a href="{{ route('staff.medical-records.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500" wire:navigate>View All Records &rarr;</a>
    </div>
</div>
