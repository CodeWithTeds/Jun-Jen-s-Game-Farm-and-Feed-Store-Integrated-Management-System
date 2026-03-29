@assets
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endassets

<div class="bg-white dark:bg-slate-900 rounded-3xl p-6 shadow-lg border border-slate-100 dark:border-slate-800"
     x-data="customerSpendingChart(@js($chartData))">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h3 class="text-lg font-bold text-slate-900 dark:text-slate-100 flex items-center gap-2">
                <flux:icon name="chart-bar" class="w-5 h-5 text-green-500" />
                Spending Analytics
            </h3>
            <p class="text-sm text-slate-500 mt-1">Your purchase history over time</p>
        </div>
    </div>
    
    <div class="relative h-72 w-full">
        <canvas x-ref="canvas"></canvas>
    </div>
</div>
