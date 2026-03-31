<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white uppercase tracking-tight">Purchase History</h2>
        <div class="text-xs text-gray-500 uppercase tracking-widest font-semibold bg-gray-100 dark:bg-slate-800 px-3 py-1 rounded-full">
            History
        </div>
    </div>

    <!-- Logs Table -->
    <div class="overflow-hidden bg-white dark:bg-slate-900 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-800">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50/50 dark:bg-slate-800/50 text-[10px] uppercase tracking-widest font-black text-gray-400">
                <tr>
                    <th class="px-6 py-4">Transaction #</th>
                    <th class="px-6 py-4">Date & Time</th>
                    <th class="px-6 py-4">Method</th>
                    <th class="px-6 py-4">Total</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($orders as $order)
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition-colors group">
                    <td class="px-6 py-4 font-mono text-xs font-bold text-slate-900 dark:text-slate-100 uppercase">
                        {{ $order->order_number }}
                    </td>
                    <td class="px-6 py-4 text-slate-500 dark:text-slate-400">
                        <div class="font-medium text-slate-700 dark:text-slate-200">{{ $order->created_at->format('M d, Y') }}</div>
                        <div class="text-[10px] uppercase tracking-tighter opacity-60">{{ $order->created_at->format('h:i A') }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider {{ $order->payment_method === 'cash' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30' : 'bg-blue-100 text-blue-700 dark:bg-blue-900/30' }}">
                            {{ $order->payment_method }}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-black text-slate-900 dark:text-slate-100">
                        ₱{{ number_format($order->total_amount, 2) }}
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button wire:click="showReceipt({{ $order->id }})" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs hover:bg-emerald-600 hover:text-white transition-all transform active:scale-95 group">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            Receipt
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                        No transactions found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $orders->links() }}
    </div>

    <!-- Receipt Modal Overlay -->
    @if($selectedOrder)
    <div class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm" wire:click.self="closeReceipt">
        <div class="bg-white rounded-3xl shadow-2xl max-w-sm w-full overflow-hidden flex flex-col transform animate-pop-in">
            <!-- Receipt Content for Capture -->
            <div id="log-receipt-content" class="bg-white p-8">
                <!-- Receipt Header -->
                <div class="pb-4 text-center border-b border-dashed border-gray-100">
                    <h3 class="text-2xl font-bold text-gray-900 uppercase tracking-tight">Feed Store</h3>
                    <p class="text-xs text-gray-500 mt-1 italic">Quality Feeds for Your Farm</p>
                    <div class="text-[10px] text-gray-400 mt-2 flex justify-center gap-2 font-mono">
                        <span>{{ $selectedOrder->created_at->format('M d, Y') }}</span>
                        <span>•</span>
                        <span>{{ $selectedOrder->created_at->format('h:i A') }}</span>
                    </div>
                </div>

                <!-- Receipt Items -->
                <div class="py-4">
                    <div class="flex justify-between text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4">
                        <span>Description</span>
                        <span>Price</span>
                    </div>
                    
                    <div class="space-y-4">
                        @foreach($selectedOrder->items as $item)
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
                    <div class="flex justify-between items-center text-sm">
                        <span class="font-bold text-gray-900 uppercase">Total Paid</span>
                        <span class="text-xl font-black text-gray-900 leading-none">₱{{ number_format($selectedOrder->total_amount, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-[10px] text-gray-400">
                        <span class="uppercase">Method</span>
                        <span class="font-bold uppercase tracking-widest">{{ $selectedOrder->payment_method }}</span>
                    </div>
                </div>

                <!-- Footer -->
                <div class="py-6 flex flex-col items-center gap-2 border-t border-dashed border-gray-100">
                    <span class="text-[9px] font-mono text-gray-400 uppercase tracking-widest">{{ $selectedOrder->order_number }}</span>
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.25em] mt-4">Thank You!</p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="p-4 bg-gray-100 flex gap-3">
                <button onclick="downloadReceipt('log-receipt-content', '{{ $selectedOrder->order_number }}')" class="flex-1 py-3 rounded-2xl border border-gray-200 bg-white text-gray-700 font-bold text-sm shadow-sm hover:bg-gray-50 transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Download
                </button>
                <button wire:click="closeReceipt" class="flex-1 py-3 rounded-2xl bg-slate-900 text-white font-bold text-sm hover:bg-black transition">
                    Close
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
