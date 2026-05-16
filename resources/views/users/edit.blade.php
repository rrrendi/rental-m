<x-app-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                    <h2 class="text-lg font-bold text-gray-800">Edit Data User</h2>
                    <a href="{{ route('users.index') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium transition-colors">
                        Kembali
                    </a>
                </div>

                <form action="{{ route('users.update', $user->id) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')
                    
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
                            <label class="block text-sm font-medium text-gray-600 mb-1">Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full bg-white border-gray-300 rounded-md shadow-sm focus:ring-[#0098f0] focus:border-[#0098f0] text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full bg-white border-gray-300 rounded-md shadow-sm focus:ring-[#0098f0] focus:border-[#0098f0] text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Role</label>
                            <select name="role" class="w-full bg-white border-gray-300 rounded-md shadow-sm focus:ring-[#0098f0] focus:border-[#0098f0] text-sm">
                                <option value="admin" {{ (old('role', $user->role) == 'admin') ? 'selected' : '' }}>Admin</option>
                                <option value="user" {{ (old('role', $user->role) == 'user') ? 'selected' : '' }}>User</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Password Baru <span class="text-xs text-gray-400 font-normal">(Kosongkan jika tidak ingin mengubah)</span></label>
                            <input type="password" name="password" class="w-full bg-white border-gray-300 rounded-md shadow-sm focus:ring-[#0098f0] focus:border-[#0098f0] text-sm">
                        </div>
                    </div>

                    <div class="flex justify-end gap-2 mt-6 pt-4 border-t border-gray-100">
                        <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 hover:bg-gray-300 rounded-md text-sm transition-colors">
                            Batal
                        </a>
                        <button type="submit" class="px-4 py-2 bg-[#00c0ef] hover:bg-cyan-500 text-white rounded-md text-sm shadow-sm transition-colors">
                            Update Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>