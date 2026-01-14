<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Game Fowls -->
    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Game Fowls</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100 mt-1">{{ $totalGameFowls }}</p>
            </div>
            <div class="p-3 bg-indigo-50 dark:bg-indigo-500/10 rounded-full">
                <flux:icon :icon="'trophy'" class="size-6 text-indigo-600 dark:text-indigo-400" />
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('staff.game-fowls.index') }}" class="text-sm text-indigo-600 hover:text-indigo-500 font-medium" wire:navigate>View All &rarr;</a>
        </div>
    </div>

    <!-- Today's Eggs -->
    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Eggs Collected Today</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100 mt-1">{{ $todayEggs }}</p>
            </div>
            <div class="p-3 bg-amber-50 dark:bg-amber-500/10 rounded-full">
                <flux:icon :icon="'circle-stack'" class="size-6 text-amber-600 dark:text-amber-400" />
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('staff.egg-collections.index') }}" class="text-sm text-indigo-600 hover:text-indigo-500 font-medium" wire:navigate>View Collections &rarr;</a>
        </div>
    </div>

    <!-- Active Batches -->
    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Chick Records</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100 mt-1">{{ $activeBatches }}</p>
            </div>
            <div class="p-3 bg-yellow-50 dark:bg-yellow-500/10 rounded-full">
                <flux:icon :icon="'sparkles'" class="size-6 text-yellow-600 dark:text-yellow-400" />
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('staff.chick-rearings.index') }}" class="text-sm text-indigo-600 hover:text-indigo-500 font-medium" wire:navigate>Manage Chicks &rarr;</a>
        </div>
    </div>

    <!-- Low Stock Feeds -->
    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Low Stock Products</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100 mt-1 {{ $lowStockFeeds > 0 ? 'text-red-600 dark:text-red-400' : '' }}">{{ $lowStockFeeds }}</p>
            </div>
            <div class="p-3 bg-blue-50 dark:bg-blue-500/10 rounded-full">
                <flux:icon :icon="'archive-box'" class="size-6 text-blue-600 dark:text-blue-400" />
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('staff.products.index') }}" class="text-sm text-indigo-600 hover:text-indigo-500 font-medium" wire:navigate>Check Inventory &rarr;</a>
        </div>
    </div>
</div>
