@assets
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endassets

<div class="bg-white dark:bg-zinc-900 rounded-3xl p-6 shadow-lg border border-zinc-100 dark:border-zinc-800"
     x-data="customerSpendingChart(@js($chartData))">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-100 flex items-center gap-2">
                <flux:icon name="chart-bar" class="w-5 h-5 text-green-500" />
                Spending Analytics
            </h3>
            <p class="text-sm text-zinc-500 mt-1">Your purchase history over time</p>
        </div>
        <select wire:model.live="dateRange" class="w-full sm:w-auto rounded-lg border-zinc-200 text-sm focus:ring-green-500 dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-300 py-1.5 px-3 bg-gray-50 dark:bg-zinc-800/50">
            <option value="7_days">Last 7 Days</option>
            <option value="30_days">Last 30 Days</option>
            <option value="this_month">This Month</option>
        </select>
    </div>
    
    <div class="relative h-72 w-full">
        <canvas x-ref="canvas"></canvas>
    </div>
</div>
