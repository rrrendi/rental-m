<x-app-layout>
    <div class="max-w-3xl mx-auto bg-gray-800 border border-gray-700 rounded-xl shadow-lg overflow-hidden">
        <div class="p-6 border-b border-gray-700 flex justify-between items-center">
            <h2 class="text-xl font-bold text-white">Edit Data Mobil</h2>
            <a href="{{ route('cars.index') }}" class="text-cyan-400 hover:text-cyan-300 text-sm font-medium transition-colors">
                &larr; Kembali
            </a>
        </div>

        <div class="p-6">
            <form action="{{ route('cars.update', $car->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="block text-sm text-gray-400 mb-1">No Polisi</label>
                    <input type="text" name="no_polisi" value="{{ $car->no_polisi }}" class="w-full bg-gray-900 border-gray-700 text-white rounded-lg focus:ring-cyan-500 focus:border-cyan-500">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Merk</label>
                    <input type="text" name="merk" value="{{ $car->merk }}" class="w-full bg-gray-900 border-gray-700 text-white rounded-lg focus:ring-cyan-500 focus:border-cyan-500">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Jenis</label>
                    <input type="text" name="jenis" value="{{ $car->jenis }}" class="w-full bg-gray-900 border-gray-700 text-white rounded-lg focus:ring-cyan-500 focus:border-cyan-500">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Harga Sewa</label>
                    <input type="number" name="harga" value="{{ $car->harga }}" class="w-full bg-gray-900 border-gray-700 text-white rounded-lg focus:ring-cyan-500 focus:border-cyan-500">
                </div>
                <div class="col-span-1 md:col-span-2">
                    <label class="block text-sm text-gray-400 mb-1">Foto Mobil (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="file" name="foto" class="w-full text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:bg-cyan-600 file:text-white hover:file:bg-cyan-500">
                    
                    @if($car->foto)
                        <div class="mt-3">
                            <p class="text-xs text-gray-500 mb-1">Foto saat ini:</p>
                            <img src="{{ asset('storage/' . $car->foto) }}" alt="Foto Mobil" class="h-32 object-cover rounded border border-gray-600">
                        </div>
                    @endif
                </div>
                <div class="col-span-1 md:col-span-2 flex justify-end mt-4">
                    <button type="submit" class="px-6 py-2 bg-cyan-600 hover:bg-cyan-500 text-white font-medium rounded-lg transition-colors">
                        Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>