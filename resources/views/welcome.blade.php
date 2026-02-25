<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jun & Jen’s Game Farm and Feed Store</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#103e28] font-sans text-white antialiased selection:bg-emerald-500 selection:text-white">
    <!-- Navigation -->
    <nav class="absolute w-full z-50 top-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-24">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-auto">
                    <span class="font-bold text-xl tracking-wide uppercase text-white">Jun & Jen’s</span>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-12">
                    <a href="#home" class="text-sm font-medium hover:text-emerald-400 transition-colors">Home</a>
                    <a href="#about" class="text-sm font-medium hover:text-emerald-400 transition-colors">About</a>
                    <a href="#gallery" class="text-sm font-medium hover:text-emerald-400 transition-colors">Gallery</a>
                </div>

                <!-- Auth Buttons -->
                <div class="hidden md:flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-medium hover:text-emerald-400 transition-colors">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium hover:text-emerald-400 transition-colors">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2 rounded-md text-sm font-medium transition-all shadow-lg hover:shadow-emerald-900/20">
                                    Get Started
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button type="button" class="text-white hover:text-emerald-400 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="relative min-h-screen flex items-center pt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                
                <!-- Left Content -->
                <div class="max-w-2xl">
                    <h1 class="text-5xl lg:text-7xl font-bold leading-tight mb-6">
                        Integrated<br>
                        Management <span class="text-[#a3e635]">System</span>
                    </h1>
                    <p class="text-lg text-gray-300 mb-10 leading-relaxed">
                        The Jun & Jen’s Game Farm and Feed Store Integrated Management System provides a centralized and efficient platform that streamlines operations across the farm, hatchery, and feed store.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="#about" class="bg-[#4ade80] hover:bg-[#22c55e] text-[#064e3b] px-8 py-3 rounded-md text-sm font-semibold transition-all shadow-lg hover:shadow-emerald-900/20">
                            Learn More
                        </a>
                        <a href="#gallery" class="bg-white text-[#103e28] hover:bg-gray-100 px-8 py-3 rounded-md text-sm font-semibold transition-all shadow-lg">
                            View Gallery
                        </a>
                    </div>
                </div>

                <!-- Right Image -->
                <div class="relative">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl border-4 border-[#1a5f40]">
                        <img src="{{ asset('images/landing.png') }}" alt="Farm Landscape" class="w-full h-auto object-cover" onerror="this.onerror=null; this.src='{{ asset('images/c5.png') }}'">
                        <!-- Overlay gradient for better text readability if needed -->
                        <div class="absolute inset-0 bg-gradient-to-tr from-[#103e28]/20 to-transparent"></div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Standard Operations Section (Gallery Preview) -->
    <section id="about" class="py-24 bg-[#0d3321]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold mb-4">Standard Operations</h2>
                <p class="text-gray-400 max-w-2xl mx-auto">
                    Our system integrates every aspect of farm management, ensuring quality and efficiency from breeding to sales.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card 1 -->
                <div class="group relative rounded-xl overflow-hidden aspect-[4/3] cursor-pointer">
                    <img src="{{ asset('images/c1.png') }}" alt="Operation 1" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-black/40 group-hover:bg-black/20 transition-colors"></div>
                    <div class="absolute bottom-0 left-0 p-6">
                        <h3 class="text-lg font-semibold text-white">Breeding Program</h3>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="group relative rounded-xl overflow-hidden aspect-[4/3] cursor-pointer">
                    <img src="{{ asset('images/c2.png') }}" alt="Operation 2" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-black/40 group-hover:bg-black/20 transition-colors"></div>
                    <div class="absolute bottom-0 left-0 p-6">
                        <h3 class="text-lg font-semibold text-white">Feed Management</h3>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="group relative rounded-xl overflow-hidden aspect-[4/3] cursor-pointer">
                    <img src="{{ asset('images/c3.png') }}" alt="Operation 3" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                    <div class="absolute inset-0 bg-black/40 group-hover:bg-black/20 transition-colors"></div>
                    <div class="absolute bottom-0 left-0 p-6">
                        <h3 class="text-lg font-semibold text-white">Hatchery Records</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-12 border-t border-[#1a5f40]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-auto grayscale brightness-200">
                <span class="font-bold text-lg tracking-wide text-gray-400">JUN & JEN’S</span>
            </div>
            <p class="text-gray-500 text-sm">© {{ date('Y') }} Jun & Jen’s Game Farm. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>