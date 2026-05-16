<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'RENTAL-M') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#f4f6f9] text-gray-800 flex h-screen overflow-hidden">
    
    <aside class="w-[250px] bg-white border-r border-gray-200 flex flex-col justify-between shadow-sm z-20">
        <div>
            <div class="h-16 flex items-center px-6">
                <span class="text-2xl font-extrabold text-[#0098f0] tracking-wide"># RENTAL-M</span>
            </div>

            <div class="px-6 py-4 flex items-center space-x-3 mb-2">
                <div class="relative">
                    <img src="https://i.pravatar.cc/150?u={{ Auth::user()->email }}" alt="Avatar" class="w-10 h-10 rounded-full object-cover border border-gray-200">
                    <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
                </div>
                <div>
                    <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ Auth::user()->role }}</p>
                </div>
            </div>

            <nav class="mt-2 flex flex-col space-y-1">
                <a href="{{ route('dashboard') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('dashboard') ? 'border-l-4 border-[#0098f0] text-[#0098f0] bg-[#f0f8ff] w-[calc(100%-1rem)] rounded-r-full' : 'text-gray-600 hover:bg-gray-50 hover:text-[#0098f0]' }} transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    <span class="font-medium text-sm">Dashboard</span>
                </a>
                
                <a href="{{ route('transactions.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('transactions.*') ? 'border-l-4 border-[#0098f0] text-[#0098f0] bg-[#f0f8ff] w-[calc(100%-1rem)] rounded-r-full' : 'text-gray-600 hover:bg-gray-50 hover:text-[#0098f0]' }} transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span class="font-medium text-sm">Transaksi</span>
                </a>

                <a href="{{ route('reports.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('reports.*') ? 'border-l-4 border-[#0098f0] text-[#0098f0] bg-[#f0f8ff] w-[calc(100%-1rem)] rounded-r-full' : 'text-gray-600 hover:bg-gray-50 hover:text-[#0098f0]' }} transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span class="font-medium text-sm">Laporan Transaksi</span>
                </a>

                <a href="{{ route('cars.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('cars.*') ? 'border-l-4 border-[#0098f0] text-[#0098f0] bg-[#f0f8ff] w-[calc(100%-1rem)] rounded-r-full' : 'text-gray-600 hover:bg-gray-50 hover:text-[#0098f0]' }} transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                    <span class="font-medium text-sm">Mobil</span>
                </a>

                @if(Auth::user()->role === 'admin')
                <a href="{{ route('users.index') }}" class="flex items-center px-6 py-3 {{ request()->routeIs('users.*') ? 'border-l-4 border-[#0098f0] text-[#0098f0] bg-[#f0f8ff] w-[calc(100%-1rem)] rounded-r-full' : 'text-gray-600 hover:bg-gray-50 hover:text-[#0098f0]' }} transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span class="font-medium text-sm">Users</span>
                </a>
                @endif
            </nav>
        </div>
    </aside>

    <div class="flex-1 flex flex-col relative overflow-hidden">
        <header class="h-16 flex items-center justify-between px-6 bg-transparent">
            <button class="w-8 h-8 rounded flex items-center justify-center text-[#0098f0] hover:bg-white hover:shadow-sm transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
            </button>
            
            <div x-data="{ open: false }" class="relative z-50">
                <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none bg-transparent py-1 px-2 rounded-md hover:bg-white hover:shadow-sm transition-all">
                    <img src="https://i.pravatar.cc/150?u={{ Auth::user()->email }}" alt="Avatar" class="w-8 h-8 rounded-full object-cover border border-gray-200">
                    <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                    <svg class="w-4 h-4 text-gray-500 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                
                <div x-show="open" @click.away="open = false" x-transition.opacity class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 border border-gray-100" style="display: none;">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-[#dd4b39] transition-colors">
                            Sign out
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <main id="main-content" class="flex-1 overflow-y-auto p-6 relative scroll-smooth">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif
            
            {{ $slot }}
        </main>

        <div class="absolute bottom-6 right-6 z-40">
            <button onclick="document.getElementById('main-content').scrollTo({ top: 0, behavior: 'smooth' })" class="w-12 h-12 bg-[#00c0ef] rounded-full flex items-center justify-center text-white shadow-lg hover:bg-cyan-500 transition-all focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V5m-7 7l7-7 7 7"></path>
                </svg>
            </button>
        </div>
    </div>
</body>
</html>