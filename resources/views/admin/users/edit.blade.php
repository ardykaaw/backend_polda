@extends('admin.layouts.app')

@section('title', 'Edit Pengguna')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">Edit Pengguna</h2>
                    <p class="mt-1 text-sm text-gray-600">Update informasi pengguna</p>
                </div>
                <a href="{{ route('admin.users') }}" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </a>
            </div>
        </div>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- NRP -->
                <div>
                    <label for="nrp" class="block text-sm font-medium text-gray-700">NRP</label>
                    <input type="text" 
                           name="nrp" 
                           id="nrp" 
                           value="{{ $user->nrp }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           required>
                </div>

                <!-- Nama -->
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" 
                           name="nama" 
                           id="nama" 
                           value="{{ $user->nama }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           required>
                </div>

                <!-- Password (Optional) -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Password Baru
                        <span class="text-sm text-gray-500">(kosongkan jika tidak ingin mengubah)</span>
                    </label>
                    <input type="password" 
                           name="password" 
                           id="password" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                        Konfirmasi Password Baru
                    </label>
                    <input type="password" 
                           name="password_confirmation" 
                           id="password_confirmation" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <!-- Pangkat -->
                <div>
                    <label for="pangkat" class="block text-sm font-medium text-gray-700">Pangkat</label>
                    <select name="pangkat" 
                            id="pangkat" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="BRIPDA" {{ $user->pangkat == 'BRIPDA' ? 'selected' : '' }}>BRIPDA</option>
                        <option value="BRIPTU" {{ $user->pangkat == 'BRIPTU' ? 'selected' : '' }}>BRIPTU</option>
                        <option value="BRIGADIR" {{ $user->pangkat == 'BRIGADIR' ? 'selected' : '' }}>BRIGADIR</option>
                        <option value="BRIPKA" {{ $user->pangkat == 'BRIPKA' ? 'selected' : '' }}>BRIPKA</option>
                    </select>
                </div>

                <!-- Divisi -->
                <div>
                    <label for="divisi" class="block text-sm font-medium text-gray-700">Divisi</label>
                    <select name="divisi" 
                            id="divisi" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="SATLANTAS" {{ $user->divisi == 'SATLANTAS' ? 'selected' : '' }}>SATLANTAS</option>
                        <!-- Tambahkan opsi divisi lainnya -->
                    </select>
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" 
                            id="status" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="1" {{ $user->status ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ !$user->status ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.users') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Batal
                </a>
                <button type="submit"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
