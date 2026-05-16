<x-app-layout>
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6">
            
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md text-sm flex items-center gap-2 shadow-sm animate-fade-in">
                    <svg class="w-5 h-5 text-green-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <div class="mb-6">
                <h2 class="text-lg font-bold text-gray-800">Data Riwayat Transaksi</h2>
                <p class="text-xs text-gray-400 mt-0.5">Pantau dan kelola seluruh berkas pengajuan sewa masuk.</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="py-3 px-4 font-bold text-gray-700">No</th>
                            @if(auth()->user()->role == 'admin')
                                <th class="py-3 px-4 font-bold text-gray-700">Pelanggan</th>
                            @endif
                            <th class="py-3 px-4 font-bold text-gray-700">Mobil</th>
                            <th class="py-3 px-4 font-bold text-gray-700">Pinjam</th>
                            <th class="py-3 px-4 font-bold text-gray-700">Kembali</th>
                            <th class="py-3 px-4 font-bold text-gray-700">Total Harga</th>
                            <th class="py-3 px-4 font-bold text-gray-700">Bukti Bayar</th>
                            <th class="py-3 px-4 font-bold text-gray-700">Status</th>
                            <th class="py-3 px-4 font-bold text-gray-700 w-44">Proses</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $index => $tr)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-4">{{ $index + 1 }}</td>
                            @if(auth()->user()->role == 'admin')
                                <td class="py-4 px-4 font-medium text-gray-800">{{ $tr->user->name ?? 'User Terhapus' }}</td>
                            @endif
                            <td class="py-4 px-4 capitalize font-semibold">{{ $tr->car->merk ?? 'Mobil Terhapus' }}</td>
                            <td class="py-4 px-4">{{ $tr->tanggal_sewa }}</td>
                            <td class="py-4 px-4">{{ $tr->tanggal_kembali }}</td>
                            <td class="py-4 px-4 font-bold text-gray-800">Rp{{ number_format($tr->total_harga, 0, ',', '.') }}</td>
                            <td class="py-4 px-4">
                                @if($tr->bukti_pembayaran)
                                    <a href="{{ asset('storage/' . $tr->bukti_pembayaran) }}" target="_blank" class="text-[#0098f0] hover:underline text-xs font-bold flex items-center gap-1">
                                        Lihat Gambar ↗
                                    </a>
                                @else
                                    <span class="text-xs text-gray-400">Tidak ada</span>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                @if($tr->status == 'pending')
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-bold px-2.5 py-0.5 rounded capitalize">Pending</span>
                                @elseif($tr->status == 'disetujui')
                                    <span class="bg-green-100 text-green-800 text-xs font-bold px-2.5 py-0.5 rounded capitalize">Disetujui</span>
                                @elseif($tr->status == 'ditolak')
                                    <span class="bg-red-100 text-red-800 text-xs font-bold px-2.5 py-0.5 rounded capitalize">Ditolak</span>
                                @else
                                    <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-0.5 rounded capitalize">Selesai</span>
                                @endif
                            </td>
                            <td class="py-4 px-4">
                                @if(auth()->user()->role == 'admin')
                                    @if($tr->status == 'pending')
                                        <div class="flex space-x-1">
                                            <form action="{{ route('transactions.approve', $tr->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="bg-green-500 text-white px-2.5 py-1 rounded text-xs hover:bg-green-600 transition-colors">Setujui</button>
                                            </form>
                                            <form action="{{ route('transactions.reject', $tr->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="bg-red-500 text-white px-2.5 py-1 rounded text-xs hover:bg-red-600 transition-colors">Tolak</button>
                                            </form>
                                        </div>
                                    @elseif($tr->status == 'disetujui')
                                        <form action="{{ route('transactions.complete', $tr->id) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="bg-[#00c0ef] text-white px-3 py-1.5 rounded text-xs shadow-sm hover:bg-cyan-500 transition-colors w-full">Mobil Kembali</button>
                                        </form>
                                    @else
                                        <span class="text-xs text-gray-400 italic">Selesai diproses</span>
                                    @endif
                                @else
                                    @if($tr->status == 'pending')
                                        <span class="text-xs text-gray-500 italic">Menunggu konfirmasi...</span>
                                    @else
                                        <span class="text-xs text-gray-400 italic">Aksi ditutup</span>
                                    @endif
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>