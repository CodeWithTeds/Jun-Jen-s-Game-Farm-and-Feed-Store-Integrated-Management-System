<div class="grid grid-cols-1 gap-8 relative z-10 max-w-sm">
    <!-- Total Orders -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl p-6 shadow-lg border border-slate-100 dark:border-slate-800 hover:border-blue-200 dark:hover:border-blue-800 transition-all duration-300 group">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-2xl group-hover:scale-110 transition-transform duration-300">
                    <flux:icon name="shopping-bag" class="w-6 h-6" />
                </div>
                <span class="text-sm font-semibold text-slate-500 dark:text-slate-400">Total Orders</span>
            </div>
            <div class="flex items-center text-xs font-medium text-blue-600 bg-blue-50 dark:bg-blue-900/20 px-2 py-1 rounded-full">
                <flux:icon name="check-circle" class="w-3 h-3 mr-1" />
                Completed
            </div>
        </div>
        <div class="text-3xl font-bold text-slate-900 dark:text-slate-100">{{ number_format($stats['total_orders']) }}</div>
        <div class="mt-2 text-xs text-slate-400 dark:text-slate-500">Successful transactions</div>
    </div>
</div>
