<x-layouts.app>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ __('Reports') }}</h1>
        <a href="{{ route('admin.reports.export', request()->query()) }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-transparent bg-emerald-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
            </svg>
            Export Report (CSV)
        </a>
    </div>

    <!-- Filters -->
    <div class="mb-6 bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm">
        <form method="GET" action="{{ route('admin.reports.index') }}" class="flex flex-wrap gap-4 items-end">
            <div class="flex gap-2">
                <div class="w-40">
                    <label for="period" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Period</label>
                    <select id="period" name="period" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-300 dark:focus:border-emerald-500 transition-shadow">
                        <option value="">Custom Date Range</option>
                        <option value="today" {{ ($filters['period'] ?? '') === 'today' ? 'selected' : '' }}>Today (Per Day)</option>
                        <option value="this_month" {{ ($filters['period'] ?? '') === 'this_month' ? 'selected' : '' }}>This Month (Per Month)</option>
                        <option value="this_year" {{ ($filters['period'] ?? '') === 'this_year' ? 'selected' : '' }}>This Year (Per Year)</option>
                    </select>
                </div>
                <div class="w-32">
                    <label for="date_from" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">From</label>
                    <input type="date" id="date_from" name="date_from" value="{{ $filters['date_from'] ?? '' }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-300 dark:focus:border-emerald-500 transition-shadow">
                </div>
                <div class="w-32">
                    <label for="date_to" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">To</label>
                    <input type="date" id="date_to" name="date_to" value="{{ $filters['date_to'] ?? '' }}" class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-300 dark:focus:border-emerald-500 transition-shadow">
                </div>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white">
                    {{ __('Filter') }}
                </button>
                
                @if(request()->anyFilled(['period', 'date_from', 'date_to']))
                    <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 dark:bg-slate-800 dark:border-slate-600 dark:text-gray-300 dark:hover:bg-slate-700">
                        {{ __('Clear') }}
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Sales Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-[#103e28] rounded-xl p-6 border border-[#103e28] shadow-sm text-white">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-lg">
                    <flux:icon icon="currency-dollar" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <p class="text-sm font-medium text-emerald-100">Total Sales</p>
                    <p class="text-2xl font-bold">₱{{ number_format($data['sales_report']['total_sales'], 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-[#103e28] rounded-xl p-6 border border-[#103e28] shadow-sm text-white">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-lg">
                    <flux:icon icon="shopping-cart" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <p class="text-sm font-medium text-emerald-100">Total Orders</p>
                    <p class="text-2xl font-bold">{{ number_format($data['sales_report']['total_orders']) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-[#103e28] rounded-xl p-6 border border-[#103e28] shadow-sm text-white">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-lg">
                    <flux:icon icon="chart-bar" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <p class="text-sm font-medium text-emerald-100">Average Order Value</p>
                    <p class="text-2xl font-bold">₱{{ number_format($data['sales_report']['average_order_value'], 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Top Selling Products -->
        <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Top Selling Products</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 dark:bg-slate-950/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Sold</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                        @forelse($data['top_products'] as $product)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">
                                    {{ $product->feed->feed_name ?? 'Unknown Product' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-right text-slate-600 dark:text-slate-300">
                                    {{ $product->total_quantity }}
                                </td>
                                <td class="px-6 py-4 text-sm text-right text-slate-600 dark:text-slate-300">
                                    ₱{{ number_format($product->total_revenue, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-sm text-slate-500 dark:text-slate-400">
                                    No sales data available for this period.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Selling Chickens -->
        <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Sold Chickens</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 dark:bg-slate-950/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Game Fowl</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Sold</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                        @forelse($data['top_chickens'] as $chicken)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">
                                    {{ $chicken->gameFowl->name ?? 'Unknown Chicken' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-right text-slate-600 dark:text-slate-300">
                                    {{ $chicken->total_quantity }}
                                </td>
                                <td class="px-6 py-4 text-sm text-right text-slate-600 dark:text-slate-300">
                                    ₱{{ number_format($chicken->total_revenue, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-sm text-slate-500 dark:text-slate-400">No data available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Inventory Summary -->
        <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Inventory Health</h3>
            </div>
            <div class="p-6 space-y-6">
                <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-950/50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-full">
                            <flux:icon icon="archive-box" class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                        </div>
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Total Products</span>
                    </div>
                    <span class="text-lg font-bold text-slate-900 dark:text-white">{{ $data['inventory_summary']['total_products'] }}</span>
                </div>

                <div class="flex items-center justify-between p-4 bg-red-50 dark:bg-red-900/10 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-red-100 dark:bg-red-900/30 rounded-full">
                            <flux:icon icon="exclamation-circle" class="w-5 h-5 text-red-600 dark:text-red-400" />
                        </div>
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Low Stock Items</span>
                    </div>
                    <span class="text-lg font-bold text-red-600 dark:text-red-400">{{ $data['inventory_summary']['low_stock'] }}</span>
                </div>

                <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-950/50 rounded-lg">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-gray-100 dark:bg-gray-800 rounded-full">
                            <flux:icon icon="x-circle" class="w-5 h-5 text-gray-600 dark:text-gray-400" />
                        </div>
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Out of Stock</span>
                    </div>
                    <span class="text-lg font-bold text-slate-900 dark:text-white">{{ $data['inventory_summary']['out_of_stock'] }}</span>
                </div>

                <div class="pt-4 border-t border-slate-200 dark:border-slate-800">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-slate-500 dark:text-slate-400">Total Inventory Value</span>
                        <span class="text-xl font-bold text-slate-900 dark:text-white">₱{{ number_format($data['inventory_summary']['total_inventory_value'], 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
