@props([
'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand name="Jun & Jen's Shop" {{ $attributes }}>
        <x-slot name="logo" class="flex size-16 items-center justify-center">
            <x-app-logo-icon class="size-12 object-contain" />
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand name="Jun & Jen's" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-12 items-center justify-center rounded-md bg-white overflow-hidden shadow-sm border border-emerald-100 dark:border-emerald-800">
            <x-app-logo-icon class="size-8 object-contain" />
        </x-slot>
    </flux:brand>
@endif
