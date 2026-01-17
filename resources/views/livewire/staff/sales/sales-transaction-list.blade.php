<div class="p-6">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-zinc-900 dark:text-white">Sales Transactions</h2>
        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Monitor and manage sales transactions.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-zinc-900 rounded-xl p-6 border border-zinc-200 dark:border-zinc-800 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg">
                    <flux:icon icon="currency-dollar" class="w-6 h-6 text-indigo-600 dark:text-indigo-400" />
                </div>
                <div>
                    <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Sales</p>
                    <p class="text-2xl font-bold text-zinc-900 dark:text-white">₱{{ number_format($stats['total_sales'], 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-900 rounded-xl p-6 border border-zinc-200 dark:border-zinc-800 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
                    <flux:icon icon="shopping-bag" class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                </div>
                <div>
                    <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Transactions</p>
                    <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ number_format($stats['total_orders']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-900 rounded-xl p-6 border border-zinc-200 dark:border-zinc-800 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-amber-50 dark:bg-amber-900/30 rounded-lg">
                    <flux:icon icon="clock" class="w-6 h-6 text-amber-600 dark:text-amber-400" />
                </div>
                <div>
                    <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Pending</p>
                    <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ number_format($stats['pending_orders']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-900 rounded-xl p-6 border border-zinc-200 dark:border-zinc-800 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-emerald-50 dark:bg-emerald-900/30 rounded-lg">
                    <flux:icon icon="check-circle" class="w-6 h-6 text-emerald-600 dark:text-emerald-400" />
                </div>
                <div>
                    <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Completed</p>
                    <p class="text-2xl font-bold text-zinc-900 dark:text-white">{{ number_format($stats['completed_orders']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="flex flex-col md:flex-row gap-4 mb-6">
        <div class="flex-1">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <flux:icon icon="magnifying-glass" class="h-5 w-5 text-zinc-400" />
                </div>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search transaction number or customer..." class="pl-10 block w-full rounded-lg border-zinc-200 bg-white text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white dark:placeholder-zinc-400">
            </div>
        </div>
        <div class="w-full md:w-40">
            <select wire:model.live="statusFilter" class="block w-full rounded-lg border-zinc-200 bg-white text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                <option value="">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>
        <div class="w-full md:w-40">
            <select wire:model.live="paymentStatusFilter" class="block w-full rounded-lg border-zinc-200 bg-white text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
                <option value="">Payment Status</option>
                <option value="pending">Pending</option>
                <option value="paid">Paid</option>
                <option value="failed">Failed</option>
            </select>
        </div>
        <div class="w-full md:w-40">
            <input wire:model.live="dateFrom" type="date" class="block w-full rounded-lg border-zinc-200 bg-white text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
        </div>
        <div class="w-full md:w-40">
            <input wire:model.live="dateTo" type="date" class="block w-full rounded-lg border-zinc-200 bg-white text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:text-white">
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Transaction ID</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Date</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Payment</th>
                        <th class="px-6 py-4 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700 bg-white dark:bg-zinc-900">
                    @forelse ($transactions as $transaction)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold text-zinc-900 dark:text-white">#{{ $transaction->order_number }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-700 dark:text-indigo-300 font-bold text-xs mr-3">
                                        {{ substr($transaction->user->name ?? '?', 0, 1) }}
                                    </div>
                                    <div class="text-sm font-medium text-zinc-900 dark:text-white">{{ $transaction->user->name ?? 'Guest' }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-zinc-500 dark:text-zinc-400">
                                {{ $transaction->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-zinc-900 dark:text-white">
                                ₱{{ number_format($transaction->total_amount, 2) }}
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
                                <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-medium rounded-full {{ $statusClasses[$transaction->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $paymentClasses = [
                                        'paid' => 'text-emerald-600 dark:text-emerald-400',
                                        'pending' => 'text-amber-600 dark:text-amber-400',
                                        'failed' => 'text-red-600 dark:text-red-400',
                                    ];
                                @endphp
                                <span class="text-xs font-medium {{ $paymentClasses[$transaction->payment_status] ?? 'text-gray-500' }}">
                                    {{ ucfirst($transaction->payment_status ?? 'Pending') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="viewTransaction({{ $transaction->id }})" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium hover:underline">
                                    Manage
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-zinc-500 dark:text-zinc-400">
                                <flux:icon icon="document-text" class="mx-auto h-12 w-12 text-zinc-300 dark:text-zinc-600 mb-3" />
                                <p class="text-lg font-medium text-zinc-900 dark:text-white">No transactions found</p>
                                <p class="text-sm">Try adjusting your search or filters.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $transactions->links() }}
    </div>

    <!-- Centered Modal -->
    @if($showTransactionModal && $selectedTransaction)
        <div class="fixed inset-0 z-[60] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-zinc-900/75 transition-opacity" wire:click="closeTransactionModal" aria-hidden="true"></div>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="relative inline-block align-bottom bg-white dark:bg-zinc-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full border border-zinc-200 dark:border-zinc-800">
                    <!-- Header -->
                    <div class="px-4 py-5 sm:px-6 border-b border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900/50 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-zinc-900 dark:text-white" id="modal-title">
                                Transaction #{{ $selectedTransaction->order_number }}
                            </h3>
                            <p class="mt-1 max-w-2xl text-sm text-zinc-500 dark:text-zinc-400">
                                Created on {{ $selectedTransaction->created_at->format('M d, Y \a\t h:i A') }}
                            </p>
                        </div>
                        <button wire:click="closeTransactionModal" type="button" class="rounded-md text-zinc-400 hover:text-zinc-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            <span class="sr-only">Close</span>
                            <flux:icon icon="x-mark" class="h-6 w-6" />
                        </button>
                    </div>

                    <!-- Content -->
                    <div class="px-4 py-5 sm:p-6 max-h-[80vh] overflow-y-auto">
                        <!-- Status Section -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg p-4 border border-zinc-200 dark:border-zinc-700">
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Transaction Status</label>
                                <select wire:model="newStatus" class="block w-full rounded-md border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option value="pending">Pending</option>
                                    <option value="processing">Processing</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Payment Status</label>
                                <div class="flex gap-2">
                                    <select wire:model="newPaymentStatus" class="block w-full rounded-md border-zinc-300 dark:border-zinc-600 bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="pending">Pending</option>
                                        <option value="paid">Paid</option>
                                        <option value="failed">Failed</option>
                                    </select>
                                    <button wire:click="updateTransaction" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                        Update
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-y-8 gap-x-6 sm:grid-cols-2">
                            <!-- Customer Details -->
                            <div>
                                <h3 class="text-sm font-medium text-zinc-900 dark:text-white mb-3 flex items-center gap-2">
                                    <flux:icon icon="user" class="h-4 w-4 text-zinc-400" /> Customer
                                </h3>
                                <div class="bg-zinc-50 dark:bg-zinc-800/30 rounded-lg p-3 text-sm">
                                    <p class="font-medium text-zinc-900 dark:text-white">{{ $selectedTransaction->user->name ?? 'Guest' }}</p>
                                    <p class="text-zinc-500 dark:text-zinc-400">{{ $selectedTransaction->user->email ?? 'N/A' }}</p>
                                    <p class="text-zinc-500 dark:text-zinc-400">{{ $selectedTransaction->user->phone_number ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <!-- Payment Info -->
                            <div>
                                <h3 class="text-sm font-medium text-zinc-900 dark:text-white mb-3 flex items-center gap-2">
                                    <flux:icon icon="credit-card" class="h-4 w-4 text-zinc-400" /> Payment Details
                                </h3>
                                <div class="bg-zinc-50 dark:bg-zinc-800/30 rounded-lg p-3 text-sm">
                                    <p class="text-zinc-900 dark:text-white capitalize">Method: {{ $selectedTransaction->payment_method }}</p>
                                    <p class="text-zinc-500 dark:text-zinc-400 mt-1">
                                        Total: <span class="font-semibold text-zinc-900 dark:text-white">₱{{ number_format($selectedTransaction->total_amount, 2) }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Transaction Items -->
                        <div class="mt-8">
                            <h3 class="text-sm font-medium text-zinc-900 dark:text-white mb-4">Transaction Items</h3>
                            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">
                                <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                                    <thead class="bg-zinc-50 dark:bg-zinc-800">
                                        <tr>
                                            <th class="py-3 pl-4 pr-3 text-left text-xs font-medium uppercase tracking-wide text-zinc-500 dark:text-zinc-400">Product</th>
                                            <th class="px-3 py-3 text-right text-xs font-medium uppercase tracking-wide text-zinc-500 dark:text-zinc-400">Qty</th>
                                            <th class="px-3 py-3 text-right text-xs font-medium uppercase tracking-wide text-zinc-500 dark:text-zinc-400">Price</th>
                                            <th class="px-3 py-3 text-right text-xs font-medium uppercase tracking-wide text-zinc-500 dark:text-zinc-400">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700 bg-white dark:bg-zinc-900">
                                        @foreach($selectedTransaction->items as $item)
                                            <tr>
                                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-zinc-900 dark:text-white">
                                                    {{ $item->feed->name ?? 'Unknown Item' }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-right text-sm text-zinc-500 dark:text-zinc-400">
                                                    {{ $item->quantity }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-right text-sm text-zinc-500 dark:text-zinc-400">
                                                    ₱{{ number_format($item->price, 2) }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-right text-sm text-zinc-900 dark:text-white font-medium">
                                                    ₱{{ number_format($item->price * $item->quantity, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                                            <td colspan="3" class="py-4 pl-4 pr-3 text-right text-sm font-bold text-zinc-900 dark:text-white">Total Amount</td>
                                            <td class="px-3 py-4 text-right text-sm font-bold text-indigo-600 dark:text-indigo-400">
                                                ₱{{ number_format($selectedTransaction->total_amount, 2) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <div class="px-4 py-3 sm:px-6 bg-zinc-50 dark:bg-zinc-900/50 text-right">
                         <button wire:click="deleteTransaction({{ $selectedTransaction->id }})" 
                                wire:confirm="Are you sure you want to delete this transaction? This action cannot be undone."
                                type="button" 
                                class="inline-flex justify-center rounded-md border border-transparent bg-red-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            Delete Transaction
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
