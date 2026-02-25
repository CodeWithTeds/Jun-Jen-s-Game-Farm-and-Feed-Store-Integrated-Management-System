<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-[#103e28] antialiased flex flex-col items-center justify-center p-6 md:p-10">
        <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
            <div class="flex flex-col gap-6">
                <div class="flex justify-center">
                    <a href="{{ route('home') }}" wire:navigate>
                        <x-app-logo-icon class="size-12 fill-current text-[#103e28]" />
                    </a>
                </div>
                
                <div class="flex flex-col gap-6">
                    {{ $slot }}
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
