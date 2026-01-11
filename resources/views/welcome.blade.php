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
<body class="bg-zinc-50 font-sans text-zinc-900 antialiased">
    <!-- Navigation -->
    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 border-b border-zinc-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="#" class="flex-shrink-0 flex items-center gap-2">
                        <!-- You might want to add a logo icon here if available -->
                        <span class="font-bold text-xl text-emerald-700 tracking-tight">Jun & Jen’s</span>
                    </a>
                    <div class="hidden md:ml-10 md:flex md:space-x-8">
                        <a href="#home" class="text-zinc-500 hover:text-emerald-600 px-3 py-2 text-sm font-medium transition-colors">Home</a>
                        <a href="#about" class="text-zinc-500 hover:text-emerald-600 px-3 py-2 text-sm font-medium transition-colors">About</a>
                        <a href="#gallery" class="text-zinc-500 hover:text-emerald-600 px-3 py-2 text-sm font-medium transition-colors">Gallery</a>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        <div class="flex items-center gap-2">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-zinc-700 hover:text-emerald-600 transition-colors">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-medium text-zinc-700 hover:text-emerald-600 transition-colors">Log in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all shadow-sm hover:shadow-md">Get Started</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="relative overflow-hidden pt-16 pb-20 lg:pt-24 lg:pb-28">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-8 items-center">
                <div class="text-center lg:text-left">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-zinc-900 mb-6">
                        Integrated Management <span class="text-emerald-600">System</span>
                    </h1>
                    <p class="text-lg text-zinc-600 mb-8 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        The Jun & Jen’s Game Farm and Feed Store Integrated Management System provides a centralized and efficient platform that streamlines operations across the farm, hatchery, and feed store.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="#about" class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-3.5 rounded-lg text-base font-semibold transition-all shadow-lg hover:shadow-emerald-200">
                            Learn More
                        </a>
                        <a href="#gallery" class="bg-white hover:bg-zinc-50 text-zinc-700 border border-zinc-200 px-8 py-3.5 rounded-lg text-base font-semibold transition-all shadow-sm hover:shadow-md">
                            View Gallery
                        </a>
                    </div>
                </div>
                <div class="relative lg:h-auto flex justify-center items-center">
                    <div class="relative max-w-sm w-full">
                        <img src="{{ asset('images/welcome.png') }}" alt="Jun & Jen's Farm" class="w-full h-auto rounded-xl shadow-lg">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-3xl font-bold text-zinc-900 mb-6">Streamlined Operations</h2>
                <div class="w-24 h-1.5 bg-emerald-500 mx-auto rounded-full mb-8"></div>
                <p class="text-lg text-zinc-600 leading-relaxed">
                    Our system incorporates features that support role-based access and the specific tasks of different users. Whether managing the hatchery, tracking feed inventory, or overseeing farm operations, Jun & Jen’s Integrated Management System brings everything together in one place.
                </p>
                
                <div class="grid md:grid-cols-3 gap-8 mt-16">
                    <div class="p-6 bg-zinc-50 rounded-xl hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-emerald-100 text-emerald-600 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-lg mb-2">Farm Management</h3>
                        <p class="text-zinc-500 text-sm">Efficiently track and manage all farm activities and livestock.</p>
                    </div>
                    <div class="p-6 bg-zinc-50 rounded-xl hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-lg mb-2">Inventory Control</h3>
                        <p class="text-zinc-500 text-sm">Real-time tracking of feed, supplies, and equipment.</p>
                    </div>
                    <div class="p-6 bg-zinc-50 rounded-xl hover:shadow-lg transition-shadow">
                        <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-lg mb-2">Role-Based Access</h3>
                        <p class="text-zinc-500 text-sm">Secure access control tailored to specific user roles and tasks.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="py-20 bg-zinc-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-zinc-900 mb-4">Our Gallery</h2>
                <p class="text-zinc-600 max-w-2xl mx-auto">A glimpse into our daily operations and products.</p>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Using a loop for images p1 to p8 (skipping p7 as it wasn't listed, but p8 was) -->
                @foreach(['p1.jpeg', 'p2.jpeg', 'p3.jpeg', 'p4.jpeg', 'p5.jpeg', 'p6.jpeg', 'p8.jpeg'] as $image)
                    <div class="group relative aspect-square overflow-hidden rounded-xl bg-white shadow-md hover:shadow-xl transition-all">
                        <img src="{{ asset('images/' . $image) }}" alt="Gallery Image" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300"></div>
                    </div>
                @endforeach
                 <!-- Placeholder for the 8th slot to make the grid even if needed, or we can just leave it odd -->
                 <div class="group relative aspect-square overflow-hidden rounded-xl bg-emerald-100 flex items-center justify-center">
                    <span class="text-emerald-800 font-medium">More coming soon...</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-zinc-900 text-zinc-400 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8 mb-8">
                <div>
                    <span class="text-2xl font-bold text-white tracking-tight">Jun & Jen’s</span>
                    <p class="mt-4 text-sm">
                        Providing quality game farm and feed store management solutions.
                    </p>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#home" class="hover:text-emerald-400 transition-colors">Home</a></li>
                        <li><a href="#about" class="hover:text-emerald-400 transition-colors">About Us</a></li>
                        <li><a href="#gallery" class="hover:text-emerald-400 transition-colors">Gallery</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-4">Contact</h3>
                    <ul class="space-y-2 text-sm">
                        <li>Location: Your Farm Address</li>
                        <li>Email: info@junandjens.com</li>
                        <li>Phone: (123) 456-7890</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-zinc-800 pt-8 text-center text-sm">
                <p>&copy; {{ date('Y') }} Jun & Jen’s Game Farm and Feed Store. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
