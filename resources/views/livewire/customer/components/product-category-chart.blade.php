<div 
    class="bg-white dark:bg-slate-900 rounded-3xl p-6 shadow-lg border border-slate-100 dark:border-slate-800"
    x-data="productCategoryChart({{ json_encode($chartData) }})"
>
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-lg font-bold text-slate-800 dark:text-white uppercase tracking-tight">Product Preference</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400">Items bought by category</p>
        </div>
        <div class="p-2 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 rounded-xl">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
        </div>
    </div>

    <div class="relative h-64 w-full">
        <canvas x-ref="canvas"></canvas>
    </div>
    
    <div class="mt-4 grid grid-cols-2 gap-4">
        @foreach($chartData as $item)
        <div class="flex items-center gap-2">
            <div class="w-3 h-3 rounded-full {{ $item->category === 'Feeds' ? 'bg-emerald-600' : 'bg-green-300' }}"></div>
            <div class="flex flex-col">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $item->category }}</span>
                <span class="text-sm font-bold text-slate-900 dark:text-white">{{ number_format($item->val) }} Units</span>
            </div>
        </div>
        @endforeach
    </div>
</div>
