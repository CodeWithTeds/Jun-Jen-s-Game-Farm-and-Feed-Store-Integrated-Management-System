<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-slate-50 dark:bg-slate-950">
    <flux:sidebar sticky collapsible="mobile" class="border-e border-[#103e28] bg-[#103e28] dark:border-[#103e28] dark:bg-[#103e28] text-white [&_a]:!text-white [&_button]:!text-white [&_div]:!text-white [&_span]:!text-white [&_a:hover]:!bg-transparent [&_button:hover]:!bg-transparent [&_[aria-current='page']]:!bg-transparent [&_[data-current]]:!bg-transparent">
        <flux:sidebar.header>
            <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
            <flux:sidebar.collapse class="lg:hidden" />
        </flux:sidebar.header>

        <flux:sidebar.nav>
            @if(auth()->user()->role === 'staff')
            <flux:sidebar.group :heading="__('Platform')" class="grid">
                <flux:sidebar.item :href="route('staff.dashboard')" :current="request()->routeIs('staff.dashboard')" wire:navigate>
                    <x-slot:icon>
                        <flux:icon :icon="'layout-grid'" class="size-6 text-emerald-500" />
                    </x-slot:icon>
                    {{ __('Dashboard') }}
                </flux:sidebar.item>
            </flux:sidebar.group>

            <flux:sidebar.group expandable :expanded="request()->routeIs('staff.*')" :heading="__('Game Fowl Hub')">
                <x-slot:icon>
                    <flux:icon :icon="'clipboard-document-list'" class="size-6 text-emerald-500" />
                </x-slot:icon>

                <flux:sidebar.item :href="route('staff.game-fowls.index')" :current="request()->routeIs('staff.game-fowls.*')" wire:navigate>
                    <x-slot:icon>
                        <flux:icon :icon="'trophy'" class="size-6 text-orange-500" />
                    </x-slot:icon>
                    {{ __('GFowl Management') }}
                </flux:sidebar.item>

                <flux:sidebar.item :href="route('staff.breedings.index')" :current="request()->routeIs('staff.breedings.*')" wire:navigate>
                    <x-slot:icon>
                        <flux:icon :icon="'heart'" class="size-6 text-rose-500" />
                    </x-slot:icon>
                    {{ __('Breeding Management') }}
                </flux:sidebar.item>

                <flux:sidebar.item :href="route('staff.egg-collections.index')" :current="request()->routeIs('staff.egg-collections.*')" wire:navigate>
                    <x-slot:icon>
                        <flux:icon :icon="'circle-stack'" class="size-6 text-amber-500" />
                    </x-slot:icon>
                    {{ __('Egg Collections') }}
                </flux:sidebar.item>

                <flux:sidebar.item :href="route('staff.hatchery-records.index')" :current="request()->routeIs('staff.hatchery-records.*')" wire:navigate>
                    <x-slot:icon>
                        <flux:icon :icon="'fire'" class="size-6 text-red-500" />
                    </x-slot:icon>
                    {{ __('Hatchery Records') }}
                </flux:sidebar.item>

                <flux:sidebar.item :href="route('staff.chick-rearings.index')" :current="request()->routeIs('staff.chick-rearings.*')" wire:navigate>
                    <x-slot:icon>
                        <flux:icon :icon="'sparkles'" class="size-6 text-yellow-500" />
                    </x-slot:icon>
                    {{ __('Chick Rearing') }}
                </flux:sidebar.item>

                <flux:sidebar.item :href="route('staff.medical-records.index')" :current="request()->routeIs('staff.medical-records.*')" wire:navigate>
                    <x-slot:icon>
                        <flux:icon :icon="'plus-circle'" class="size-6 text-red-500" />
                    </x-slot:icon>
                    {{ __('Medical Records') }}
                </flux:sidebar.item>

                <flux:sidebar.item :href="route('staff.fight-schedules.index')" :current="request()->routeIs('staff.fight-schedules.*')" wire:navigate>
                    <x-slot:icon>
                        <flux:icon :icon="'calendar-days'" class="size-6 text-violet-500" />
                    </x-slot:icon>
                    {{ __('Fight Schedule') }}
                </flux:sidebar.item>

                <flux:sidebar.item :href="route('staff.game-fowl-inventory.index')" :current="request()->routeIs('staff.game-fowl-inventory.*')" wire:navigate>
                    <x-slot:icon>
                        <flux:icon :icon="'chart-bar'" class="size-6 text-green-600" />
                    </x-slot:icon>
                    {{ __('GFowl Inventory') }}
                </flux:sidebar.item>

                <flux:sidebar.item :href="route('staff.reports.game-fowls.index')" :current="request()->routeIs('staff.reports.game-fowls.*')" wire:navigate>
                    <x-slot:icon>
                        <flux:icon :icon="'book-open-text'" class="size-6 text-indigo-500" />
                    </x-slot:icon>
                    {{ __('Game Fowl Record') }}
                </flux:sidebar.item>
            </flux:sidebar.group>

            <flux:sidebar.group :heading="__('Records')" class="grid">


                <flux:sidebar.item :href="route('staff.products.index')" :current="request()->routeIs('staff.products.*')" wire:navigate>
                    <x-slot:icon>
                        <flux:icon :icon="'archive-box'" class="size-6 text-blue-500" />
                    </x-slot:icon>
                    {{ __('Feed Store Inventory') }}
                </flux:sidebar.item>



                <flux:sidebar.item :href="route('staff.orders.index')" :current="request()->routeIs('staff.orders.*')" wire:navigate>
                    <x-slot:icon>
                        <flux:icon :icon="'shopping-bag'" class="size-6 text-purple-500" />
                    </x-slot:icon>
                    {{ __('Order Management') }}
                </flux:sidebar.item>

                <flux:sidebar.item :href="route('schedules.index')" :current="request()->routeIs('schedules.*')" wire:navigate>
                    <x-slot:icon>
                        <flux:icon :icon="'calendar'" class="size-6 text-purple-500" />
                    </x-slot:icon>
                    {{ __('Schedules / Reminders') }}
                </flux:sidebar.item>
            </flux:sidebar.group>

            @elseif(auth()->user()->role === 'customer')
            <flux:sidebar.group :heading="__('Platform')" class="grid">
                <flux:sidebar.item :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                    <x-slot:icon>
                        <flux:icon :icon="'layout-grid'" class="size-6 text-emerald-500" />
                    </x-slot:icon>
                    {{ __('Dashboard') }}
                </flux:sidebar.item>

                <flux:sidebar.item :href="route('customer.pos.index')" :current="request()->routeIs('customer.pos.*')" wire:navigate>
                    <x-slot:icon>
                        <flux:icon :icon="'archive-box'" class="size-6 text-blue-500" />
                    </x-slot:icon>
                    {{ __('POS') }}
                </flux:sidebar.item>

                <flux:sidebar.item :href="route('customer.orders.index')" :current="request()->routeIs('customer.orders.index')" wire:navigate>
                    <x-slot:icon>
                        <flux:icon :icon="'receipt-refund'" class="size-6 text-purple-500" />
                    </x-slot:icon>
                    {{ __('Purchase History') }}
                </flux:sidebar.item>
            </flux:sidebar.group>

            @elseif(auth()->user()->role === 'admin')
            <flux:sidebar.group :heading="__('Platform')" class="grid">
                <flux:sidebar.item :href="route('admin.dashboard')" :current="request()->routeIs('admin.dashboard')" wire:navigate>
                    <x-slot:icon>
                        <flux:icon :icon="'layout-grid'" class="size-6 text-emerald-500" />
                    </x-slot:icon>
                    {{ __('Dashboard') }}
                </flux:sidebar.item>
            </flux:sidebar.group>

            <flux:sidebar.group expandable :expanded="request()->routeIs('admin.game-fowls.*', 'admin.breedings.*', 'admin.egg-collections.*', 'admin.hatchery-records.*', 'admin.chick-rearings.*', 'admin.medical-records.*', 'admin.fight-schedules.*', 'admin.game-fowl-inventory.*')" :heading="__('Game Fowl Hub')">
                <x-slot:icon>
                    <flux:icon :icon="'clipboard-document-list'" class="size-6 text-emerald-500" />
                </x-slot:icon>

                <flux:sidebar.item :href="route('admin.game-fowls.index')" :current="request()->routeIs('admin.game-fowls.*')" wire:navigate>
                    <x-slot:icon>
                        <flux:icon :icon="'trophy'" class="size-6 text-orange-500" />
                    </x-slot:icon>
                    {{ __('GFowl Management') }}
                </flux:sidebar.item>

                <flux:sidebar.item :href="route('admin.breedings.index')" :current="request()->routeIs('admin.breedings.*')" wire:navigate>
                    <x-slot:icon>
                        <flux:icon :icon="'heart'" class="size-6 text-rose-500" />
                    </x-slot:icon>
                    {{ __('Breeding Management') }}
                </flux:sidebar.item>

                <flux:sidebar.item :href="route('admin.egg-collections.index')" :current="request()->routeIs('admin.egg-collections.*')" wire:navigate>
                    <x-slot:icon>
                        <flux:icon :icon="'circle-stack'" class="size-6 text-amber-500" />
                    </x-slot:icon>
                    {{ __('Egg Collections') }}
                </flux:sidebar.item>

                <flux:sidebar.item :href="route('admin.hatchery-records.index')" :current="request()->routeIs('admin.hatchery-records.*')" wire:navigate>
                    <x-slot:icon>
                        <flux:icon :icon="'fire'" class="size-6 text-red-500" />
                    </x-slot:icon>
                    {{ __('Hatchery Records') }}
                </flux:sidebar.item>

                <flux:sidebar.item :href="route('admin.chick-rearings.index')" :current="request()->routeIs('admin.chick-rearings.*')" wire:navigate>
                    <x-slot:icon>
                        <flux:icon :icon="'sparkles'" class="size-6 text-yellow-500" />
                    </x-slot:icon>
                    {{ __('Chick Rearing') }}
                </flux:sidebar.item>

                <flux:sidebar.item :href="route('admin.medical-records.index')" :current="request()->routeIs('admin.medical-records.*')" wire:navigate>
                    <x-slot:icon>
                        <flux:icon :icon="'plus-circle'" class="size-6 text-red-500" />
                    </x-slot:icon>
                    {{ __('Medical Records') }}
                </flux:sidebar.item>

                <flux:sidebar.item :href="route('admin.fight-schedules.index')" :current="request()->routeIs('admin.fight-schedules.*')" wire:navigate>
                    <x-slot:icon>
                        <flux:icon :icon="'calendar-days'" class="size-6 text-purple-600" />
                    </x-slot:icon>
                    {{ __('Fight Schedule') }}
                </flux:sidebar.item>

                <flux:sidebar.item :href="route('admin.game-fowl-inventory.index')" :current="request()->routeIs('admin.game-fowl-inventory.*')" wire:navigate>
                    <x-slot:icon>
                        <flux:icon :icon="'chart-bar'" class="size-6 text-green-600" />
                    </x-slot:icon>
                    {{ __('GFowl Inventory') }}
                </flux:sidebar.item>

                <flux:sidebar.item :href="route('admin.reports.game-fowls.index')" :current="request()->routeIs('admin.reports.game-fowls.*')" wire:navigate>
                    <x-slot:icon>
                        <flux:icon :icon="'book-open-text'" class="size-6 text-indigo-500" />
                    </x-slot:icon>
                    {{ __('Game Fowl Record') }}
                </flux:sidebar.item>
            </flux:sidebar.group>

            <flux:sidebar.group :heading="__('Records')" class="grid">
                <flux:sidebar.item :href="route('admin.products.index')" :current="request()->routeIs('admin.products.*')" wire:navigate>
                    <x-slot:icon>
                        <flux:icon :icon="'archive-box'" class="size-6 text-blue-500" />
                    </x-slot:icon>
                    {{ __('Feed Store Inventory') }}
                </flux:sidebar.item>
            </flux:sidebar.group>

            <flux:sidebar.group :heading="__('Administration')" class="grid">
                @can('view-users')
                <flux:sidebar.item :href="route('users.index')" :current="request()->routeIs('users.*')" wire:navigate>
                    <x-slot:icon>
                        <flux:icon :icon="'user-group'" class="size-6 text-red-500" />
                    </x-slot:icon>
                    {{ __('User Management') }}
                </flux:sidebar.item>
                @endcan

                <flux:sidebar.item :href="route('admin.sales-transactions.index')" :current="request()->routeIs('admin.sales-transactions.*')" wire:navigate>
                    <x-slot:icon>
                        <flux:icon :icon="'banknotes'" class="size-6 text-emerald-500" />
                    </x-slot:icon>
                    {{ __('Sales Transactions') }}
                </flux:sidebar.item>

                <flux:sidebar.item :href="route('schedules.index')" :current="request()->routeIs('schedules.*')" wire:navigate>
                    <x-slot:icon>
                        <flux:icon :icon="'calendar'" class="size-6 text-purple-500" />
                    </x-slot:icon>
                    {{ __('Schedules / Reminders') }}
                </flux:sidebar.item>



                <flux:sidebar.item :href="route('admin.suppliers.index')" :current="request()->routeIs('admin.suppliers.*')" wire:navigate>
                    <x-slot:icon>
                        <flux:icon :icon="'truck'" class="size-6 text-purple-500" />
                    </x-slot:icon>
                    {{ __('Suppliers') }}
                </flux:sidebar.item>

                <flux:sidebar.item :href="route('admin.reports.index')" :current="request()->routeIs('admin.reports.index')" wire:navigate>
                    <x-slot:icon>
                        <flux:icon :icon="'chart-bar'" class="size-6 text-purple-500" />
                    </x-slot:icon>
                    {{ __('Reports') }}
                </flux:sidebar.item>
            </flux:sidebar.group>

            @else
            <flux:sidebar.group :heading="__('Platform')" class="grid">
                <flux:sidebar.item :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                    <x-slot:icon>
                        <flux:icon :icon="'layout-grid'" class="size-6 text-emerald-500" />
                    </x-slot:icon>
                    {{ __('Dashboard') }}
                </flux:sidebar.item>
            </flux:sidebar.group>
            @endif
        </flux:sidebar.nav>

        <flux:spacer />

        <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
    </flux:sidebar>

    <!-- Mobile User Menu -->
    <flux:header class="lg:hidden">
        <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

        <flux:spacer />

        <flux:dropdown position="top" align="end">
            <flux:profile
                as="button"
                :initials="auth()->user()->initials()"
                icon-trailing="chevron-down" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <flux:avatar
                                :name="auth()->user()->name"
                                :initials="auth()->user()->initials()" />

                            <div class="grid flex-1 text-start text-sm leading-tight">
                                <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                            </div>
                        </div>
                    </div>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <flux:menu.radio.group>
                    <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                        {{ __('Settings') }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item
                        as="button"
                        type="submit"
                        icon="arrow-right-start-on-rectangle"
                        class="w-full cursor-pointer"
                        data-test="logout-button">
                        {{ __('Log Out') }}
                    </flux:menu.item>
                </form>
            </flux:menu>
        </flux:dropdown>
    </flux:header>

    {{ $slot }}

    @fluxScripts
</body>

</html>