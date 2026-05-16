<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(auth()->user()->role == 'admin')
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Total Transaksi</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalTransactions }}</h3>
                        </div>
                        <div class="p-3 rounded-full bg-blue-50 text-[#0098f0]">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Jumlah Mobil</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalCars }}</h3>
                        </div>
                        <div class="p-3 rounded-full bg-cyan-50 text-[#00c0ef]">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                        </div>
                    </div>
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">Jumlah Users</p>
                            <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalUsers }}</h3>
                        </div>
                        <div class="p-3 rounded-full bg-purple-50 text-purple-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg border border-gray-100 text-gray-600 shadow-sm">
                    Selamat datang kembali, <strong class="text-gray-800">{{ auth()->user()->name }}</strong>. Gunakan sidebar menu untuk mengelola data sistem.
                </div>

            @else
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-gray-800">Katalog Armada Mobil Tersedia</h2>
                    <p class="text-sm text-gray-500">Pilih armada terbaik yang siap menemani perjalanan Anda hari ini.</p>
                </div>

                @if($cars->isEmpty())
                    <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-6 rounded-md text-center shadow-sm">
                        Maaf, saat ini seluruh armada mobil kami sedang disewa atau tidak tersedia. Silakan cek kembali nanti!
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($cars as $car)
                            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
                                <div class="h-48 bg-gray-50 border-b border-gray-100 flex items-center justify-center p-4">
                                    @if($car->foto)
                                        <img src="{{ asset('storage/' . $car->foto) }}" alt="{{ $car->merk }}" class="max-h-full max-w-full object-contain">
                                    @else
                                        <span class="text-xs text-gray-400">Tidak ada gambar</span>
                                    @endif
                                </div>
                                <div class="p-5 flex-grow">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="font-bold text-gray-800 text-lg capitalize">{{ $car->merk }}</h3>
                                        <span class="bg-cyan-50 text-[#00c0ef] text-xs font-semibold px-2 py-0.5 rounded capitalize">{{ $car->jenis }}</span>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-400 tracking-wider mb-4">{{ $car->no_polisi }}</p>
                                    <div class="border-t border-gray-50 pt-4 flex justify-between items-center">
                                        <div>
                                            <p class="text-xs text-gray-400">Harga Sewa / Hari</p>
                                            <p class="text-base font-black text-gray-800">Rp{{ number_format($car->harga, 0, ',', '.') }}</p>
                                        </div>
                                        <button onclick="openSewaModal('{{ $car->id }}', '{{ $car->merk }}', '{{ $car->harga }}')" class="bg-[#0098f0] hover:bg-blue-600 text-white px-4 py-2 rounded text-sm font-medium transition-colors shadow-sm">
                                            Sewa Sekarang
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div id="sewaModal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 z-50 items-center justify-center p-4">
                    <div class="bg-white rounded-lg shadow-xl border border-gray-200 max-w-md w-full overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                            <h3 class="text-base font-bold text-gray-800">Formulir Penyewaan <span id="modalCarName" class="text-[#0098f0]"></span></h3>
                            <button type="button" onclick="closeSewaModal()" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>

                        <form action="{{ route('transactions.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                            @csrf
                            <input type="hidden" name="car_id" id="modalCarId">

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-1">Tanggal Mulai Pinjam</label>
                                    <input type="date" name="tanggal_pinjam" id="modalTanggalPinjam" required class="w-full bg-white border-gray-300 rounded-md shadow-sm focus:ring-[#0098f0] focus:border-[#0098f0] text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-1">Tanggal Pengembalian</label>
                                    <input type="date" name="tanggal_kembali" id="modalTanggalKembali" required class="w-full bg-white border-gray-300 rounded-md shadow-sm focus:ring-[#0098f0] focus:border-[#0098f0] text-sm">
                                </div>
                                
                                <div id="liveTotalHarga" class="hidden bg-gray-50 border border-gray-200 rounded-md p-4 text-sm text-gray-700">
                                    <span class="block text-xs text-gray-400 font-medium">Estimasi Biaya Sewa:</span>
                                    <strong class="text-lg font-black text-gray-800" id="calculatedPrice">Rp0</strong> 
                                    <span class="text-xs text-gray-500 block mt-0.5">(Durasi: <span id="calculatedDays" class="font-bold">0</span> Hari)</span>
                                </div>
                                
                                <div class="bg-blue-50 border border-blue-100 rounded-md p-4 text-xs text-gray-700">
                                    <strong class="text-gray-800 block mb-1">Informasi Rekening Pembayaran:</strong>
                                    <p>Silakan transfer total biaya sewa ke nomor rekening berikut:</p>
                                    <p class="font-bold text-sm text-[#0098f0] mt-1">Bank BCA: 123-45678-90 <br>a.n RENTAL-M INDONESIA</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-600 mb-1">Unggah Bukti Transaksi Pembayaran</label>
                                    <input type="file" name="bukti_pembayaran" required class="w-full bg-white border-gray-300 rounded-md shadow-sm focus:ring-[#0098f0] focus:border-[#0098f0] text-sm">
                                </div>
                            </div>

                            <div class="flex justify-end gap-2 mt-6 pt-4 border-t border-gray-100">
                                <button type="button" onclick="closeSewaModal()" class="px-4 py-2 bg-gray-200 text-gray-700 hover:bg-gray-300 rounded-md text-sm transition-colors">
                                    Batal
                                </button>
                                <button type="submit" class="px-4 py-2 bg-[#0098f0] hover:bg-blue-600 text-white rounded-md text-sm shadow-sm transition-colors font-semibold">
                                    Kirim & Ajukan Sewa
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <script>
                    let hargaPerHari = 0;

                    function openSewaModal(id, name, harga) {
                        hargaPerHari = parseFloat(harga);
                        document.getElementById('modalCarId').value = id;
                        document.getElementById('modalCarName').innerText = '- ' + name;
                        document.getElementById('sewaModal').classList.remove('hidden');
                        document.getElementById('sewaModal').classList.add('flex');
                        hitungTotalHarga();
                    }

                    function closeSewaModal() {
                        document.getElementById('sewaModal').classList.add('hidden');
                        document.getElementById('sewaModal').classList.remove('flex');
                    }

                    function hitungTotalHarga() {
                        const tglPinjamVal = document.getElementById('modalTanggalPinjam').value;
                        const tglKembaliVal = document.getElementById('modalTanggalKembali').value;
                        const livePriceDiv = document.getElementById('liveTotalHarga');
                        const calculatedPriceSpan = document.getElementById('calculatedPrice');
                        const calculatedDaysSpan = document.getElementById('calculatedDays');

                        if (tglPinjamVal && tglKembaliVal) {
                            const tglPinjam = new Date(tglPinjamVal);
                            const tglKembali = new Date(tglKembaliVal);
                            
                            if (tglKembali >= tglPinjam) {
                                const diffTime = Math.abs(tglKembali - tglPinjam);
                                let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                                
                                if (diffDays === 0) diffDays = 1;

                                const totalHarga = diffDays * hargaPerHari;

                                const formatter = new Intl.NumberFormat('id-ID', {
                                    style: 'currency',
                                    currency: 'IDR',
                                    minimumFractionDigits: 0
                                });

                                calculatedPriceSpan.innerText = formatter.format(totalHarga);
                                calculatedDaysSpan.innerText = diffDays;
                                livePriceDiv.classList.remove('hidden');
                            } else {
                                livePriceDiv.classList.add('hidden');
                            }
                        } else {
                            livePriceDiv.classList.add('hidden');
                        }
                    }

                    document.getElementById('modalTanggalPinjam').addEventListener('change', hitungTotalHarga);
                    document.getElementById('modalTanggalKembali').addEventListener('change', hitungTotalHarga);
                </script>
            @endif

        </div>
    </div>
</x-app-layout>