<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 space-y-8" wire:poll.30s>
    <!-- Welcome Header -->
    <div class="bg-[#103e28] rounded-3xl p-8 text-white relative overflow-hidden shadow-lg">
        <div class="flex justify-between items-start mb-8 relative z-10">
            <div class="flex space-x-6 text-sm font-medium text-green-100/80">
                <span class="text-white border-b-2 border-green-400 pb-1">Dashboard</span>
                <a href="{{ route('customer.products.index') }}" class="hover:text-white transition flex items-center gap-1">
                    Shop Now
                    <flux:icon name="arrow-right" class="w-3 h-3" />
                </a>
                <a href="{{ route('customer.orders.index') }}" class="hover:text-white transition">My Orders</a>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right">
                    <p class="text-xs text-green-200 uppercase tracking-wider font-semibold">Current Date</p>
                    <p class="font-medium">{{ now()->format('M d, Y') }}</p>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-end relative z-10">
            <div>
                <h1 class="text-4xl md:text-5xl font-bold mb-4 tracking-tight">
                    Welcome back, <br>
                    <span class="text-green-300">{{ auth()->user()->name }}</span>
                </h1>
                <p class="text-green-100/80 max-w-md text-lg">
                    Track your orders, view your spending history, and discover new products for your farm.
                </p>
            </div>
            <div class="hidden md:block absolute right-0 bottom-0 opacity-10 pointer-events-none transform translate-x-10 translate-y-10">
                <flux:icon name="shopping-bag" class="w-80 h-80 text-white" />
            </div>
        </div>
        
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-gradient-to-br from-transparent to-black/20 z-0"></div>
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-green-500/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-emerald-600/20 rounded-full blur-3xl"></div>
    </div>

    <!-- Stats Cards Component -->
    <livewire:customer.components.stats-cards />

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Spending Analytics Chart Component -->
        <div class="lg:col-span-2">
            <livewire:customer.components.spending-chart />
        </div>

        <!-- Quick Actions & Support -->
        <div class="space-y-8">
            <!-- Quick Actions -->
            <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-3xl p-6 text-white shadow-lg relative overflow-hidden group">
                <div class="relative z-10">
                    <h3 class="text-xl font-bold mb-2">Start Shopping</h3>
                    <p class="text-green-100 mb-6 text-sm">Browse our latest collection of premium feeds and supplies.</p>
                    <a href="{{ route('customer.products.index') }}" class="inline-flex items-center justify-center bg-white text-green-600 px-6 py-3 rounded-xl font-bold hover:bg-green-50 transition shadow-md w-full sm:w-auto">
                        Browse Catalog
                    </a>
                </div>
                <div class="absolute right-0 top-0 h-full w-1/2 opacity-10 transform translate-x-1/4 group-hover:translate-x-0 transition duration-500">
                    <flux:icon name="shopping-cart" class="w-full h-full" />
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders Component -->
    <livewire:customer.components.recent-orders />
</div>
