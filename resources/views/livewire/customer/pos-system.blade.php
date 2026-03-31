<div class="flex h-[calc(100vh-6rem)] gap-6">
    <!-- Left Side: Order Menu -->
    <div class="flex-1 flex flex-col bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
        <!-- Header -->
        <div class="p-4 border-b border-slate-200 dark:border-slate-700 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Order Menu</h2>
            <div class="relative w-64">
                <input type="text" wire:model.live="search" placeholder="Search..." class="w-full pl-10 pr-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-white focus:ring-2 focus:ring-emerald-500">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>

        <!-- Categories -->
        <div class="p-4 border-b border-slate-200 dark:border-slate-700 flex gap-2 overflow-x-auto">
            <button wire:click="$set('feedType', '')" 
               class="px-4 py-2 rounded-full font-medium whitespace-nowrap {{ $feedType === '' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900 dark:text-emerald-300' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-slate-800 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                All Items
            </button>
            @foreach($categories as $category)
                <button wire:click="$set('feedType', '{{ $category }}')" 
                   class="px-4 py-2 rounded-full font-medium whitespace-nowrap {{ $feedType === $category ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900 dark:text-emerald-300' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-slate-800 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    {{ $category }}
                </button>
            @endforeach
        </div>

        <!-- Grid -->
        <div class="flex-1 overflow-y-auto p-4 relative">
            <!-- Loading Overlay -->
            <div wire:loading.flex wire:target="search, feedType" class="absolute inset-0 bg-white/50 dark:bg-slate-900/50 flex items-center justify-center z-10">
                <svg class="animate-spin h-8 w-8 text-emerald-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @if($feedType === 'Game Fowl')
                    @foreach($gameFowls as $fowl)
                        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm hover:shadow-md transition cursor-pointer relative group" wire:click="addGameFowlToCart({{ $fowl->id }})">
                            <div class="aspect-square w-full overflow-hidden rounded-t-xl bg-gray-100 dark:bg-slate-700 relative">
                                @if($fowl->image)
                                    <img src="{{ Storage::url($fowl->image) }}" alt="{{ $fowl->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="flex items-center justify-center h-full text-gray-400">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($fowl->name) }}&background=random" alt="{{ $fowl->name }}" class="w-full h-full object-cover">
                                    </div>
                                @endif
                                <div class="absolute bottom-2 right-2 bg-white dark:bg-slate-900 px-2 py-1 rounded-lg text-xs font-bold shadow-sm">
                                    ₱{{ number_format($fowl->price, 2) }}
                                </div>
                                <!-- Hover Overlay for View Details -->
                                <div class="absolute inset-0 bg-black/10 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button wire:click.stop="viewGameFowl({{ $fowl->id }})" class="bg-white/90 hover:bg-white text-gray-900 px-4 py-2 rounded-lg shadow-lg font-medium flex items-center gap-2 transform hover:scale-105 transition-all" title="View Details">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        View Details
                                    </button>
                                </div>
                            </div>
                            <div class="p-3">
                                <h3 class="font-medium text-gray-900 dark:text-white truncate">{{ $fowl->name }}</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $fowl->sex }} • {{ $fowl->current_age }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    @foreach($feeds as $feed)
                        <div class="bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm transition relative {{ $feed->quantity == 0 ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer hover:shadow-md group' }}" @if($feed->quantity > 0) wire:click="addToCart({{ $feed->id }})" @endif>
                            <div class="aspect-square w-full overflow-hidden rounded-t-xl bg-gray-100 dark:bg-slate-700 relative">
                                @if($feed->image)
                                    <img src="{{ Storage::url($feed->image) }}" alt="{{ $feed->feed_name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="flex items-center justify-center h-full text-gray-400">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                                <div class="absolute bottom-2 right-2 bg-white dark:bg-slate-900 px-2 py-1 rounded-lg text-xs font-bold shadow-sm">
                                    ₱{{ number_format($feed->price, 2) }}
                                </div>
                                <!-- Hover Overlay for View Details -->
                                <div class="absolute inset-0 bg-black/10 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button wire:click.stop="viewFeed({{ $feed->id }})" class="bg-white/90 hover:bg-white text-gray-900 px-4 py-2 rounded-lg shadow-lg font-medium flex items-center gap-2 transform hover:scale-105 transition-all" title="View Details">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        View Details
                                    </button>
                                </div>
                            </div>
                            <div class="p-3">
                                <h3 class="font-medium text-gray-900 dark:text-white truncate">{{ $feed->feed_name }}</h3>
                                <div class="mt-1 flex justify-between items-center">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $feed->quantity }} in stock</p>
                                    @if($feed->quantity == 0)
                                        <span class="text-[10px] font-bold text-red-600 bg-red-100 dark:bg-red-900/30 dark:text-red-400 px-2 py-0.5 rounded-full">Out of Stock</span>
                                    @elseif($feed->quantity <= 10)
                                        <span class="text-[10px] font-bold text-orange-600 bg-orange-100 dark:bg-orange-900/30 dark:text-orange-400 px-2 py-0.5 rounded-full">Low Stock</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            
            <div class="mt-4">
                @if($feedType === 'Game Fowl')
                    {{ $gameFowls->links() }}
                @else
                    {{ $feeds->links() }}
                @endif
            </div>
        </div>
    </div>

    <!-- Right Side: Order Details -->
    <div class="w-96 flex flex-col bg-white dark:bg-slate-900 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 h-full">
        <div class="p-4 border-b border-slate-200 dark:border-slate-700 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Order Details</h2>
            <span class="px-2 py-1 bg-gray-100 dark:bg-slate-800 rounded text-xs font-medium text-gray-600 dark:text-gray-400">Table</span>
        </div>

        <div class="p-4 space-y-4 border-b border-slate-200 dark:border-slate-700">
            <div>
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Customer Name</label>
                <div class="w-full p-2 bg-gray-50 dark:bg-slate-800 rounded border border-slate-200 dark:border-slate-700 text-sm">
                    {{ auth()->user()->name }}
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Note</label>
                <input type="text" wire:model="note" class="w-full p-2 bg-white dark:bg-slate-800 rounded border border-slate-200 dark:border-slate-700 text-sm focus:ring-2 focus:ring-emerald-500" placeholder="Add a note...">
            </div>
        </div>

        <!-- Cart Items -->
        <div class="flex-1 overflow-y-auto p-4 space-y-3 relative">
             <div wire:loading.flex wire:target="refreshCart, addToCart, updateQuantity, removeFromCart, checkout" class="absolute inset-0 bg-white/50 dark:bg-slate-900/50 flex items-center justify-center z-10">
                <svg class="animate-spin h-8 w-8 text-emerald-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>

            @if(!$cart || $cart->items->isEmpty())
                <div class="text-center text-gray-500 dark:text-gray-400 py-8">
                    Cart is empty
                </div>
            @else
                @foreach($cart->items as $item)
                    <div class="flex gap-3 bg-gray-50 dark:bg-slate-800/50 p-2 rounded-lg relative group">
                        <div class="w-12 h-12 rounded bg-gray-100 dark:bg-slate-700 overflow-hidden flex-shrink-0">
                            @if($item->feed)
                                @if($item->feed->image)
                                    <img src="{{ Storage::url($item->feed->image) }}" class="w-full h-full object-cover">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($item->feed->feed_name) }}&background=random" class="w-full h-full object-cover">
                                @endif
                            @elseif($item->gameFowl)
                                @if($item->gameFowl->image)
                                    <img src="{{ Storage::url($item->gameFowl->image) }}" class="w-full h-full object-cover">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($item->gameFowl->name) }}&background=random" class="w-full h-full object-cover">
                                @endif
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            @if($item->feed)
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $item->feed->feed_name }}</h4>
                                <div class="text-xs text-gray-500 dark:text-gray-400">₱{{ number_format($item->feed->price, 2) }}</div>
                                <div class="flex items-center gap-2 mt-2">
                                    <button wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})" class="w-6 h-6 flex-shrink-0 flex items-center justify-center rounded bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 hover:bg-gray-50 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-300">-</button>
                                    <input type="number" 
                                           value="{{ $item->quantity }}" 
                                           wire:change="updateQuantity({{ $item->id }}, $event.target.value)" 
                                           min="1"
                                           class="w-12 h-6 px-1 py-0 text-center text-sm font-medium border border-slate-200 dark:border-slate-600 rounded bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-1 focus:border-emerald-500 focus:ring-emerald-500 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                    <button wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})" class="w-6 h-6 flex-shrink-0 flex items-center justify-center rounded bg-emerald-600 text-white hover:bg-emerald-700">+</button>
                                </div>
                            @elseif($item->gameFowl)
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $item->gameFowl->name }}</h4>
                                <div class="text-xs text-gray-500 dark:text-gray-400">₱{{ number_format($item->gameFowl->price, 2) }}</div>
                                <div class="flex items-center gap-2 mt-2">
                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-400">Qty: 1</span>
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-col items-end justify-between">
                            <button wire:click="removeFromCart({{ $item->id }})" class="text-gray-400 hover:text-red-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                            <div class="text-sm font-bold text-gray-900 dark:text-white">
                                @if($item->feed)
                                    ₱{{ number_format($item->feed->price * $item->quantity, 2) }}
                                @elseif($item->gameFowl)
                                    ₱{{ number_format($item->gameFowl->price * $item->quantity, 2) }}
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Footer -->
        <div class="p-4 bg-gray-50 dark:bg-slate-800/50 border-t border-slate-200 dark:border-slate-700 space-y-3">
            <div class="flex justify-between text-sm">
                <span class="text-gray-500 dark:text-gray-400">Sub Total</span>
                <span class="font-medium text-gray-900 dark:text-white">₱{{ number_format($this->subtotal, 2) }}</span>
            </div>
            <div class="border-t border-dashed border-slate-300 dark:border-slate-600 my-2"></div>
            <div class="flex justify-between text-lg font-bold">
                <span class="text-gray-900 dark:text-white">Total</span>
                <span class="text-emerald-600 dark:text-emerald-400">₱{{ number_format($this->subtotal, 2) }}</span>
            </div>
            
            <button wire:click="openCheckoutModal" 
                    wire:loading.attr="disabled"
                    wire:target="openCheckoutModal"
                    class="w-full py-3 rounded-xl bg-emerald-600 text-white font-bold shadow-lg shadow-emerald-200 dark:shadow-none hover:bg-emerald-700 transition active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed">
                <span wire:loading.remove wire:target="openCheckoutModal">Proceed to Payment</span>
                <span wire:loading wire:target="openCheckoutModal">Loading...</span>
            </button>
        </div>
    <!-- Toast Notification -->
    <div x-data="{ show: false, message: '', type: 'success' }" 
         x-on:toast.window="show = true; message = $event.detail.message; type = $event.detail.type || 'success'; setTimeout(() => show = false, 3000)"
         class="fixed bottom-4 right-4 z-50"
         style="display: none;"
         x-show="show"
         x-transition
         x-cloak>
        <div :class="type === 'error' ? 'bg-red-500' : 'bg-green-500'" class="text-white px-6 py-3 rounded-lg shadow-lg font-medium">
            <span x-text="message"></span>
        </div>
    </div>

    <!-- Product Details Modal -->
    @if($selectedFeed)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" wire:click.self="closeFeedModal">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl max-w-2xl w-full overflow-hidden max-h-[90vh] flex flex-col">
            <!-- Header -->
            <div class="p-4 border-b border-slate-200 dark:border-slate-700 flex justify-between items-center bg-gray-50 dark:bg-slate-800/50">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white truncate pr-4">{{ $selectedFeed->feed_name }}</h3>
                <button wire:click="closeFeedModal" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <!-- Body -->
            <div class="flex-1 overflow-y-auto p-6">
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Image -->
                    <div class="w-full md:w-1/2 flex-shrink-0">
                        <div class="aspect-square rounded-xl overflow-hidden bg-gray-100 dark:bg-slate-700 border border-slate-200 dark:border-slate-600">
                            @if($selectedFeed->image)
                                <img src="{{ Storage::url($selectedFeed->image) }}" alt="{{ $selectedFeed->feed_name }}" class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400">
                                    <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Details -->
                    <div class="w-full md:w-1/2 space-y-4">
                        <div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200">
                                {{ $selectedFeed->feed_type }}
                            </span>
                        </div>
                        
                        <div>
                            <div class="text-3xl font-bold text-emerald-600 dark:text-emerald-400">₱{{ number_format($selectedFeed->price, 2) }}</div>
                            <div class="flex items-center gap-2 mt-1">
                                <div class="text-sm text-gray-500 dark:text-gray-400">{{ $selectedFeed->quantity }} units available</div>
                                @if($selectedFeed->quantity == 0)
                                    <span class="text-[10px] font-bold text-red-600 bg-red-100 dark:bg-red-900/30 dark:text-red-400 px-2 py-0.5 rounded-full">Out of Stock</span>
                                @elseif($selectedFeed->quantity <= 10)
                                    <span class="text-[10px] font-bold text-orange-600 bg-orange-100 dark:bg-orange-900/30 dark:text-orange-400 px-2 py-0.5 rounded-full">Low Stock</span>
                                @endif
                            </div>
                        </div>

                        <div class="space-y-2">
                            <div class="flex justify-between border-b border-slate-100 dark:border-slate-700 py-2">
                                <span class="text-gray-500 dark:text-gray-400">Brand</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $selectedFeed->brand }}</span>
                            </div>
                            <div class="flex justify-between border-b border-slate-100 dark:border-slate-700 py-2">
                                <span class="text-gray-500 dark:text-gray-400">Batch Number</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $selectedFeed->batch_number }}</span>
                            </div>
                            <div class="flex justify-between border-b border-slate-100 dark:border-slate-700 py-2">
                                <span class="text-gray-500 dark:text-gray-400">Expiration Date</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $selectedFeed->expiration_date }}</span>
                            </div>
                        </div>

                        @if($selectedFeed->remarks)
                            <div class="pt-4">
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-1">Description</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">{{ $selectedFeed->remarks }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="p-4 border-t border-slate-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50 flex justify-end gap-3">
                <button wire:click="closeFeedModal" class="px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-100 dark:hover:bg-slate-700 transition">
                    Close
                </button>
                <button wire:click="addToCart({{ $selectedFeed->id }})" class="px-6 py-2 rounded-lg bg-emerald-600 text-white font-bold hover:bg-emerald-700 shadow-lg shadow-emerald-200 dark:shadow-none transition disabled:opacity-50 disabled:cursor-not-allowed" @if($selectedFeed->quantity == 0) disabled @endif>
                    @if($selectedFeed->quantity == 0) Out of Stock @else Add to Cart @endif
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Game Fowl Details Modal -->
    @if($selectedGameFowl)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" wire:click.self="closeFeedModal">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl max-w-2xl w-full overflow-hidden max-h-[90vh] flex flex-col">
            <!-- Header -->
            <div class="p-4 border-b border-slate-200 dark:border-slate-700 flex justify-between items-center bg-gray-50 dark:bg-slate-800/50">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white truncate pr-4">{{ $selectedGameFowl->name }}</h3>
                <button wire:click="closeFeedModal" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <!-- Body -->
            <div class="flex-1 overflow-y-auto p-6">
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Image -->
                    <div class="w-full md:w-1/2 flex-shrink-0">
                        <div class="aspect-square rounded-xl overflow-hidden bg-gray-100 dark:bg-slate-700 border border-slate-200 dark:border-slate-600">
                            @if($selectedGameFowl->image)
                                <img src="{{ Storage::url($selectedGameFowl->image) }}" alt="{{ $selectedGameFowl->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($selectedGameFowl->name) }}&background=random" alt="{{ $selectedGameFowl->name }}" class="w-full h-full object-cover">
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Details -->
                    <div class="w-full md:w-1/2 space-y-4">
                        <div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200">
                                Game Fowl
                            </span>
                        </div>
                        
                        <div>
                            <div class="text-3xl font-bold text-emerald-600 dark:text-emerald-400">₱{{ number_format($selectedGameFowl->price, 2) }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">Tag ID: {{ $selectedGameFowl->tag_id }}</div>
                        </div>

                        <div class="space-y-2">
                            <div class="flex justify-between border-b border-slate-100 dark:border-slate-700 py-2">
                                <span class="text-gray-500 dark:text-gray-400">Sex</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $selectedGameFowl->sex }}</span>
                            </div>
                            <div class="flex justify-between border-b border-slate-100 dark:border-slate-700 py-2">
                                <span class="text-gray-500 dark:text-gray-400">Age</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $selectedGameFowl->current_age }}</span>
                            </div>
                            <div class="flex justify-between border-b border-slate-100 dark:border-slate-700 py-2">
                                <span class="text-gray-500 dark:text-gray-400">Growth Phase</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $selectedGameFowl->stage_growth_phase }}</span>
                            </div>
                        </div>

                        @if($selectedGameFowl->special_notes)
                            <div class="pt-4">
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-1">Description</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">{{ $selectedGameFowl->special_notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="p-4 border-t border-slate-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-800/50 flex justify-end gap-3">
                <button wire:click="closeFeedModal" class="px-4 py-2 rounded-lg border border-slate-300 dark:border-slate-600 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-100 dark:hover:bg-slate-700 transition">
                    Close
                </button>
                <button wire:click="addGameFowlToCart({{ $selectedGameFowl->id }})" class="px-6 py-2 rounded-lg bg-emerald-600 text-white font-bold hover:bg-emerald-700 shadow-lg shadow-emerald-200 dark:shadow-none transition">
                    Add to Cart
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Checkout Modal -->
    @if($showCheckoutModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" wire:click.self="closeCheckoutModal">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-xl max-w-5xl w-full overflow-hidden flex flex-col max-h-[90vh]">
            <!-- Header -->
            <div class="p-6 border-b border-slate-200 dark:border-slate-700 flex justify-between items-center bg-gray-50 dark:bg-slate-800/50">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">Checkout</h3>
                <button wire:click="closeCheckoutModal" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <!-- Body -->
            <div class="flex-1 overflow-hidden flex flex-col md:flex-row">
                <!-- Left Side: Order Summary -->
                <div class="w-full md:w-1/2 p-6 overflow-y-auto bg-gray-50 dark:bg-slate-800/30 border-r border-slate-200 dark:border-slate-700">
                    <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Order Summary</h4>
                    
                    <div class="space-y-4 mb-6">
                        @foreach($cart->items as $item)
                            <div class="flex gap-4 bg-white dark:bg-slate-800 p-3 rounded-lg shadow-sm border border-slate-100 dark:border-slate-700">
                                <div class="w-16 h-16 rounded-lg bg-gray-100 dark:bg-slate-700 overflow-hidden flex-shrink-0">
                                    @if($item->feed)
                                        @if($item->feed->image)
                                            <img src="{{ Storage::url($item->feed->image) }}" class="w-full h-full object-cover">
                                        @endif
                                    @elseif($item->gameFowl)
                                        @if($item->gameFowl->image)
                                            <img src="{{ Storage::url($item->gameFowl->image) }}" class="w-full h-full object-cover">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($item->gameFowl->name) }}&background=random" class="w-full h-full object-cover">
                                        @endif
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    @if($item->feed)
                                        <h5 class="font-medium text-gray-900 dark:text-white truncate">{{ $item->feed->feed_name }}</h5>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $item->quantity }} x ₱{{ number_format($item->feed->price, 2) }}</p>
                                    @elseif($item->gameFowl)
                                        <h5 class="font-medium text-gray-900 dark:text-white truncate">{{ $item->gameFowl->name }}</h5>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Qty: 1 x ₱{{ number_format($item->gameFowl->price, 2) }}</p>
                                    @endif
                                </div>
                                <div class="font-bold text-gray-900 dark:text-white">
                                    @if($item->feed)
                                        ₱{{ number_format($item->quantity * $item->feed->price, 2) }}
                                    @elseif($item->gameFowl)
                                        ₱{{ number_format($item->quantity * $item->gameFowl->price, 2) }}
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-slate-200 dark:border-slate-700 pt-4 space-y-2">
                        <div class="flex justify-between text-gray-600 dark:text-gray-400">
                            <span>Subtotal</span>
                            <span>₱{{ number_format($this->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-xl font-bold text-gray-900 dark:text-white pt-2">
                            <span>Total</span>
                            <span class="text-emerald-600 dark:text-emerald-400">₱{{ number_format($this->subtotal, 2) }}</span>
                        </div>
                        
                        @if($paymentMethod === 'gcash')
                        <div class="mt-4 rounded-xl border border-emerald-200 dark:border-emerald-800 bg-emerald-50/60 dark:bg-emerald-900/20 p-4 space-y-3">
                            <div class="text-sm font-bold text-gray-900 dark:text-white">Send payment to GCash</div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div x-data="{copied:false}">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Account Name</span>
                                        <button @click="navigator.clipboard.writeText($refs.val.innerText); copied=true; setTimeout(()=>copied=false,1500)" class="text-xs px-2 py-1 rounded-lg bg-white dark:bg-slate-800 border border-emerald-300 dark:border-emerald-700 text-emerald-700 dark:text-emerald-300 hover:bg-emerald-50 dark:hover:bg-emerald-900/30">Copy</button>
                                    </div>
                                    <div x-ref="val" class="mt-1 font-mono text-sm text-gray-900 dark:text-white">{{ env('GCASH_ACCOUNT_NAME', 'Feed Store') }}</div>
                                    <div x-show="copied" class="text-emerald-600 dark:text-emerald-400 text-xs mt-1">Copied</div>
                                </div>
                                <div x-data="{copied:false}">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">GCash Number</span>
                                        <button @click="navigator.clipboard.writeText($refs.val.innerText); copied=true; setTimeout(()=>copied=false,1500)" class="text-xs px-2 py-1 rounded-lg bg-white dark:bg-slate-800 border border-emerald-300 dark:border-emerald-700 text-emerald-700 dark:text-emerald-300 hover:bg-emerald-50 dark:hover:bg-emerald-900/30">Copy</button>
                                    </div>
                                    <div x-ref="val" class="mt-1 font-mono text-sm text-gray-900 dark:text-white">{{ env('GCASH_NUMBER', '09999999999') }}</div>
                                    <div x-show="copied" class="text-emerald-600 dark:text-emerald-400 text-xs mt-1">Copied</div>
                                </div>
                            </div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">Include your order number in the transfer message.</div>
                        </div>
                        @endif
                        
                        @if($paymentMethod === 'paymaya')
                        <div class="mt-4 rounded-xl border border-green-200 dark:border-green-800 bg-green-50/60 dark:bg-green-900/20 p-4 space-y-3">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-bold text-gray-900 dark:text-white">Send payment to Maya</span>
                                <span class="text-xs px-2 py-0.5 rounded-full bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-300 font-semibold">e-Wallet</span>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div x-data="{copied:false}">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Account Name</span>
                                        <button @click="navigator.clipboard.writeText($refs.val.innerText); copied=true; setTimeout(()=>copied=false,1500)" class="text-xs px-2 py-1 rounded-lg bg-white dark:bg-slate-800 border border-green-300 dark:border-green-700 text-green-700 dark:text-green-300 hover:bg-green-50 dark:hover:bg-green-900/30">Copy</button>
                                    </div>
                                    <div x-ref="val" class="mt-1 font-mono text-sm text-gray-900 dark:text-white">{{ env('PAYMAYA_ACCOUNT_NAME', 'Feed Store') }}</div>
                                    <div x-show="copied" class="text-green-600 dark:text-green-400 text-xs mt-1">Copied</div>
                                </div>
                                <div x-data="{copied:false}">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">Maya Number</span>
                                        <button @click="navigator.clipboard.writeText($refs.val.innerText); copied=true; setTimeout(()=>copied=false,1500)" class="text-xs px-2 py-1 rounded-lg bg-white dark:bg-slate-800 border border-green-300 dark:border-green-700 text-green-700 dark:text-green-300 hover:bg-green-50 dark:hover:bg-green-900/30">Copy</button>
                                    </div>
                                    <div x-ref="val" class="mt-1 font-mono text-sm text-gray-900 dark:text-white">{{ env('PAYMAYA_NUMBER', '09999999999') }}</div>
                                    <div x-show="copied" class="text-green-600 dark:text-green-400 text-xs mt-1">Copied</div>
                                </div>
                            </div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">Include your order number in the transfer message.</div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Right Side: Shipping & Payment -->
                <div class="w-full md:w-1/2 p-6 overflow-y-auto">
                    <div class="space-y-6">


                        <!-- Payment Method -->
                        <div>
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                Payment Method
                            </h4>
                            
                            <div class="grid grid-cols-3 gap-3">
                                <label class="cursor-pointer relative">
                                    <input type="radio" wire:model.live="paymentMethod" value="cash" class="peer sr-only">
                                    <div class="p-3 rounded-lg border border-slate-200 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-800 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-900/20 peer-checked:ring-1 peer-checked:ring-emerald-500 transition text-center">
                                        <span class="block text-sm font-medium text-gray-900 dark:text-white">Cash</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer relative">
                                    <input type="radio" wire:model.live="paymentMethod" value="gcash" class="peer sr-only">
                                    <div class="p-3 rounded-lg border border-slate-200 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-800 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-900/20 peer-checked:ring-1 peer-checked:ring-emerald-500 transition text-center">
                                        <span class="block text-sm font-medium text-gray-900 dark:text-white">GCash</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer relative">
                                    <input type="radio" wire:model.live="paymentMethod" value="paymaya" class="peer sr-only">
                                    <div class="p-3 rounded-lg border border-slate-200 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-800 peer-checked:border-emerald-500 peer-checked:bg-emerald-50 dark:peer-checked:bg-emerald-900/20 peer-checked:ring-1 peer-checked:ring-emerald-500 transition text-center">
                                        <span class="block text-sm font-medium text-gray-900 dark:text-white">Maya</span>
                                    </div>
                                </label>
                            </div>
                            
                        </div>

                        <!-- Proof of Payment -->
                        @if($paymentMethod !== 'cash')
                        <div class="animate-fade-in-down">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Upload Proof of Payment</label>
                            <div class="flex items-center justify-center w-full">
                                <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-slate-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-slate-800 dark:bg-slate-700 hover:bg-gray-100 dark:border-slate-600 dark:hover:border-slate-500">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        @if($proofOfPayment)
                                            <p class="mb-2 text-sm text-green-500 dark:text-green-400 font-semibold">{{ $proofOfPayment->getClientOriginalName() }}</p>
                                        @else
                                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                            </svg>
                                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                        @endif
                                    </div>
                                    <input id="dropzone-file" type="file" wire:model="proofOfPayment" class="hidden" />
                                </label>
                            </div>
                            @error('proofOfPayment') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        @endif
                        
                        <!-- Cash Payment Details -->
                        @if($paymentMethod === 'cash')
                        <div class="animate-fade-in-down border-t border-slate-200 dark:border-slate-700 pt-6 mt-6">
                            <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                Cash Details
                            </h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Amount Tendered</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">₱</span>
                                        </div>
                                        <input type="number" wire:model.live="amountTendered" class="pl-8 block w-full rounded-lg border border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm" placeholder="0.00">
                                    </div>
                                    @error('amountTendered') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div class="bg-emerald-50 dark:bg-emerald-900/20 p-4 rounded-lg border border-emerald-100 dark:border-emerald-800">
                                    <div class="text-sm text-emerald-800 dark:text-emerald-300 font-medium">Change Given</div>
                                    <div class="text-2xl font-bold text-emerald-600 dark:text-emerald-400 mt-1">
                                        ₱{{ number_format($this->change, 2) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="p-4 border-t border-slate-200 dark:border-slate-700 flex justify-end gap-3 bg-gray-50 dark:bg-slate-800/50">
                <button wire:click="closeCheckoutModal" class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white font-medium">Cancel</button>
                <button wire:click="checkout" 
                        wire:loading.attr="disabled"
                        class="px-8 py-3 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 font-bold disabled:opacity-50 flex items-center gap-2 shadow-lg shadow-emerald-200 dark:shadow-none transition transform active:scale-95">
                    <span wire:loading.remove wire:target="checkout">Confirm Order</span>
                    <span wire:loading wire:target="checkout">Processing...</span>
                    <svg wire:loading wire:target="checkout" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    @endif
    <!-- Receipt Modal -->
    @if($showReceiptModal && $latestOrder)
    <div class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
        <div class="bg-white rounded-3xl shadow-2xl max-w-sm w-full overflow-hidden flex flex-col transform animate-pop-in">
            <!-- Receipt Content for Capture -->
            <div id="pos-receipt-content" class="bg-white p-8">
                <!-- Receipt Header -->
                <div class="pb-4 text-center border-b border-dashed border-gray-100">
                    <h3 class="text-xl font-black text-gray-900 uppercase tracking-tighter leading-none">Jun and Jen’s</h3>
                    <h4 class="text-[10px] font-bold text-gray-700 uppercase tracking-widest mt-1">Game Farm & Feed Store</h4>
                    <p class="text-[9px] text-gray-400 mt-2 italic">Quality Feeds for Your Farm</p>
                    <div class="text-[10px] text-gray-400 mt-2 flex justify-center gap-2 font-mono">
                        <span>{{ $latestOrder->created_at->format('M d, Y') }}</span>
                        <span>•</span>
                        <span>{{ $latestOrder->created_at->format('h:i A') }}</span>
                    </div>
                </div>

                <!-- Receipt Items -->
                <div class="py-4">
                    <div class="flex justify-between text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4">
                        <span>Description</span>
                        <span>Price</span>
                    </div>
                    
                    <div class="space-y-4">
                        @foreach($latestOrder->items as $item)
                        <div class="flex justify-between items-start gap-4">
                            <div class="text-xs font-medium text-gray-700">
                                @php
                                    $name = $item->feed ? $item->feed->feed_name : ($item->gameFowl ? $item->gameFowl->name : 'Unknown');
                                @endphp
                                <span>{{ $name }}</span>
                                <div class="text-[10px] text-gray-400">{{ $item->quantity }} x ₱{{ number_format($item->price, 2) }}</div>
                            </div>
                            <span class="text-xs font-bold text-gray-900">₱{{ number_format($item->quantity * $item->price, 2) }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Totals Section -->
                <div class="py-4 border-t-2 border-dashed border-gray-200 space-y-2 bg-gray-50/50 p-4 rounded-xl">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-bold text-gray-900 uppercase">Total Paid</span>
                        <span class="text-xl font-black text-gray-900 leading-none">₱{{ number_format($latestOrder->total_amount, 2) }}</span>
                    </div>
                    
                    @if($latestOrder->payment_method === 'cash')
                    <div class="flex justify-between text-[10px] text-gray-500">
                        <span class="uppercase">Tendered</span>
                        <span>₱{{ number_format($paidAmount, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-xs font-black text-emerald-600">
                        <span class="uppercase">Change</span>
                        <span>₱{{ number_format($changeAmount, 2) }}</span>
                    </div>
                    @else
                    <div class="flex justify-between text-[10px] text-gray-500">
                        <span class="uppercase">Method</span>
                        <span class="font-bold uppercase tracking-widest">{{ $latestOrder->payment_method }}</span>
                    </div>
                    @endif
                </div>

                <!-- Footer -->
                <div class="py-6 flex flex-col items-center gap-2 border-t border-dashed border-gray-100">
                    <span class="text-[9px] font-mono text-gray-400 uppercase tracking-widest">{{ $latestOrder->order_number }}</span>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.25em] mt-4">Thank You!</p>
                </div>
            </div>

            <!-- Modal Actions -->
            <div class="p-4 bg-gray-100 flex gap-3">
                <button onclick="downloadReceipt('pos-receipt-content', '{{ $latestOrder->order_number }}')" class="flex-1 py-3 rounded-2xl border border-gray-200 bg-white text-gray-700 font-bold text-sm shadow-sm hover:bg-gray-50 transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Download
                </button>
                <button wire:click="$set('showReceiptModal', false)" class="flex-1 py-3 rounded-2xl bg-emerald-600 text-white font-bold text-sm shadow-lg shadow-emerald-200 hover:bg-emerald-700 transition">
                    New Sale
                </button>
            </div>
        </div>
    </div>
    @endif
</div>

@script
<script>
    Livewire.on('notify', (data) => {
        // data might be an object or array depending on how it's dispatched.
        // In PHP: $this->dispatch('notify', message: 'msg', type: 'error');
        // Livewire 3: data is an object { message: 'msg', type: 'error' } (if named arguments)
        // or array if positional?
        // Let's assume named arguments result in object.
        // Actually, $this->dispatch('notify', message: '...') results in event.detail having { message: ... } if caught in Alpine directly.
        // But via Livewire.on, it receives the params.
        
        // If dispatched as $this->dispatch('notify', message: 'foo'), JS receives object.
        window.dispatchEvent(new CustomEvent('toast', { detail: data }));
    });
</script>
@endscript
