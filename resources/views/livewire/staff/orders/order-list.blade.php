<div class="p-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Order Management</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Manage and track customer orders.</p>
        </div>
        
        <div class="flex gap-3 w-full md:w-auto">
            <div class="relative flex-1 md:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <flux:icon icon="magnifying-glass" class="h-5 w-5 text-slate-400" />
                </div>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search orders..." class="pl-10 block w-full rounded-lg border-slate-200 bg-white text-sm focus:border-emerald-500 focus:ring-emerald-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white dark:placeholder-slate-400">
            </div>
            
            <div class="w-40">
                <select wire:model.live="statusFilter" class="block w-full rounded-lg border-slate-200 bg-white text-sm focus:border-emerald-500 focus:ring-emerald-500 dark:border-slate-700 dark:bg-slate-800 dark:text-white">
                    <option value="">All Statuses</option>
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                <thead class="bg-slate-50 dark:bg-slate-800/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Order Info</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 dark:divide-slate-700 bg-white dark:bg-slate-900">
                    @forelse ($orders as $order)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col">
                                    <span class="text-sm font-semibold text-slate-900 dark:text-white">#{{ $order->order_number }}</span>
                                    <span class="text-xs text-slate-500 dark:text-slate-400">{{ $order->created_at->format('M d, Y • h:i A') }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center text-emerald-700 dark:text-emerald-300 font-bold text-xs mr-3">
                                        {{ substr($order->user->name, 0, 1) }}
                                    </div>
                                    <div class="text-sm font-medium text-slate-900 dark:text-white">{{ $order->user->name }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-900 dark:text-white">
                                ₱{{ number_format($order->total_amount, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300',
                                        'processing' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                        'completed' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300',
                                        'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                    ];
                                @endphp
                                <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-medium rounded-full {{ $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="viewOrder({{ $order->id }})" class="text-emerald-600 hover:text-emerald-900 dark:text-emerald-400 dark:hover:text-emerald-300 font-medium hover:underline">
                                    Manage
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                                <flux:icon icon="shopping-bag" class="mx-auto h-12 w-12 text-slate-300 dark:text-slate-600 mb-3" />
                                <p class="text-lg font-medium text-slate-900 dark:text-white">No orders found</p>
                                <p class="text-sm">Try adjusting your search or filters.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $orders->links() }}
    </div>

    <!-- Centered Order Details Modal -->
    @if($showOrderModal && $selectedOrder)
        <div class="fixed inset-0 z-[60] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-slate-900/75 transition-opacity" wire:click="closeOrderModal" aria-hidden="true"></div>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="relative inline-block align-bottom bg-white dark:bg-slate-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full border border-slate-200 dark:border-slate-800">
                    <!-- Header -->
                    <div class="px-4 py-5 sm:px-6 border-b border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/50 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-slate-900 dark:text-white" id="modal-title">
                                Order #{{ $selectedOrder->order_number }}
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm text-slate-500 dark:text-slate-400">
                                Placed on {{ $selectedOrder->created_at->format('M d, Y \a\t h:i A') }}
                            </p>
                        </div>
                        <button wire:click="closeOrderModal" type="button" class="rounded-md text-slate-400 hover:text-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                            <span class="sr-only">Close</span>
                            <flux:icon icon="x-mark" class="h-6 w-6" />
                        </button>
                    </div>

                    <!-- Content -->
                    <div class="px-4 py-5 sm:p-6 max-h-[80vh] overflow-y-auto">
                        <!-- Status Section -->
                        <div class="mb-8 bg-slate-50 dark:bg-slate-800/50 rounded-lg p-4 border border-slate-200 dark:border-slate-700">
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Order Status</label>
                            <div class="flex gap-3">
                                <select wire:model="newStatus" class="block w-full rounded-md border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 text-slate-900 dark:text-white shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                                    <option value="pending">Pending</option>
                                    <option value="processing">Processing</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                                <button wire:click="updateStatus" class="inline-flex justify-center rounded-md border border-transparent bg-emerald-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                                    Update
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-y-8 gap-x-6 sm:grid-cols-2">
                            <!-- Customer Details -->
                            <div>
                                <h3 class="text-sm font-medium text-slate-900 dark:text-white mb-3 flex items-center gap-2">
                                    <flux:icon icon="user" class="h-4 w-4 text-slate-400" /> Customer
                                </h3>
                                <div class="bg-slate-50 dark:bg-slate-800/30 rounded-lg p-3 text-sm">
                                    <p class="font-medium text-slate-900 dark:text-white">{{ $selectedOrder->user->name }}</p>
                                    <p class="text-slate-500 dark:text-slate-400">{{ $selectedOrder->user->email }}</p>
                                    <p class="text-slate-500 dark:text-slate-400">{{ $selectedOrder->user->phone_number }}</p>
                                </div>
                            </div>

                            <!-- Payment Info -->
                            <div>
                                <h3 class="text-sm font-medium text-slate-900 dark:text-white mb-3 flex items-center gap-2">
                                    <flux:icon icon="credit-card" class="h-4 w-4 text-slate-400" /> Payment
                                </h3>
                                <div class="bg-slate-50 dark:bg-slate-800/30 rounded-lg p-3 text-sm">
                                    <p class="text-slate-900 dark:text-white capitalize">{{ $selectedOrder->payment_method }}</p>
                                    <p class="text-slate-500 dark:text-slate-400 mt-1">
                                        Status: <span class="capitalize">{{ $selectedOrder->payment_status ?? 'Pending' }}</span>
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Shipping Address -->
                            <div class="sm:col-span-2">
                                <h3 class="text-sm font-medium text-slate-900 dark:text-white mb-3 flex items-center gap-2">
                                    <flux:icon icon="truck" class="h-4 w-4 text-slate-400" /> Shipping Address
                                </h3>
                                <div class="bg-slate-50 dark:bg-slate-800/30 rounded-lg p-3 text-sm text-slate-600 dark:text-slate-300 whitespace-pre-line leading-relaxed">
                                    {{ $selectedOrder->shipping_address }}
                                </div>
                            </div>

                            @if($selectedOrder->note)
                                <div class="sm:col-span-2">
                                    <h3 class="text-sm font-medium text-slate-900 dark:text-white mb-3 flex items-center gap-2">
                                        <flux:icon icon="document-text" class="h-4 w-4 text-slate-400" /> Note
                                    </h3>
                                    <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-lg p-3 text-sm text-yellow-800 dark:text-yellow-200 border border-yellow-100 dark:border-yellow-900/30">
                                        {{ $selectedOrder->note }}
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Order Items -->
                        <div class="mt-8">
                            <h3 class="text-sm font-medium text-slate-900 dark:text-white mb-4">Order Items</h3>
                            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">
                                <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                                    <thead class="bg-slate-50 dark:bg-slate-800">
                                        <tr>
                                            <th class="py-3 pl-4 pr-3 text-left text-xs font-medium uppercase tracking-wide text-slate-500 dark:text-slate-400">Product</th>
                                            <th class="px-3 py-3 text-right text-xs font-medium uppercase tracking-wide text-slate-500 dark:text-slate-400">Qty</th>
                                            <th class="px-3 py-3 text-right text-xs font-medium uppercase tracking-wide text-slate-500 dark:text-slate-400">Price</th>
                                            <th class="px-3 py-3 text-right text-xs font-medium uppercase tracking-wide text-slate-500 dark:text-slate-400">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700 bg-white dark:bg-slate-900">
                                        @foreach($selectedOrder->items as $item)
                                            <tr>
                                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-slate-900 dark:text-white">
                                                    {{ $item->feed->name }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-right text-sm text-slate-500 dark:text-slate-400">
                                                    {{ $item->quantity }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-right text-sm text-slate-500 dark:text-slate-400">
                                                    ₱{{ number_format($item->price, 2) }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-right text-sm text-slate-900 dark:text-white font-medium">
                                                    ₱{{ number_format($item->price * $item->quantity, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr class="bg-slate-50 dark:bg-slate-800/50">
                                            <td colspan="3" class="py-4 pl-4 pr-3 text-right text-sm font-bold text-slate-900 dark:text-white">Total Amount</td>
                                            <td class="px-3 py-4 text-right text-sm font-bold text-emerald-600 dark:text-emerald-400">
                                                ₱{{ number_format($selectedOrder->total_amount, 2) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @if($selectedOrder->proof_of_payment)
                            <div class="mt-8">
                                <h3 class="text-sm font-medium text-slate-900 dark:text-white mb-4">Proof of Payment</h3>
                                <div class="rounded-lg border border-slate-200 dark:border-slate-700 overflow-hidden">
                                    <img src="{{ Storage::url($selectedOrder->proof_of_payment) }}" alt="Proof of Payment" class="w-full h-auto object-cover">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
