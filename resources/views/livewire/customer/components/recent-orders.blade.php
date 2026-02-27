<div class="bg-white dark:bg-slate-900 rounded-3xl overflow-hidden shadow-lg border border-slate-100 dark:border-slate-800">
    <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center bg-gray-50/50 dark:bg-slate-800/30">
        <div>
            <h3 class="text-lg font-bold text-slate-900 dark:text-slate-100 flex items-center gap-2">
                <flux:icon name="clock" class="w-5 h-5 text-green-500" />
                Recent Orders
            </h3>
            <p class="text-sm text-slate-500 mt-1">Track your latest purchases</p>
        </div>
        <a href="{{ route('customer.orders.index') }}" class="text-sm font-medium text-green-600 hover:text-green-700 flex items-center gap-1 transition-colors">
            View All
            <flux:icon name="arrow-right" class="w-4 h-4" />
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="text-slate-500 border-b border-slate-100 dark:border-slate-800">
                    <th class="px-6 py-4 font-medium">Order ID</th>
                    <th class="px-6 py-4 font-medium">Date</th>
                    <th class="px-6 py-4 font-medium">Items</th>
                    <th class="px-6 py-4 font-medium">Total</th>
                    <th class="px-6 py-4 font-medium">Status</th>
                    <th class="px-6 py-4 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($recentOrders as $order)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors group">
                        <td class="px-6 py-4 font-medium text-slate-900 dark:text-slate-100">
                            #{{ $order->id }}
                        </td>
                        <td class="px-6 py-4 text-slate-500">
                            {{ $order->created_at->format('M d, Y') }}
                            <div class="text-xs text-slate-400">{{ $order->created_at->format('h:i A') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex -space-x-2 overflow-hidden">
                                @foreach($order->items->take(3) as $item)
                                    @php
                                        $itemName = $item->feed ? $item->feed->feed_name : ($item->gameFowl ? $item->gameFowl->name : 'Unknown Item');
                                        $itemImage = $item->feed ? $item->feed->image : ($item->gameFowl ? $item->gameFowl->image : null);
                                    @endphp
                                    <div class="inline-block h-8 w-8 rounded-full ring-2 ring-white dark:ring-slate-900 bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500 shadow-sm overflow-hidden" title="{{ $itemName }}">
                                        @if($itemImage)
                                            <img src="{{ asset('storage/' . $itemImage) }}" alt="{{ $itemName }}" class="w-full h-full object-cover">
                                        @else
                                            {{ substr($itemName, 0, 1) }}
                                        @endif
                                    </div>
                                @endforeach
                                @if($order->items->count() > 3)
                                    <div class="inline-block h-8 w-8 rounded-full ring-2 ring-white dark:ring-slate-900 bg-gray-50 flex items-center justify-center text-xs font-bold text-gray-500 shadow-sm">
                                        +{{ $order->items->count() - 3 }}
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-900 dark:text-slate-100">
                            ₱{{ number_format($order->total_amount, 2) }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium border
                                @if($order->status === 'completed') bg-green-50 text-green-700 border-green-100 dark:bg-green-500/10 dark:text-green-400 dark:border-green-500/20
                                @elseif($order->status === 'pending') bg-yellow-50 text-yellow-700 border-yellow-100 dark:bg-yellow-500/10 dark:text-yellow-400 dark:border-yellow-500/20
                                @elseif($order->status === 'processing') bg-blue-50 text-blue-700 border-blue-100 dark:bg-blue-500/10 dark:text-blue-400 dark:border-blue-500/20
                                @elseif($order->status === 'cancelled') bg-red-50 text-red-700 border-red-100 dark:bg-red-500/10 dark:text-red-400 dark:border-red-500/20
                                @endif">
                                <span class="w-1.5 h-1.5 rounded-full
                                    @if($order->status === 'completed') bg-green-500
                                    @elseif($order->status === 'pending') bg-yellow-500
                                    @elseif($order->status === 'processing') bg-blue-500
                                    @elseif($order->status === 'cancelled') bg-red-500
                                    @endif"></span>
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('customer.orders.show', $order) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white border border-slate-200 text-slate-400 hover:text-green-600 hover:border-green-200 hover:bg-green-50 transition-all shadow-sm">
                                <flux:icon name="eye" class="w-4 h-4" />
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center">
                                <div class="bg-slate-100 rounded-full p-4 mb-3">
                                    <flux:icon name="shopping-cart" class="w-6 h-6 text-slate-400" />
                                </div>
                                <p class="font-medium">No orders yet</p>
                                <p class="text-sm mt-1">Start shopping to see your orders here.</p>
                                <a href="{{ route('customer.products.index') }}" class="mt-4 px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition-colors">
                                    Browse Products
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
