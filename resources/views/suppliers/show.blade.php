<x-layouts.app>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Supplier Details') }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.suppliers.edit', $supplier->id) }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Edit') }}
                </a>
                <a href="{{ route('admin.suppliers.index') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 dark:bg-gray-200 dark:text-gray-800 dark:hover:bg-white">
                    {{ __('Back to List') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg border border-zinc-200 dark:border-zinc-700 p-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column: Status & Quick Info -->
                    <div class="space-y-6">
                        <div class="bg-gray-50 dark:bg-zinc-900 p-4 rounded-lg border border-zinc-100 dark:border-zinc-700/50">
                            <h4 class="font-semibold mb-3 text-indigo-600 dark:text-indigo-400 border-b border-zinc-200 dark:border-zinc-700 pb-2">{{ __('Quick Status') }}</h4>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider block mb-1">{{ __('Status') }}</span>
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $supplier->status === 'Active' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' }}">
                                        {{ $supplier->status }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider block mb-1">{{ __('Supplier Type') }}</span>
                                    <span class="text-lg font-bold text-gray-900 dark:text-white">{{ $supplier->supplier_type }}</span>
                                </div>
                                <div>
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider block mb-1">{{ __('Payment Terms') }}</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $supplier->payment_terms }}</span>
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
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                    </svg>
                                </span>
                                {{ __('Contact Information') }}
                            </h3>
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Supplier Name') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 font-medium">{{ $supplier->supplier_name }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Contact Person') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $supplier->contact_person }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Email') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $supplier->email }}</dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Phone Number') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $supplier->phone_number }}</dd>
                                </div>
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Address') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200">{{ $supplier->address }}</dd>
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
                                {{ __('Products & Remarks') }}
                            </h3>
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-6">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Products Supplied') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 whitespace-pre-line">{{ $supplier->products_supplied }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Remarks') }}</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-200 whitespace-pre-line bg-white dark:bg-zinc-800 p-3 rounded border border-gray-100 dark:border-zinc-700">{{ $supplier->remarks ?? 'No remarks available.' }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>