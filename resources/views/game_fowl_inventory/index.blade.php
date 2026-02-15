<x-layouts.app>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Game Fowl Inventory') }}
            </h2>
            @php
                $routePrefix = request()->routeIs('admin.*') ? 'admin.' : 'staff.';
            @endphp
            <a href="{{ route($routePrefix . 'game-fowl-inventory.create') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Add Inventory
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Filters -->
            <div class="mb-6 bg-white dark:bg-zinc-800 overflow-hidden shadow-xl sm:rounded-lg p-6 border-b border-gray-200 dark:border-zinc-700">
                <form method="GET" action="{{ route($routePrefix . 'game-fowl-inventory.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    
                    <!-- Gender Filter -->
                    <div>
                        <label for="sex" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Gender</label>
                        <select name="sex" id="sex" class="block w-full rounded-md border-gray-300 dark:border-zinc-700 dark:bg-zinc-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">All Genders</option>
                            <option value="Male" {{ request('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ request('sex') == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status</label>
                        <select name="status" id="status" class="block w-full rounded-md border-gray-300 dark:border-zinc-700 dark:bg-zinc-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">All Statuses</option>
                            <option value="Available" {{ request('status') == 'Available' ? 'selected' : '' }}>Available</option>
                            <option value="Sold" {{ request('status') == 'Sold' ? 'selected' : '' }}>Sold</option>
                            <option value="Deceased" {{ request('status') == 'Deceased' ? 'selected' : '' }}>Deceased</option>
                            <option value="Cull" {{ request('status') == 'Cull' ? 'selected' : '' }}>Cull</option>
                        </select>
                    </div>

                    <!-- Reproductive Status Filter -->
                    <div>
                        <label for="reproductive_status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Reproductive Status</label>
                        <select name="reproductive_status" id="reproductive_status" class="block w-full rounded-md border-gray-300 dark:border-zinc-700 dark:bg-zinc-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">All Reproductive Statuses</option>
                            <option value="Ready to Lay Eggs" {{ request('reproductive_status') == 'Ready to Lay Eggs' ? 'selected' : '' }}>Ready to Lay Eggs</option>
                            <option value="Too Young" {{ request('reproductive_status') == 'Too Young' ? 'selected' : '' }}>Too Young</option>
                            <option value="Already Laying" {{ request('reproductive_status') == 'Already Laying' ? 'selected' : '' }}>Already Laying</option>
                            <option value="Ready to Breed" {{ request('reproductive_status') == 'Ready to Breed' ? 'selected' : '' }}>Ready to Breed</option>
                            <option value="Active Breeder" {{ request('reproductive_status') == 'Active Breeder' ? 'selected' : '' }}>Active Breeder</option>
                            <option value="Retired" {{ request('reproductive_status') == 'Retired' ? 'selected' : '' }}>Retired</option>
                            <option value="Not Applicable" {{ request('reproductive_status') == 'Not Applicable' ? 'selected' : '' }}>Not Applicable</option>
                        </select>
                    </div>

                    <!-- Gender Identification Method Filter -->
                    <div>
                        <label for="gender_identification" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Gender ID Method</label>
                        <select name="gender_identification" id="gender_identification" class="block w-full rounded-md border-gray-300 dark:border-zinc-700 dark:bg-zinc-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">All Methods</option>
                            <option value="Visual" {{ request('gender_identification') == 'Visual' ? 'selected' : '' }}>Visual</option>
                            <option value="Vent Sexing" {{ request('gender_identification') == 'Vent Sexing' ? 'selected' : '' }}>Vent Sexing</option>
                            <option value="Feather Sexing" {{ request('gender_identification') == 'Feather Sexing' ? 'selected' : '' }}>Feather Sexing</option>
                            <option value="DNA" {{ request('gender_identification') == 'DNA' ? 'selected' : '' }}>DNA</option>
                            <option value="Behavior" {{ request('gender_identification') == 'Behavior' ? 'selected' : '' }}>Behavior</option>
                        </select>
                    </div>

                    <!-- Filter Actions -->
                    <div class="flex space-x-2">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Filter
                        </button>
                        <a href="{{ route($routePrefix . 'game-fowl-inventory.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-zinc-800 border border-gray-300 dark:border-zinc-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-zinc-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white dark:bg-zinc-800 border-b border-gray-200 dark:border-zinc-700">
                    
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Success!</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
                            <thead class="bg-gray-50 dark:bg-zinc-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Game Fowl</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Gender</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Quantity</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Location</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-zinc-800 divide-y divide-gray-200 dark:divide-zinc-700">
                                @forelse($inventories as $inventory)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $inventory->gameFowl->name }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                Tag: {{ $inventory->gameFowl->tag_id }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($inventory->gameFowl->sex === 'Male') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                                @elseif($inventory->gameFowl->sex === 'Female') bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200
                                                @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif">
                                                {{ $inventory->gameFowl->sex }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-white">{{ $inventory->quantity }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($inventory->status === 'Available') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                @elseif($inventory->status === 'Sold') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                                @elseif($inventory->status === 'Deceased') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                                @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif">
                                                {{ $inventory->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                            {{ $inventory->location ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route($routePrefix . 'game-fowl-inventory.edit', $inventory->id) }}" wire:navigate class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 mr-3">Edit</a>
                                            <form action="{{ route($routePrefix . 'game-fowl-inventory.destroy', $inventory->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this inventory record?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-900 dark:hover:text-red-300">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 text-center">
                                            No inventory records found matching your criteria.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $inventories->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>

            <!-- Registered Game Fowls (No Need to Create) -->
            <div class="mt-8 bg-white dark:bg-zinc-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white dark:bg-zinc-800 border-b border-gray-200 dark:border-zinc-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">All Registered Game Fowls (No Need to Create New Profiles)</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-700">
                            <thead class="bg-gray-50 dark:bg-zinc-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tag ID</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Gender</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Age</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-zinc-800 divide-y divide-gray-200 dark:divide-zinc-700">
                                @forelse($gameFowls as $fowl)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $fowl->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $fowl->tag_id }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                @if($fowl->sex === 'Male') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                                @elseif($fowl->sex === 'Female') bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200
                                                @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 @endif">
                                                {{ $fowl->sex }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500 dark:text-gray-400">{{ $fowl->current_age }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route($routePrefix . 'game-fowls.show', $fowl->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 mr-3">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                            No game fowls found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
