<div class="overflow-x-auto rounded-xl border border-zinc-200 dark:border-zinc-700">
    <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
        <thead class="bg-zinc-50 dark:bg-zinc-900/50">
            <tr>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">{{ __('Date') }}</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">{{ __('User') }}</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">{{ __('Action') }}</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">{{ __('Setting') }}</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">{{ __('Old Value') }}</th>
                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-zinc-500 uppercase tracking-wider">{{ __('New Value') }}</th>
                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-zinc-500 uppercase tracking-wider">{{ __('Actions') }}</th>
            </tr>
        </thead>
        <tbody class="bg-white dark:bg-zinc-900 divide-y divide-zinc-200 dark:divide-zinc-700">
            @forelse($history as $log)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                        {{ $log->created_at->format('Y-m-d H:i:s') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-zinc-900 dark:text-zinc-100">
                        {{ $log->user->name ?? 'System' }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $log->event === 'updated' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                            {{ ucfirst($log->event) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                        {{ $log->auditable->label ?? $log->auditable->key ?? 'Unknown' }}
                    </td>
                    <td class="px-6 py-4 text-sm text-zinc-500 dark:text-zinc-400 max-w-xs truncate" title="{{ json_encode($log->old_values['value'] ?? '') }}">
                        {{ \Illuminate\Support\Str::limit(json_encode($log->old_values['value'] ?? ''), 30) }}
                    </td>
                    <td class="px-6 py-4 text-sm text-zinc-500 dark:text-zinc-400 max-w-xs truncate" title="{{ json_encode($log->new_values['value'] ?? '') }}">
                        {{ \Illuminate\Support\Str::limit(json_encode($log->new_values['value'] ?? ''), 30) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        @if($log->event === 'updated' && isset($log->old_values['value']))
                            <button 
                                wire:click="rollback({{ $log->id }})" 
                                wire:confirm="{{ __('Are you sure you want to rollback this change? The current setting value will be replaced with the old value.') }}"
                                class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300"
                            >
                                {{ __('Rollback') }}
                            </button>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-sm text-zinc-500 dark:text-zinc-400">
                        {{ __('No history found.') }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>