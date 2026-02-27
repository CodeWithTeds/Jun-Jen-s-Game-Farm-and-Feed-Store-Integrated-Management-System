<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h2 class="text-3xl font-bold text-slate-900 dark:text-white">Game Fowl Shop</h2>
                <p class="text-slate-500 dark:text-slate-400 mt-2">Browse our selection of premium game fowls.</p>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
                <div class="w-full sm:w-64">
                    <flux:input wire:model.live="search" icon="magnifying-glass" placeholder="Search game fowls..." />
                </div>
                <div class="w-full sm:w-48">
                    <select wire:model.live="sort" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-300 dark:focus:border-emerald-500 transition-shadow">
                        <option value="latest">Latest Arrivals</option>
                        <option value="price_asc">Price: Low to High</option>
                        <option value="price_desc">Price: High to Low</option>
                    </select>
                </div>
            </div>
        </div>

        @if($gameFowls->isEmpty())
            <div class="text-center py-12 bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700">
                <flux:icon icon="shopping-bag" class="mx-auto h-12 w-12 text-slate-400" />
                <h3 class="mt-2 text-sm font-semibold text-slate-900 dark:text-white">No game fowls found</h3>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Try adjusting your search or check back later.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($gameFowls as $fowl)
                    <div class="group bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden hover:shadow-lg transition-all duration-300">
                        <div class="relative aspect-square overflow-hidden bg-slate-100 dark:bg-slate-900">
                            <img 
                                src="{{ $fowl->image ? Storage::url($fowl->image) : 'https://ui-avatars.com/api/?name=' . urlencode($fowl->name) . '&background=random' }}" 
                                alt="{{ $fowl->name }}" 
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                            >
                            <div class="absolute top-2 right-2">
                                <span class="px-2 py-1 text-xs font-bold uppercase tracking-wide text-white bg-emerald-600 rounded-md shadow-sm">
                                    For Sale
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-5">
                            <div class="flex justify-between items-start mb-2">
                                <div>
                                    <h3 class="font-bold text-lg text-slate-900 dark:text-white line-clamp-1">{{ $fowl->name }}</h3>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 font-mono">{{ $fowl->tag_id }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="block text-lg font-bold text-emerald-600 dark:text-emerald-400">₱{{ number_format($fowl->price, 2) }}</span>
                                </div>
                            </div>

                            <div class="space-y-2 mb-4">
                                <div class="flex justify-between text-sm">
                                    <span class="text-slate-500 dark:text-slate-400">Age</span>
                                    <span class="font-medium text-slate-900 dark:text-white">{{ $fowl->current_age }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-slate-500 dark:text-slate-400">Sex</span>
                                    <span class="font-medium text-slate-900 dark:text-white">{{ $fowl->sex }}</span>
                                </div>
                            </div>

                            <flux:button wire:click="addToCart({{ $fowl->id }})" class="w-full justify-center !bg-[#103e28] hover:!bg-[#0d3321] !text-white" icon="shopping-cart">
                                Add to Cart
                            </flux:button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $gameFowls->links() }}
            </div>
        @endif
    </div>
</div>
