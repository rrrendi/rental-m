<x-app-layout>
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-bold text-gray-800">Laporan Transaksi Selesai</h2>
                <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-2 rounded-lg text-sm font-bold">
                    Total Pendapatan: Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="py-3 px-4 font-bold text-gray-700">No</th>
                            <th class="py-3 px-4 font-bold text-gray-700">Penyewa</th>
                            <th class="py-3 px-4 font-bold text-gray-700">Mobil</th>
                            <th class="py-3 px-4 font-bold text-gray-700">Durasi Sewa</th>
                            <th class="py-3 px-4 font-bold text-gray-700">Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $index => $rep)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-4">{{ $index + 1 }}</td>
                            <td class="py-4 px-4">{{ $rep->user->name }}</td>
                            <td class="py-4 px-4">{{ $rep->car->merk }} ({{ $rep->car->no_polisi }})</td>
                            <td class="py-4 px-4">{{ \Carbon\Carbon::parse($rep->tanggal_sewa)->diffInDays(\Carbon\Carbon::parse($rep->tanggal_kembali)) ?: 1 }} Hari</td>
                            <td class="py-4 px-4 font-medium text-gray-800">Rp {{ number_format($rep->total_harga, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-8 text-center text-gray-500">Belum ada transaksi yang diselesaikan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>