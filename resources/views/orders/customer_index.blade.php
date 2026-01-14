<x-layouts.app>
    <div class="p-6">
        <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">Order History</h2>
        
        <div class="overflow-x-auto bg-white dark:bg-zinc-800 rounded-lg shadow">
            <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                <thead class="bg-gray-50 dark:bg-zinc-700 text-xs uppercase text-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3">Order Number</th>
                        <th class="px-6 py-3">Date</th>
                        <th class="px-6 py-3">Total Amount</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Payment Method</th>
                        <th class="px-6 py-3 text-right">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr class="border-b bg-white dark:border-zinc-700 dark:bg-zinc-800">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                {{ $order->order_number }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $order->created_at->format('M d, Y H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                ₱{{ number_format($order->total_amount, 2) }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $order->status === 'paid' ? 'bg-green-100 text-green-800' : 
                                       ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                {{ ucfirst($order->payment_method) }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('customer.orders.show', $order->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center">
                                No orders found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>
