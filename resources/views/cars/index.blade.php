<x-app-layout>
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-bold text-gray-800">Data Mobil</h2>
                <button onclick="document.getElementById('formCarModal').classList.remove('hidden'); document.getElementById('formCarModal').classList.add('flex')" class="bg-[#0098f0] hover:bg-blue-600 text-white px-5 py-2 rounded text-sm font-medium shadow-sm transition-colors">
                    Tambah Mobil
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="py-3 px-4 font-bold text-gray-700">No</th>
                            <th class="py-3 px-4 font-bold text-gray-700">No Polisi</th>
                            <th class="py-3 px-4 font-bold text-gray-700">Merk</th>
                            <th class="py-3 px-4 font-bold text-gray-700">Jenis</th>
                            <th class="py-3 px-4 font-bold text-gray-700">Harga</th>
                            <th class="py-3 px-4 font-bold text-gray-700">Foto</th>
                            <th class="py-3 px-4 font-bold text-gray-700 w-32">Proses</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cars as $index => $car)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-4">{{ $index + 1 }}</td>
                            <td class="py-4 px-4 font-medium text-gray-800">{{ $car->no_polisi }}</td>
                            <td class="py-4 px-4">{{ $car->merk }}</td>
                            <td class="py-4 px-4 uppercase">{{ $car->jenis }}</td>
                            <td class="py-4 px-4">Rp {{ number_format($car->harga, 0, ',', '.') }}</td>
                            <td class="py-4 px-4">
                                @if($car->foto)
                                    <img src="{{ asset('storage/' . $car->foto) }}" alt="Foto" class="w-24 h-auto object-contain">
                                @else
                                    <span class="text-gray-400 italic">No image</span>
                                @endif
                            </td>
                            <td class="py-4 px-4 flex space-x-1">
                                <a href="{{ route('cars.edit', $car->id) }}" class="bg-[#00c0ef] text-white px-3 py-1.5 rounded text-xs shadow-sm hover:bg-cyan-500">Edit</a>
                                <form action="{{ route('cars.destroy', $car->id) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="bg-[#dd4b39] text-white px-3 py-1.5 rounded text-xs shadow-sm hover:bg-red-600" onclick="return confirm('Hapus data mobil ini?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div id="formCarModal" class="{{ $errors->any() ? 'flex' : 'hidden' }} fixed inset-0 bg-gray-900 bg-opacity-50 z-50 items-center justify-center p-4 transition-all duration-300">
                <div class="bg-white rounded-lg shadow-xl border border-gray-200 max-w-md w-full overflow-hidden transform transition-all">
                    
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                        <h3 class="text-base font-bold text-gray-800">Tambah Mobil Baru</h3>
                        <button type="button" onclick="document.getElementById('formCarModal').classList.add('hidden'); document.getElementById('formCarModal').classList.remove('flex')" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
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
                                <label class="block text-sm font-medium text-gray-600 mb-1">No Polisi</label>
                                <input type="text" name="no_polisi" value="{{ old('no_polisi') }}" required class="w-full bg-white border-gray-300 rounded-md shadow-sm focus:ring-[#0098f0] focus:border-[#0098f0] text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Merk</label>
                                <input type="text" name="merk" value="{{ old('merk') }}" required class="w-full bg-white border-gray-300 rounded-md shadow-sm focus:ring-[#0098f0] focus:border-[#0098f0] text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Jenis</label>
                                <input type="text" name="jenis" value="{{ old('jenis') }}" required class="w-full bg-white border-gray-300 rounded-md shadow-sm focus:ring-[#0098f0] focus:border-[#0098f0] text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Harga Sewa / Hari</label>
                                <input type="number" name="harga" value="{{ old('harga') }}" required class="w-full bg-white border-gray-300 rounded-md shadow-sm focus:ring-[#0098f0] focus:border-[#0098f0] text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Foto Mobil</label>
                                <input type="file" name="foto" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-[#0098f0] file:text-white hover:file:bg-blue-600">
                            </div>
                        </div>

                        <div class="flex justify-end gap-2 mt-6 pt-4 border-t border-gray-100">
                            <button type="button" onclick="document.getElementById('formCarModal').classList.add('hidden'); document.getElementById('formCarModal').classList.remove('flex')" class="px-4 py-2 bg-gray-200 text-gray-700 hover:bg-gray-300 rounded-md text-sm transition-colors">
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