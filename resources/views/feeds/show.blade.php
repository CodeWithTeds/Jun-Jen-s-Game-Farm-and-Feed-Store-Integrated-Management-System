<x-layouts.app>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Feed Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">{{ __('Feed: ') }} {{ $feed->feed_name }}</h3>
                        <div class="flex gap-2">
                            <a href="{{ route('staff.feeds.edit', $feed->id) }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Edit') }}
                            </a>
                            <a href="{{ route('staff.feeds.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white">
                                {{ __('Back to List') }}
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 dark:bg-zinc-900 p-4 rounded-lg">
                            <h4 class="font-semibold mb-2 text-indigo-600 dark:text-indigo-400">{{ __('Basic Information') }}</h4>
                            <div class="grid grid-cols-2 gap-2 text-sm">
                                <div class="text-gray-500 dark:text-gray-400">{{ __('Feed Name:') }}</div>
                                <div>{{ $feed->feed_name }}</div>

                                <div class="text-gray-500 dark:text-gray-400">{{ __('Type:') }}</div>
                                <div>{{ $feed->feed_type }}</div>

                                <div class="text-gray-500 dark:text-gray-400">{{ __('Brand:') }}</div>
                                <div>{{ $feed->brand }}</div>

                                <div class="text-gray-500 dark:text-gray-400">{{ __('Supplier:') }}</div>
                                <div>{{ $feed->supplier }}</div>
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-zinc-900 p-4 rounded-lg">
                            <h4 class="font-semibold mb-2 text-indigo-600 dark:text-indigo-400">{{ __('Stock Details') }}</h4>
                            <div class="grid grid-cols-2 gap-2 text-sm">
                                <div class="text-gray-500 dark:text-gray-400">{{ __('Quantity:') }}</div>
                                <div>{{ number_format($feed->quantity, 2) }} {{ $feed->unit }}</div>

                                <div class="text-gray-500 dark:text-gray-400">{{ __('Batch Number:') }}</div>
                                <div>{{ $feed->batch_number }}</div>

                                <div class="text-gray-500 dark:text-gray-400">{{ __('Status:') }}</div>
                                <div>
                                    @php
                                        $color = match($feed->status) {
                                            'Available' => 'green',
                                            'Low Stock' => 'yellow',
                                            'Expired' => 'red',
                                            default => 'gray',
                                        };
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $color }}-100 text-{{ $color }}-800 dark:bg-{{ $color }}-900 dark:text-{{ $color }}-300">
                                        {{ $feed->status }}
                                    </span>
                                </div>

                                <div class="text-gray-500 dark:text-gray-400">{{ __('Storage Location:') }}</div>
                                <div>{{ $feed->storage_location }}</div>

                                <div class="text-gray-500 dark:text-gray-400">{{ __('Reorder Level:') }}</div>
                                <div>{{ $feed->reorder_level }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                         <div class="bg-gray-50 dark:bg-zinc-900 p-4 rounded-lg">
                            <h4 class="font-semibold mb-2 text-indigo-600 dark:text-indigo-400">{{ __('Dates') }}</h4>
                            <div class="grid grid-cols-2 gap-2 text-sm">
                                <div class="text-gray-500 dark:text-gray-400">{{ __('Date Received:') }}</div>
                                <div>{{ $feed->date_received->format('M d, Y') }}</div>

                                <div class="text-gray-500 dark:text-gray-400">{{ __('Expiration Date:') }}</div>
                                <div class="{{ $feed->expiration_date->isPast() ? 'text-red-600 font-bold' : '' }}">
                                    {{ $feed->expiration_date->format('M d, Y') }}
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-zinc-900 p-4 rounded-lg">
                            <h4 class="font-semibold mb-2 text-indigo-600 dark:text-indigo-400">{{ __('Remarks') }}</h4>
                            <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $feed->remarks ?? 'No remarks available.' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
