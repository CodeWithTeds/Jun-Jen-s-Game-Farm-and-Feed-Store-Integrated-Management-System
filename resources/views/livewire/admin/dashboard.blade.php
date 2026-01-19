@assets
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endassets

<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 space-y-8" wire:poll.30s>
    <!-- Header & Filters -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <flux:heading size="xl" class="leading-tight">{{ __('Dashboard') }}</flux:heading>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">{{ __('Overview of your store performance.') }}</p>
        </div>
        
        <div class="flex items-center gap-2">
            <select wire:model.live="dateRange" class="rounded-lg border-zinc-200 text-sm focus:ring-indigo-500 dark:bg-zinc-900 dark:border-zinc-700 dark:text-zinc-300">
                <option value="7_days">Last 7 Days</option>
                <option value="30_days">Last 30 Days</option>
                <option value="this_month">This Month</option>
                <option value="last_month">Last Month</option>
                <option value="custom">Custom Range</option>
            </select>

            @if($dateRange === 'custom')
                <input type="date" wire:model.live="customDateFrom" class="rounded-lg border-zinc-200 text-sm dark:bg-zinc-900 dark:border-zinc-700 dark:text-zinc-300">
                <span class="text-zinc-400">-</span>
                <input type="date" wire:model.live="customDateTo" class="rounded-lg border-zinc-200 text-sm dark:bg-zinc-900 dark:border-zinc-700 dark:text-zinc-300">
            @endif
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Revenue -->
        <div class="bg-white dark:bg-zinc-900 p-6 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Revenue</p>
                    <p class="text-2xl font-semibold text-zinc-900 dark:text-zinc-100 mt-1">
                        ₱{{ number_format($stats['total_sales'], 2) }}
                    </p>
                </div>
                <div class="p-3 bg-indigo-50 dark:bg-indigo-900/30 rounded-full text-indigo-600 dark:text-indigo-400">
                    <flux:icon name="banknotes" class="w-6 h-6" />
                </div>
            </div>
        </div>

        <!-- Orders -->
        <div class="bg-white dark:bg-zinc-900 p-6 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Orders</p>
                    <p class="text-2xl font-semibold text-zinc-900 dark:text-zinc-100 mt-1">
                        {{ number_format($stats['total_orders']) }}
                    </p>
                    <p class="text-xs text-amber-500 mt-1">{{ $stats['pending_orders'] }} Pending</p>
                </div>
                <div class="p-3 bg-blue-50 dark:bg-blue-900/30 rounded-full text-blue-600 dark:text-blue-400">
                    <flux:icon name="shopping-bag" class="w-6 h-6" />
                </div>
            </div>
        </div>

        <!-- Users -->
        <div class="bg-white dark:bg-zinc-900 p-6 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Total Users</p>
                    <p class="text-2xl font-semibold text-zinc-900 dark:text-zinc-100 mt-1">
                        {{ number_format($stats['total_users']) }}
                    </p>
                </div>
                <div class="p-3 bg-green-50 dark:bg-green-900/30 rounded-full text-green-600 dark:text-green-400">
                    <flux:icon name="users" class="w-6 h-6" />
                </div>
            </div>
        </div>

        <!-- Low Stock -->
        <div class="bg-white dark:bg-zinc-900 p-6 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-zinc-500 dark:text-zinc-400">Low Stock Items</p>
                    <p class="text-2xl font-semibold text-zinc-900 dark:text-zinc-100 mt-1">
                        {{ number_format($stats['low_stock_count']) }}
                    </p>
                    <p class="text-xs text-zinc-500 mt-1">of {{ $stats['total_products'] }} Products</p>
                </div>
                <div class="p-3 bg-red-50 dark:bg-red-900/30 rounded-full text-red-600 dark:text-red-400">
                    <flux:icon name="exclamation-triangle" class="w-6 h-6" />
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Sales Trend -->
        <div class="bg-white dark:bg-zinc-900 p-6 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm"
             x-data="{
                init() {
                    const data = @js($salesChartData);
                    const ctx = this.$refs.canvas.getContext('2d');
                    const isDark = document.documentElement.classList.contains('dark');
                    const gridColor = isDark ? '#27272a' : '#e5e7eb';
                    const textColor = isDark ? '#a1a1aa' : '#71717a';
                    
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data.map(d => d.date),
                            datasets: [{
                                label: 'Revenue',
                                data: data.map(d => d.total),
                                borderColor: '#4f46e5',
                                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                                tension: 0.4,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: {
                                y: { 
                                    beginAtZero: true, 
                                    grid: { color: gridColor },
                                    ticks: { color: textColor }
                                },
                                x: { 
                                    grid: { display: false },
                                    ticks: { color: textColor }
                                }
                            }
                        }
                    });
                }
             }"
        >
            <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-4">Sales Trend</h3>
            <div class="relative h-64 w-full">
                <canvas x-ref="canvas"></canvas>
            </div>
        </div>

        <!-- Top Products -->
        <div class="bg-white dark:bg-zinc-900 p-6 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm"
             x-data="{
                init() {
                    const labels = @js($topProducts['labels']);
                    const data = @js($topProducts['data']);
                    const ctx = this.$refs.canvas.getContext('2d');
                    const isDark = document.documentElement.classList.contains('dark');
                    const gridColor = isDark ? '#27272a' : '#e5e7eb';
                    const textColor = isDark ? '#a1a1aa' : '#71717a';
                    
                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Quantity Sold',
                                data: data,
                                backgroundColor: '#6366f1',
                                borderRadius: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: { legend: { display: false } },
                            scales: {
                                y: { 
                                    beginAtZero: true, 
                                    grid: { color: gridColor },
                                    ticks: { color: textColor }
                                },
                                x: { 
                                    grid: { display: false },
                                    ticks: { color: textColor }
                                }
                            }
                        }
                    });
                }
             }"
        >
            <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 mb-4">Top Selling Products</h3>
            <div class="relative h-64 w-full">
                <canvas x-ref="canvas"></canvas>
            </div>
        </div>
    </div>

    <!-- Tables Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Orders -->
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-zinc-200 dark:border-zinc-800 flex justify-between items-center">
                <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100">Recent Orders</h3>
                <a href="{{ route('admin.sales-transactions.index') }}" class="text-sm text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-zinc-500 uppercase bg-zinc-50 dark:bg-zinc-800/50 dark:text-zinc-400">
                        <tr>
                            <th class="px-6 py-3">Order #</th>
                            <th class="px-6 py-3">Customer</th>
                            <th class="px-6 py-3">Amount</th>
                            <th class="px-6 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse($recentOrders as $order)
                            <tr class="bg-white dark:bg-zinc-900 hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                <td class="px-6 py-4 font-medium text-zinc-900 dark:text-white">
                                    {{ $order->order_number }}
                                </td>
                                <td class="px-6 py-4 text-zinc-500 dark:text-zinc-400">
                                    {{ $order->user->name ?? 'Guest' }}
                                </td>
                                <td class="px-6 py-4 text-zinc-900 dark:text-zinc-100">
                                    ₱{{ number_format($order->total_amount, 2) }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        {{ $order->status === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 
                                           ($order->status === 'pending' ? 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400' : 'bg-zinc-100 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-400') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-zinc-500">No recent orders.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Low Stock Alerts -->
        <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
             <div class="p-6 border-b border-zinc-200 dark:border-zinc-800 flex justify-between items-center">
                <h3 class="text-lg font-medium text-zinc-900 dark:text-zinc-100 text-red-600 dark:text-red-400">Low Stock Alerts</h3>
                <a href="{{ route('admin.products.index') }}" class="text-sm text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">Manage Inventory</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-zinc-500 uppercase bg-zinc-50 dark:bg-zinc-800/50 dark:text-zinc-400">
                        <tr>
                            <th class="px-6 py-3">Product</th>
                            <th class="px-6 py-3">Stock</th>
                            <th class="px-6 py-3">Reorder Level</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse($lowStockItems as $item)
                            <tr class="bg-white dark:bg-zinc-900 hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                <td class="px-6 py-4 font-medium text-zinc-900 dark:text-white">
                                    {{ $item->feed_name }}
                                </td>
                                <td class="px-6 py-4 font-bold {{ $item->quantity <= 0 ? 'text-red-600' : 'text-amber-600' }}">
                                    {{ $item->quantity }}
                                </td>
                                <td class="px-6 py-4 text-zinc-500 dark:text-zinc-400">
                                    {{ $item->reorder_level }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-zinc-500">No low stock items.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
