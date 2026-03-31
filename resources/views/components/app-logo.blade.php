@props([
'sidebar' => false,
])

@if($sidebar)
<div class="flex items-center gap-3 px-2 py-4">
    <div class="flex size-14 items-center justify-center flex-shrink-0">
        <x-app-logo-icon class="size-12 object-contain" />
    </div>
    <div class="flex flex-col leading-tight overflow-hidden">
        <span class="text-sm font-black uppercase tracking-tight text-white line-clamp-1">Jun and Jen’s</span>
        <span class="text-[11px] font-bold uppercase tracking-widest text-emerald-400">Game Farm & Feed Store</span>
    </div>
</div>
@else
<flux:brand name="Jun and Jen’s Game Farm & Feed Store" {{ $attributes }}>
    <x-slot name="logo" class="flex aspect-square size-12 items-center justify-center rounded-md bg-white overflow-hidden shadow-sm border border-emerald-100 dark:border-emerald-800">
        <x-app-logo-icon class="size-8 object-contain" />
    </x-slot>
</flux:brand>
@endif