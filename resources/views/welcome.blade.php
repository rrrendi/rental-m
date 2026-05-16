<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RENTAL-M | Solusi Kendaraan Anda</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800">

    <nav class="fixed top-0 left-0 right-0 bg-gray-900/40 backdrop-blur-md border-b border-white/10 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <div class="flex items-center">
                    <span class="text-3xl font-extrabold text-[#00c0ef] tracking-wide drop-shadow-sm"># RENTAL-M</span>
                </div>
                <div class="flex items-center space-x-6">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-white hover:text-[#00c0ef] transition-colors drop-shadow">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium text-white hover:text-[#00c0ef] transition-colors drop-shadow">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-[#00c0ef] hover:bg-cyan-500 text-white px-5 py-2.5 rounded-full text-sm font-semibold transition-colors shadow-md">Sign Up</a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="relative bg-gray-900 overflow-hidden h-[650px] flex items-center pt-20">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&q=80&w=2066" alt="Aesthetic Dark Car" class="w-full h-full object-cover object-center transform scale-105">
            <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-gray-900/70 to-transparent"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="max-w-2xl">
                <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl drop-shadow-lg">
                    <span class="block mb-2">Sewa Mobil Mudah,</span>
                    <span class="block text-[#00c0ef]">Cepat & Aman</span>
                </h1>
                <p class="mt-4 text-base text-gray-300 sm:text-lg md:text-xl drop-shadow-md font-light tracking-wide">
                    Temukan kendaraan terbaik untuk perjalanan dinas, liburan keluarga, atau operasional harian. Tersedia berbagai pilihan armada dengan harga transparan dan layanan profesional.
                </p>
                <div class="mt-8 sm:flex">
                    <a href="#katalog" class="flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-full text-white bg-[#00c0ef] hover:bg-cyan-500 transition-all shadow-lg hover:shadow-cyan-500/50 md:py-4 md:text-lg md:px-10">
                        Lihat Armada
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div id="katalog" class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900">Katalog Kendaraan</h2>
                <p class="mt-4 max-w-2xl text-xl text-gray-500 mx-auto">Pilih mobil yang sesuai dengan kebutuhan perjalanan yang direncanakan.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($cars as $car)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="h-48 bg-gray-100 flex items-center justify-center p-4 relative overflow-hidden">
                        @if($car->foto)
                            <img src="{{ asset('storage/' . $car->foto) }}" alt="{{ $car->merk }}" class="max-h-full object-contain transition-transform duration-500 hover:scale-110">
                        @else
                            <span class="text-gray-400 italic">Gambar tidak tersedia</span>
                        @endif
                    </div>
                    
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">{{ $car->merk }}</h3>
                                <p class="text-sm text-gray-500 uppercase tracking-wider mt-1">{{ $car->jenis }}</p>
                            </div>
                            <span class="bg-[#f0f8ff] text-[#00c0ef] text-xs font-bold px-3 py-1.5 rounded-md border border-cyan-100">{{ $car->no_polisi }}</span>
                        </div>
                        
                        <div class="mt-6 flex items-center justify-between border-t border-gray-100 pt-4">
                            <div>
                                <span class="text-lg font-bold text-gray-900">Rp {{ number_format($car->harga, 0, ',', '.') }}</span>
                                <span class="text-sm text-gray-500 font-normal">/hari</span>
                            </div>
                            
                            <a href="{{ route('login') }}" class="bg-gray-900 hover:bg-gray-800 text-white px-5 py-2 rounded-lg text-sm font-medium transition-colors shadow-sm">
                                Sewa
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($cars->isEmpty())
            <div class="text-center py-16 bg-white rounded-2xl border border-gray-100 border-dashed">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum Ada Armada</h3>
                <p class="mt-1 text-sm text-gray-500">Katalog mobil sedang dalam tahap pembaruan.</p>
            </div>
            @endif
        </div>
    </div>

    <footer class="bg-white border-t border-gray-200">
        <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <span class="text-xl font-extrabold text-[#00c0ef] tracking-wide"># RENTAL-M</span>
                    <p class="text-sm text-gray-500 mt-1">Sistem Layanan Penyewaan Kendaraan Modern.</p>
                </div>
                <p class="text-sm text-gray-500 text-center md:text-right">
                    &copy; 2026 STMIK Mardira Indonesia. Kelompok 2.
                </p>
            </div>
        </div>
    </footer>

</body>
</html>