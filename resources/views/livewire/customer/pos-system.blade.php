<div class="flex h-[calc(100vh-6rem)] gap-6">
    <!-- Left Side: Order Menu -->
    <div class="flex-1 flex flex-col bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 overflow-hidden">
        <!-- Header -->
        <div class="p-4 border-b border-zinc-200 dark:border-zinc-700 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Order Menu</h2>
            <div class="relative w-64">
                <input type="text" wire:model.live="search" placeholder="Search..." class="w-full pl-10 pr-4 py-2 rounded-lg border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 dark:text-white focus:ring-2 focus:ring-indigo-500">
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>

        <!-- Categories -->
        <div class="p-4 border-b border-zinc-200 dark:border-zinc-700 flex gap-2 overflow-x-auto">
            <button wire:click="$set('feedType', '')" 
               class="px-4 py-2 rounded-full font-medium whitespace-nowrap {{ $feedType === '' ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-zinc-800 dark:text-gray-300 dark:hover:bg-zinc-700' }}">
                All Items
            </button>
            @foreach($categories as $category)
                <button wire:click="$set('feedType', '{{ $category }}')" 
                   class="px-4 py-2 rounded-full font-medium whitespace-nowrap {{ $feedType === $category ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-zinc-800 dark:text-gray-300 dark:hover:bg-zinc-700' }}">
                    {{ $category }}
                </button>
            @endforeach
        </div>

        <!-- Grid -->
        <div class="flex-1 overflow-y-auto p-4 relative">
            <!-- Loading Overlay -->
            <div wire:loading.flex wire:target="search, feedType" class="absolute inset-0 bg-white/50 dark:bg-zinc-900/50 flex items-center justify-center z-10">
                <svg class="animate-spin h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($feeds as $feed)
                    <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 shadow-sm hover:shadow-md transition cursor-pointer relative group" wire:click="addToCart({{ $feed->id }})">
                        <div class="aspect-square w-full overflow-hidden rounded-t-xl bg-gray-100 dark:bg-zinc-700 relative">
                            @if($feed->image)
                                <img src="{{ Storage::url($feed->image) }}" alt="{{ $feed->feed_name }}" class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            <div class="absolute bottom-2 right-2 bg-white dark:bg-zinc-900 px-2 py-1 rounded-lg text-xs font-bold shadow-sm">
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
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $feed->quantity }} in stock</p>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-4">
                {{ $feeds->links() }}
            </div>
        </div>
    </div>

    <!-- Right Side: Order Details -->
    <div class="w-96 flex flex-col bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-700 h-full">
        <div class="p-4 border-b border-zinc-200 dark:border-zinc-700 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">Order Details</h2>
            <span class="px-2 py-1 bg-gray-100 dark:bg-zinc-800 rounded text-xs font-medium text-gray-600 dark:text-gray-400">Table</span>
        </div>

        <div class="p-4 space-y-4 border-b border-zinc-200 dark:border-zinc-700">
            <div>
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Customer Name</label>
                <div class="w-full p-2 bg-gray-50 dark:bg-zinc-800 rounded border border-zinc-200 dark:border-zinc-700 text-sm">
                    {{ auth()->user()->name }}
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Note</label>
                <input type="text" wire:model="note" class="w-full p-2 bg-white dark:bg-zinc-800 rounded border border-zinc-200 dark:border-zinc-700 text-sm focus:ring-2 focus:ring-indigo-500" placeholder="Add a note...">
            </div>
        </div>

        <!-- Cart Items -->
        <div class="flex-1 overflow-y-auto p-4 space-y-3 relative">
             <div wire:loading.flex wire:target="refreshCart, addToCart, updateQuantity, removeFromCart, checkout" class="absolute inset-0 bg-white/50 dark:bg-zinc-900/50 flex items-center justify-center z-10">
                <svg class="animate-spin h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
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
                    <div class="flex gap-3 bg-gray-50 dark:bg-zinc-800/50 p-2 rounded-lg relative group">
                        <div class="w-12 h-12 rounded bg-gray-200 dark:bg-zinc-700 overflow-hidden flex-shrink-0">
                            @if($item->feed->image)
                                <img src="{{ Storage::url($item->feed->image) }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $item->feed->feed_name }}</h4>
                            <div class="text-xs text-gray-500 dark:text-gray-400">₱{{ number_format($item->feed->price, 2) }}</div>
                            <div class="flex items-center gap-2 mt-2">
                                <button wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})" class="w-6 h-6 flex items-center justify-center rounded bg-white dark:bg-zinc-700 border border-zinc-200 dark:border-zinc-600 hover:bg-gray-50 dark:hover:bg-zinc-600">-</button>
                                <span class="text-sm font-medium w-4 text-center">{{ $item->quantity }}</span>
                                <button wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})" class="w-6 h-6 flex items-center justify-center rounded bg-indigo-600 text-white hover:bg-indigo-700">+</button>
                            </div>
                        </div>
                        <div class="flex flex-col items-end justify-between">
                            <button wire:click="removeFromCart({{ $item->id }})" class="text-gray-400 hover:text-red-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                            <div class="text-sm font-bold text-gray-900 dark:text-white">₱{{ number_format($item->feed->price * $item->quantity, 2) }}</div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Footer -->
        <div class="p-4 bg-gray-50 dark:bg-zinc-800/50 border-t border-zinc-200 dark:border-zinc-700 space-y-3">
            <div class="flex justify-between text-sm">
                <span class="text-gray-500 dark:text-gray-400">Sub Total</span>
                <span class="font-medium text-gray-900 dark:text-white">₱{{ number_format($this->subtotal, 2) }}</span>
            </div>
            <div class="border-t border-dashed border-zinc-300 dark:border-zinc-600 my-2"></div>
            <div class="flex justify-between text-lg font-bold">
                <span class="text-gray-900 dark:text-white">Total</span>
                <span class="text-indigo-600 dark:text-indigo-400">₱{{ number_format($this->subtotal, 2) }}</span>
            </div>
            
            <button wire:click="openCheckoutModal" 
                    wire:loading.attr="disabled"
                    wire:target="openCheckoutModal"
                    class="w-full py-3 rounded-xl bg-indigo-600 text-white font-bold shadow-lg shadow-indigo-200 dark:shadow-none hover:bg-indigo-700 transition active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed">
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
        <div class="bg-white dark:bg-zinc-800 rounded-2xl shadow-xl max-w-2xl w-full overflow-hidden max-h-[90vh] flex flex-col">
            <!-- Header -->
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700 flex justify-between items-center bg-gray-50 dark:bg-zinc-800/50">
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
                        <div class="aspect-square rounded-xl overflow-hidden bg-gray-100 dark:bg-zinc-700 border border-zinc-200 dark:border-zinc-600">
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
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">
                                {{ $selectedFeed->feed_type }}
                            </span>
                        </div>
                        
                        <div>
                            <div class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">₱{{ number_format($selectedFeed->price, 2) }}</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $selectedFeed->quantity }} units available</div>
                        </div>

                        <div class="space-y-2">
                            <div class="flex justify-between border-b border-zinc-100 dark:border-zinc-700 py-2">
                                <span class="text-gray-500 dark:text-gray-400">Brand</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $selectedFeed->brand }}</span>
                            </div>
                            <div class="flex justify-between border-b border-zinc-100 dark:border-zinc-700 py-2">
                                <span class="text-gray-500 dark:text-gray-400">Batch Number</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $selectedFeed->batch_number }}</span>
                            </div>
                            <div class="flex justify-between border-b border-zinc-100 dark:border-zinc-700 py-2">
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
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-700 bg-gray-50 dark:bg-zinc-800/50 flex justify-end gap-3">
                <button wire:click="closeFeedModal" class="px-4 py-2 rounded-lg border border-zinc-300 dark:border-zinc-600 text-gray-700 dark:text-gray-300 font-medium hover:bg-gray-100 dark:hover:bg-zinc-700 transition">
                    Close
                </button>
                <button wire:click="addToCart({{ $selectedFeed->id }})" class="px-6 py-2 rounded-lg bg-indigo-600 text-white font-bold hover:bg-indigo-700 shadow-lg shadow-indigo-200 dark:shadow-none transition">
                    Add to Cart
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Checkout Modal -->
    @if($showCheckoutModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm" wire:click.self="closeCheckoutModal">
        <div class="bg-white dark:bg-zinc-800 rounded-2xl shadow-xl max-w-lg w-full overflow-hidden flex flex-col max-h-[90vh]">
            <!-- Header -->
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700 flex justify-between items-center bg-gray-50 dark:bg-zinc-800/50">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white">Checkout</h3>
                <button wire:click="closeCheckoutModal" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <!-- Body -->
            <div class="p-6 space-y-4 overflow-y-auto">
                <!-- Order Summary -->
                <div class="bg-gray-50 dark:bg-zinc-700/50 p-4 rounded-lg space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500 dark:text-gray-400">Total Items</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $cart->items->sum('quantity') }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold">
                        <span class="text-gray-900 dark:text-white">Total Amount</span>
                        <span class="text-indigo-600 dark:text-indigo-400">₱{{ number_format($this->subtotal, 2) }}</span>
                    </div>
                </div>

                <!-- Payment Method -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Payment Method</label>
                    <select wire:model.live="paymentMethod" class="w-full rounded-lg border border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 p-2.5">
                        <option value="cash">Cash</option>
                        <option value="gcash">GCash</option>
                        <option value="bank_transfer">Bank Transfer</option>
                    </select>
                </div>

                <!-- Proof of Payment (if not cash) -->
                @if($paymentMethod !== 'cash')
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Proof of Payment</label>
                    <input type="file" wire:model="proofOfPayment" class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900 dark:file:text-indigo-300 cursor-pointer">
                    @error('proofOfPayment') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                    
                    <div wire:loading wire:target="proofOfPayment" class="text-xs text-indigo-500 mt-1 flex items-center gap-1">
                        <svg class="animate-spin h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Uploading...
                    </div>
                    @if ($proofOfPayment) 
                        <div class="mt-2">
                            <p class="text-xs text-green-600 dark:text-green-400">Image selected: {{ $proofOfPayment->getClientOriginalName() }}</p>
                        </div>
                    @endif
                </div>
                @endif
            </div>

            <!-- Footer -->
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-700 flex justify-end gap-3 bg-gray-50 dark:bg-zinc-800/50">
                <button wire:click="closeCheckoutModal" class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white font-medium">Cancel</button>
                <button wire:click="checkout" 
                        wire:loading.attr="disabled"
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 font-medium disabled:opacity-50 flex items-center gap-2 shadow-lg shadow-indigo-200 dark:shadow-none transition">
                    <span wire:loading.remove wire:target="checkout">Confirm Payment</span>
                    <span wire:loading wire:target="checkout">Processing...</span>
                    <svg wire:loading wire:target="checkout" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
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