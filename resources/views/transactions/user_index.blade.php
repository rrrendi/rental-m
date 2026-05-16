<x-app-layout>
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-6">Riwayat Pemesanan Saya</h2>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="py-3 px-4 font-bold text-gray-700">No</th>
                            <th class="py-3 px-4 font-bold text-gray-700">Mobil</th>
                            <th class="py-3 px-4 font-bold text-gray-700">No Polisi</th>
                            <th class="py-3 px-4 font-bold text-gray-700">Tanggal Sewa</th>
                            <th class="py-3 px-4 font-bold text-gray-700">Tanggal Kembali</th>
                            <th class="py-3 px-4 font-bold text-gray-700">Status Konfirmasi</th>
                            <th class="py-3 px-4 font-bold text-gray-700">Total Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $index => $trx)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-4">{{ $index + 1 }}</td>
                            <td class="py-4 px-4 font-medium text-gray-800">{{ $trx->car->merk }}</td>
                            <td class="py-4 px-4 uppercase">{{ $trx->car->no_polisi }}</td>
                            <td class="py-4 px-4">{{ $trx->tanggal_sewa }}</td>
                            <td class="py-4 px-4">{{ $trx->tanggal_kembali }}</td>
                            <td class="py-4 px-4">
                                @if($trx->status == 'pending')
                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded animate-pulse">Menunggu Persetujuan</span>
                                @elseif($trx->status == 'aktif')
                                    <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-2.5 py-0.5 rounded">Sedang Digunakan</span>
                                @else
                                    <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded">Selesai</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 font-bold text-gray-800">
                                @if($trx->total_harga)
                                    Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                                @else
                                    <span class="text-gray-400 font-normal text-xs">Akan dihitung saat kembali</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-gray-400 italic">Anda belum pernah melakukan transaksi pemesanan mobil.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>