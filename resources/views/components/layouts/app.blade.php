<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        @if (isset($header))
            <div class="mb-6">
                {{ $header }}
            </div>
        @endif

        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar>
