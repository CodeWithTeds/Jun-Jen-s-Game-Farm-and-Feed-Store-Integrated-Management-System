<div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden shadow-sm">
    <div class="p-6 border-b border-slate-200 dark:border-slate-700">
        <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Recent Medical Treatments</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-500 dark:text-slate-400">
            <thead class="bg-slate-50 dark:bg-slate-800/50 text-xs uppercase text-slate-700 dark:text-slate-300">
                <tr>
                    <th class="px-6 py-3">Date</th>
                    <th class="px-6 py-3">Game Fowl</th>
                    <th class="px-6 py-3">Type</th>
                    <th class="px-6 py-3">Medication</th>
                    <th class="px-6 py-3">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                @forelse($recentMedical as $record)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <td class="px-6 py-4">{{ $record->date->format('M d, Y') }}</td>
                        <td class="px-6 py-4 font-medium text-slate-900 dark:text-slate-100">
                            {{ $record->gameFowl->name ?? 'Unknown' }} 
                            <span class="text-xs text-slate-500">({{ $record->gameFowl->tag_id ?? 'N/A' }})</span>
                        </td>
                        <td class="px-6 py-4">{{ Str::limit($record->type, 30) }}</td>
                        <td class="px-6 py-4">{{ Str::limit($record->medication_name, 30) }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium 
                                {{ $record->status === 'Completed' ? 'bg-green-100 text-green-800 dark:bg-green-500/10 dark:text-green-400' : 
                                   ($record->status === 'Follow-up Required' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-500/10 dark:text-yellow-400' : 
                                   'bg-slate-100 text-slate-800 dark:bg-slate-500/10 dark:text-slate-400') }}">
                                {{ $record->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500">No recent medical records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="bg-slate-50 dark:bg-slate-800/50 p-4 border-t border-slate-200 dark:border-slate-700 text-center">
        <a href="{{ route('staff.medical-records.index') }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-500" wire:navigate>View All Records &rarr;</a>
    </div>
</div>
