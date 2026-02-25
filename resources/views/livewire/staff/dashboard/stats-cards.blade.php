<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <!-- Game Fowls -->
    <div class="bg-[#103e28] rounded-xl border border-[#103e28] p-6 shadow-sm text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-emerald-100">Total Game Fowls</p>
                <p class="text-2xl font-bold mt-1">{{ $totalGameFowls }}</p>
            </div>
            <div class="p-3 bg-white/20 rounded-full">
                <flux:icon :icon="'trophy'" class="size-6 text-white" />
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('staff.game-fowls.index') }}" class="text-sm text-emerald-200 hover:text-white font-medium" wire:navigate>View All &rarr;</a>
        </div>
    </div>

    <!-- Today's Eggs -->
    <div class="bg-[#103e28] rounded-xl border border-[#103e28] p-6 shadow-sm text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-emerald-100">Eggs Collected Today</p>
                <p class="text-2xl font-bold mt-1">{{ $todayEggs }}</p>
            </div>
            <div class="p-3 bg-white/20 rounded-full">
                <flux:icon :icon="'circle-stack'" class="size-6 text-white" />
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('staff.egg-collections.index') }}" class="text-sm text-emerald-200 hover:text-white font-medium" wire:navigate>View Collections &rarr;</a>
        </div>
    </div>

    <!-- Active Batches -->
    <div class="bg-[#103e28] rounded-xl border border-[#103e28] p-6 shadow-sm text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-emerald-100">Chick Records</p>
                <p class="text-2xl font-bold mt-1">{{ $activeBatches }}</p>
            </div>
            <div class="p-3 bg-white/20 rounded-full">
                <flux:icon :icon="'sparkles'" class="size-6 text-white" />
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('staff.chick-rearings.index') }}" class="text-sm text-emerald-200 hover:text-white font-medium" wire:navigate>Manage Chicks &rarr;</a>
        </div>
    </div>

    <!-- Low Stock Feeds -->
    <div class="bg-[#103e28] rounded-xl border border-[#103e28] p-6 shadow-sm text-white">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-emerald-100">Low Stock Products</p>
                <p class="text-2xl font-bold mt-1">{{ $lowStockFeeds }}</p>
            </div>
            <div class="p-3 bg-white/20 rounded-full">
                <flux:icon :icon="'archive-box'" class="size-6 text-white" />
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('staff.products.index') }}" class="text-sm text-emerald-200 hover:text-white font-medium" wire:navigate>Check Inventory &rarr;</a>
        </div>
    </div>
</div>
