@extends('admin.layouts.app')

@section('title', 'Tambah Pengguna')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-6">
            <h2 class="text-xl font-semibold text-gray-800">Tambah Pengguna Baru</h2>
        </div>

        <form action="{{ route('admin.users.store') }}" method="POST" class="p-6 space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- NRP -->
                <div>
                    <label for="nrp" class="block text-sm font-medium text-gray-700">NRP</label>
                    <input type="text" name="nrp" id="nrp" value="{{ old('nrp') }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nrp') border-red-500 @enderror">
                    @error('nrp')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama -->
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nama') border-red-500 @enderror">
                    @error('nama')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pangkat -->
                <div>
                    <label for="pangkat" class="block text-sm font-medium text-gray-700">Pangkat</label>
                    <select name="pangkat" id="pangkat"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('pangkat') border-red-500 @enderror">
                        <option value="">Pilih Pangkat</option>
                        <option value="BRIPDA" {{ old('pangkat') == 'BRIPDA' ? 'selected' : '' }}>BRIPDA</option>
                        <option value="BRIPTU" {{ old('pangkat') == 'BRIPTU' ? 'selected' : '' }}>BRIPTU</option>
                        <option value="BRIGADIR" {{ old('pangkat') == 'BRIGADIR' ? 'selected' : '' }}>BRIGADIR</option>
                        <option value="IPDA" {{ old('pangkat') == 'IPDA' ? 'selected' : '' }}>IPDA</option>
                        <option value="IPTU" {{ old('pangkat') == 'IPTU' ? 'selected' : '' }}>IPTU</option>
                        <option value="AKP" {{ old('pangkat') == 'AKP' ? 'selected' : '' }}>AKP</option>
                    </select>
                    @error('pangkat')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Divisi -->
                <div>
                    <label for="divisi" class="block text-sm font-medium text-gray-700">Divisi</label>
                    <select name="divisi" id="divisi"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('divisi') border-red-500 @enderror">
                        <option value="">Pilih Divisi</option>
                        <option value="SATLANTAS" {{ old('divisi') == 'SATLANTAS' ? 'selected' : '' }}>SATLANTAS</option>
                    </select>
                    @error('divisi')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                    <select name="role" id="role"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('role') border-red-500 @enderror">
                        <option value="">Pilih Role</option>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-3 pt-6">
                <a href="{{ route('admin.users') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Batal
                </a>
                <button type="submit"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
