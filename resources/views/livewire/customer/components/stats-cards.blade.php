<div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative z-10">
    <!-- Total Spent -->
    <div class="bg-white dark:bg-zinc-900 rounded-3xl p-6 shadow-lg border border-zinc-100 dark:border-zinc-800 hover:border-green-200 dark:hover:border-green-800 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                    <flux:icon name="banknotes" class="w-6 h-6" />
                </div>
                <span class="text-sm font-semibold text-zinc-500 dark:text-zinc-400">Total Spent</span>
            </div>
            <div class="flex items-center text-xs font-medium text-green-600 bg-green-50 dark:bg-green-900/20 px-2 py-1 rounded-full">
                <flux:icon name="arrow-trending-up" class="w-3 h-3 mr-1" />
                Lifetime
            </div>
        </div>
        <div class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">₱{{ number_format($stats['total_spent'], 2) }}</div>
        <div class="mt-2 text-xs text-zinc-400 dark:text-zinc-500">Total value of all purchases</div>
    </div>

    <!-- Total Orders -->
    <div class="bg-white dark:bg-zinc-900 rounded-3xl p-6 shadow-lg border border-zinc-100 dark:border-zinc-800 hover:border-blue-200 dark:hover:border-blue-800 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                    <flux:icon name="shopping-bag" class="w-6 h-6" />
                </div>
                <span class="text-sm font-semibold text-zinc-500 dark:text-zinc-400">Total Orders</span>
            </div>
            <div class="flex items-center text-xs font-medium text-blue-600 bg-blue-50 dark:bg-blue-900/20 px-2 py-1 rounded-full">
                <flux:icon name="check-circle" class="w-3 h-3 mr-1" />
                Completed
            </div>
        </div>
        <div class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ number_format($stats['total_orders']) }}</div>
        <div class="mt-2 text-xs text-zinc-400 dark:text-zinc-500">Successful transactions</div>
    </div>

    <!-- Active Orders -->
    <div class="bg-white dark:bg-zinc-900 rounded-3xl p-6 shadow-lg border border-zinc-100 dark:border-zinc-800 hover:border-yellow-200 dark:hover:border-yellow-800 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-yellow-50 dark:bg-yellow-900/20 text-yellow-600 dark:text-yellow-400 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                    <flux:icon name="truck" class="w-6 h-6" />
                </div>
                <span class="text-sm font-semibold text-zinc-500 dark:text-zinc-400">Active Orders</span>
            </div>
            @if($stats['active_orders'] > 0)
                <div class="flex items-center text-xs font-medium text-yellow-600 bg-yellow-50 dark:bg-yellow-900/20 px-2 py-1 rounded-full animate-pulse">
                    <span class="w-2 h-2 bg-yellow-500 rounded-full mr-1.5"></span>
                    Live
                </div>
            @else
                <div class="flex items-center text-xs font-medium text-zinc-400 bg-zinc-50 dark:bg-zinc-800 px-2 py-1 rounded-full">
                    No active
                </div>
            @endif
        </div>
        <div class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ number_format($stats['active_orders']) }}</div>
        <div class="mt-2 text-xs text-zinc-400 dark:text-zinc-500">Orders in progress</div>
    </div>
</div>
