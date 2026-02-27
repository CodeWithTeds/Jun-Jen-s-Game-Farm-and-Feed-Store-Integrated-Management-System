<div class="p-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Game Fowl Reports</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">View comprehensive reports including medical records and fight history.</p>
        </div>
        
        <div class="w-full md:w-72">
            <flux:input wire:model.live="search" icon="magnifying-glass" placeholder="Search by Name or Tag ID..." />
        </div>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                <thead class="bg-slate-50 dark:bg-slate-800/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Game Fowl</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Sex</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700 bg-white dark:bg-slate-900">
                    @forelse($gameFowls as $fowl)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        @if($fowl->image)
                                            <img class="h-10 w-10 rounded-full object-cover border border-slate-200 dark:border-slate-700" src="{{ asset('storage/' . $fowl->image) }}" alt="{{ $fowl->name }}">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-400">
                                                <flux:icon icon="photo" class="h-5 w-5" />
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-slate-900 dark:text-white group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors">{{ $fowl->name }}</div>
                                        <div class="text-xs text-slate-500 dark:text-slate-400 font-mono">ID: {{ $fowl->tag_id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-300">
                                {{ $fowl->gender_identification ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600 dark:text-slate-300 capitalize">
                                {{ $fowl->sex }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                                    {{ $fowl->reproductive_status ?? 'Active' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <flux:button href="{{ auth()->user()->role === 'admin' ? route('admin.reports.game-fowls.show', $fowl) : route('staff.reports.game-fowls.show', $fowl) }}" size="sm" variant="primary" icon="document-text" wire:navigate>
                                    View Report
                                </flux:button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                                <div class="flex flex-col items-center justify-center">
                                    <flux:icon icon="document-magnifying-glass" class="h-12 w-12 text-slate-300 dark:text-slate-600 mb-3" />
                                    <p class="text-lg font-medium text-slate-900 dark:text-white">No game fowls found</p>
                                    <p class="text-sm">Try adjusting your search terms.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50">
            {{ $gameFowls->links() }}
        </div>
    </div>
</div>
