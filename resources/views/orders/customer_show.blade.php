<x-layouts.app>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <nav class="flex items-center gap-2 text-sm text-zinc-500 mb-2">
                    <a href="{{ route('customer.orders.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Orders</a>
                    <svg class="w-4 h-4 text-zinc-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <span class="text-zinc-900 dark:text-white font-medium">Order #{{ $order->order_number }}</span>
                </nav>
                <h1 class="text-3xl font-bold text-zinc-900 dark:text-white tracking-tight">Order Details</h1>
            </div>
            <div class="flex items-center gap-3">
                 <span class="px-4 py-1.5 rounded-full text-sm font-semibold shadow-sm border
                    {{ $order->status === 'paid' ? 'bg-emerald-50 border-emerald-100 text-emerald-700 dark:bg-emerald-500/10 dark:border-emerald-500/20 dark:text-emerald-400' : 
                       ($order->status === 'pending' ? 'bg-amber-50 border-amber-100 text-amber-700 dark:bg-amber-500/10 dark:border-amber-500/20 dark:text-amber-400' : 'bg-zinc-50 border-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:border-zinc-700 dark:text-zinc-300') }}">
                    {{ ucfirst($order->status) }}
                 </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Order Items -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-zinc-200 dark:border-zinc-800 flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-zinc-900 dark:text-white">Items Purchased</h2>
                        <span class="text-sm text-zinc-500">{{ $order->items->count() }} items</span>
                    </div>
                    <div class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @foreach($order->items as $item)
                            <div class="p-6 flex gap-4 sm:gap-6 hover:bg-zinc-50/50 dark:hover:bg-zinc-800/50 transition-colors">
                                <!-- Image -->
                                <div class="shrink-0">
                                     @if($item->feed->image)
                                        <img class="w-20 h-20 sm:w-24 sm:h-24 rounded-xl object-cover border border-zinc-200 dark:border-zinc-700 bg-zinc-100 dark:bg-zinc-800" src="{{ asset('storage/' . $item->feed->image) }}" alt="{{ $item->feed->feed_name }}">
                                    @else
                                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-xl border border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 flex items-center justify-center text-zinc-400">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                </div>
                                <!-- Content -->
                                <div class="flex-1 flex flex-col sm:flex-row sm:justify-between">
                                    <div class="flex-1 pr-4">
                                        <h3 class="text-base font-bold text-zinc-900 dark:text-white mb-1">{{ $item->feed->feed_name }}</h3>
                                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-2">{{ $item->feed->brand ?? 'Generic Brand' }}</p>
                                        <div class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-zinc-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-200">
                                            Qty: {{ $item->quantity }}
                                        </div>
                                    </div>
                                    <div class="mt-4 sm:mt-0 text-right">
                                        <p class="text-lg font-bold text-zinc-900 dark:text-white">₱{{ number_format($item->price * $item->quantity, 2) }}</p>
                                        <p class="text-sm text-zinc-500">₱{{ number_format($item->price, 2) }} / unit</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Column: Summary & Info -->
            <div class="space-y-6">
                <!-- Order Summary -->
                <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-6">Order Summary</h2>
                    <div class="space-y-4">
                        <div class="flex justify-between text-sm">
                            <span class="text-zinc-500 dark:text-zinc-400">Subtotal</span>
                            <span class="text-zinc-900 dark:text-zinc-200 font-medium">₱{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-zinc-500 dark:text-zinc-400">Tax</span>
                            <span class="text-zinc-900 dark:text-zinc-200 font-medium">₱0.00</span>
                        </div>
                        <div class="pt-4 border-t border-zinc-200 dark:border-zinc-800 flex justify-between items-end">
                            <span class="text-base font-bold text-zinc-900 dark:text-white">Total</span>
                            <span class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">₱{{ number_format($order->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Information Card -->
                <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-white mb-6">Details</h2>
                    <div class="space-y-6">
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 p-2 rounded-lg bg-zinc-50 dark:bg-zinc-800 text-zinc-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-zinc-500 uppercase tracking-wider mb-0.5">Date Placed</p>
                                <p class="text-sm font-medium text-zinc-900 dark:text-zinc-200">{{ $order->created_at->format('M d, Y') }}</p>
                                <p class="text-xs text-zinc-500">{{ $order->created_at->format('h:i A') }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 p-2 rounded-lg bg-zinc-50 dark:bg-zinc-800 text-zinc-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-zinc-500 uppercase tracking-wider mb-0.5">Payment Method</p>
                                <p class="text-sm font-medium text-zinc-900 dark:text-zinc-200">{{ ucfirst($order->payment_method) }}</p>
                            </div>
                        </div>

                        @if($order->note)
                        <div class="flex items-start gap-3">
                            <div class="mt-0.5 p-2 rounded-lg bg-zinc-50 dark:bg-zinc-800 text-zinc-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>
                            <div class="w-full">
                                <p class="text-xs font-medium text-zinc-500 uppercase tracking-wider mb-1.5">Note</p>
                                <div class="text-sm text-zinc-600 dark:text-zinc-300 bg-zinc-50 dark:bg-zinc-800/50 p-3 rounded-lg border border-zinc-100 dark:border-zinc-700/50 italic">
                                    "{{ $order->note }}"
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
