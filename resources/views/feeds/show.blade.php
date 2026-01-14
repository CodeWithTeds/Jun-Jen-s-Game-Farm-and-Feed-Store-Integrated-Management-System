@php
    $routePrefix = request()->routeIs('staff.*') ? 'staff.' : (request()->routeIs('customer.*') ? 'customer.' : 'admin.');
@endphp
<x-layouts.app>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Feed Details') }}
            </h2>
            <div class="flex gap-2">
                @if($routePrefix !== 'customer.')
                <a href="{{ route($routePrefix . 'feeds.edit', $feed->id) }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Edit') }}
                </a>
                @endif
                <a href="{{ route($routePrefix . 'feeds.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white">
                    {{ __('Back to List') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column: Image -->
                    <div class="space-y-6">
                        <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-gray-200 dark:bg-zinc-700 xl:aspect-w-7 xl:aspect-h-8">
                            <img src="{{ $feed->image ? asset('storage/' . $feed->image) : 'https://ui-avatars.com/api/?name=' . urlencode($feed->feed_name) . '&background=random' }}" alt="{{ $feed->feed_name }}" class="h-full w-full object-cover object-center group-hover:opacity-75">
                        </div>
                        
                        <div class="bg-gray-50 dark:bg-zinc-900 p-4 rounded-lg border border-zinc-100 dark:border-zinc-700/50">
                            <h4 class="font-semibold mb-3 text-indigo-600 dark:text-indigo-400 border-b border-zinc-200 dark:border-zinc-700 pb-2">{{ __('Quick Status') }}</h4>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider block mb-1">{{ __('Status') }}</span>
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
                                @if($routePrefix === 'admin.')
                                    <div>
                                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider block mb-1">{{ __('Display Status') }}</span>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $feed->is_displayed ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                                            {{ $feed->is_displayed ? 'Displayed' : 'Hidden' }}
                                        </span>
                                    </div>
                                @endif
                                <div>
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider block mb-1">{{ __('Current Quantity') }}</span>
                                    <span class="text-lg font-bold text-gray-900 dark:text-white">{{ number_format($feed->quantity, 2) }} {{ $feed->unit }}</span>
                                </div>
                                <div>
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider block mb-1">{{ __('Price') }}</span>
                                    <span class="text-lg font-bold text-gray-900 dark:text-white">{{ number_format($feed->price, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Details -->
                    <div class="lg:col-span-2 space-y-6">
                         <div class="bg-gray-50 dark:bg-zinc-900 p-6 rounded-lg border border-zinc-100 dark:border-zinc-700/50">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                <span class="text-indigo-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                    </svg>
                                </span>
                                {{ __('Basic Information') }}
                            </h3>
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Feed Name') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 font-medium">{{ $feed->feed_name }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Type') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $feed->feed_type }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Brand') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $feed->brand }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Supplier') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $feed->supplier }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div class="bg-gray-50 dark:bg-zinc-900 p-6 rounded-lg border border-zinc-100 dark:border-zinc-700/50">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                <span class="text-indigo-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0l-3-3m3 3l3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                                    </svg>
                                </span>
                                {{ __('Inventory Details') }}
                            </h3>
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Batch Number') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 font-mono">{{ $feed->batch_number }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Storage Location') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $feed->storage_location }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Reorder Level') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $feed->reorder_level }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-gray-50 dark:bg-zinc-900 p-6 rounded-lg border border-zinc-100 dark:border-zinc-700/50">
                                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                    <span class="text-indigo-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                        </svg>
                                    </span>
                                    {{ __('Dates') }}
                                </h3>
                                <dl class="space-y-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Date Received') }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $feed->date_received->format('F j, Y') }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Expiration Date') }}</dt>
                                        <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 {{ $feed->expiration_date->isPast() ? 'text-red-600 font-bold' : '' }}">
                                            {{ $feed->expiration_date->format('F j, Y') }}
                                        </dd>
                                    </div>
                                </dl>
                            </div>

                            <div class="bg-gray-50 dark:bg-zinc-900 p-6 rounded-lg border border-zinc-100 dark:border-zinc-700/50">
                                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                                    <span class="text-indigo-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                        </svg>
                                    </span>
                                    {{ __('Remarks') }}
                                </h3>
                                <div class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line bg-white dark:bg-zinc-800 p-3 rounded border border-gray-100 dark:border-zinc-700">
                                    {{ $feed->remarks ?? 'No remarks available.' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>