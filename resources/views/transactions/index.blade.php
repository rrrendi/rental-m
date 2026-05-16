<x-app-layout>
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-bold text-gray-800">Data Transaksi</h2>
                <button onclick="document.getElementById('formTransactionModal').classList.remove('hidden'); document.getElementById('formTransactionModal').classList.add('flex')" class="bg-[#0098f0] hover:bg-blue-600 text-white px-5 py-2 rounded text-sm font-medium shadow-sm transition-colors">
                    Tambah Transaksi
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="py-3 px-4 font-bold text-gray-700">No</th>
                            <th class="py-3 px-4 font-bold text-gray-700">Penyewa</th>
                            <th class="py-3 px-4 font-bold text-gray-700">Mobil</th>
                            <th class="py-3 px-4 font-bold text-gray-700">Tgl Sewa</th>
                            <th class="py-3 px-4 font-bold text-gray-700">Tgl Kembali</th>
                            <th class="py-3 px-4 font-bold text-gray-700">Status</th>
                            <th class="py-3 px-4 font-bold text-gray-700 w-40 text-center">Proses</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $index => $trx)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-4">{{ $index + 1 }}</td>
                            <td class="py-4 px-4 font-medium text-gray-800">{{ $trx->user->name }}</td>
                            <td class="py-4 px-4">{{ $trx->car->merk }} ({{ $trx->car->no_polisi }})</td>
                            <td class="py-4 px-4">{{ $trx->tanggal_sewa }}</td>
                            <td class="py-4 px-4">{{ $trx->tanggal_kembali }}</td>
                            <td class="py-4 px-4">
                                @if($trx->status == 'aktif')
                                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-medium">Aktif</span>
                                @else
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-medium">Selesai</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 flex justify-center space-x-1">
                                @if($trx->status == 'aktif')
                                <form action="{{ route('transactions.complete', $trx->id) }}" method="POST" class="inline">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1.5 rounded text-xs shadow-sm transition-colors" onclick="return confirm('Selesaikan transaksi ini?')">Selesai</button>
                                </form>
                                @endif
                                <form action="{{ route('transactions.destroy', $trx->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="bg-[#dd4b39] text-white px-3 py-1.5 rounded text-xs shadow-sm hover:bg-red-600" onclick="return confirm('Hapus transaksi ini?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div id="formTransactionModal" class="{{ $errors->any() ? 'flex' : 'hidden' }} fixed inset-0 bg-gray-900 bg-opacity-50 z-50 items-center justify-center p-4 transition-all duration-300">
                <div class="bg-white rounded-lg shadow-xl border border-gray-200 max-w-md w-full overflow-hidden transform transition-all">
                    
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                        <h3 class="text-base font-bold text-gray-800">Tambah Transaksi Baru</h3>
                        <button type="button" onclick="document.getElementById('formTransactionModal').classList.add('hidden'); document.getElementById('formTransactionModal').classList.remove('flex')" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form action="{{ route('transactions.store') }}" method="POST" class="p-6">
                        @csrf
                        
                        @if($errors->any())
                            <div class="mb-4 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-md text-sm">
                                <strong class="font-bold block mb-1">Gagal menyimpan data!</strong>
                                <ul class="list-disc list-inside text-xs space-y-0.5">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Penyewa</label>
                                <select name="user_id" required class="w-full bg-white border-gray-300 rounded-md shadow-sm focus:ring-[#0098f0] focus:border-[#0098f0] text-sm">
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Mobil</label>
                                <select name="car_id" required class="w-full bg-white border-gray-300 rounded-md shadow-sm focus:ring-[#0098f0] focus:border-[#0098f0] text-sm">
                                    @foreach($cars as $car)
                                        <option value="{{ $car->id }}" {{ old('car_id') == $car->id ? 'selected' : '' }}>{{ $car->merk }} - {{ $car->no_polisi }} (Rp {{ number_format($car->harga, 0, ',', '.') }}/hari)</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Tanggal Sewa</label>
                                <input type="date" name="tanggal_sewa" value="{{ old('tanggal_sewa') }}" required class="w-full bg-white border-gray-300 rounded-md shadow-sm focus:ring-[#0098f0] focus:border-[#0098f0] text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Tanggal Kembali (Estimasi)</label>
                                <input type="date" name="tanggal_kembali" value="{{ old('tanggal_kembali') }}" required class="w-full bg-white border-gray-300 rounded-md shadow-sm focus:ring-[#0098f0] focus:border-[#0098f0] text-sm">
                            </div>
                        </div>

                        <div class="flex justify-end gap-2 mt-6 pt-4 border-t border-gray-100">
                            <button type="button" onclick="document.getElementById('formTransactionModal').classList.add('hidden'); document.getElementById('formTransactionModal').classList.remove('flex')" class="px-4 py-2 bg-gray-200 text-gray-700 hover:bg-gray-300 rounded-md text-sm transition-colors">
                                Batal
                            </button>
                            <button type="submit" class="px-4 py-2 bg-[#0098f0] hover:bg-blue-600 text-white rounded-md text-sm shadow-sm transition-colors">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>