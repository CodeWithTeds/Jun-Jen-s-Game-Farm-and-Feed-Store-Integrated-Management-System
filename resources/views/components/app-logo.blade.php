@props([
'sidebar' => false,
])

@if($sidebar)
    <flux:sidebar.brand name="Jun & Jen's Shop" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md bg-white">
            <x-app-logo-icon class="size-6" />
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand name="Jun & Jen's" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md bg-white">
            <x-app-logo-icon class="size-6" />
        </x-slot>
    </flux:brand>
@endif
