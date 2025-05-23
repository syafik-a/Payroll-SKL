@extends('layouts.app')

@section('title', 'Tambah Karyawan')

@section('content')
<div class="mb-4">
    <h1 class="text-2xl font-semibold"><i class="fas fa-user-plus"></i> Tambah Karyawan</h1>
    <nav aria-label="breadcrumb">
        <ol class="flex text-gray-500">
            <li><a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a></li>
            <li class="mx-2">/</li>
            <li><a href="{{ route('admin.karyawan.index') }}" class="text-blue-600 hover:underline">Data Karyawan</a></li>
            <li class="mx-2">/</li>
            <li class="font-medium">Tambah Karyawan</li>
        </ol>
    </nav>
</div>

<div class="bg-white shadow-md rounded-lg">
    <div class="p-6">
        <form action="{{ route('admin.karyawan.store') }}" method="POST">
            @csrf
            
            <h5 class="mb-3">Data User</h5>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" class="mt-1 block w-full p-2 border border-gray-300 rounded-md @error('name') border-red-500 @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                    <input type="email" class="mt-1 block w-full p-2 border border-gray-300 rounded-md @error('email') border-red-500 @enderror" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password <span class="text-red-500">*</span></label>
                    <input type="password" class="mt-1 block w-full p-2 border border-gray-300 rounded-md @error('password') border-red-500 @enderror" id="password" name="password" required>
                    @error('password')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password <span class="text-red-500">*</span></label>
                    <input type="password" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" id="password_confirmation" name="password_confirmation" required>
                </div>
            </div>

            <hr class="my-6">

            <h5 class="mb-3">Data Karyawan</h5>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="nik" class="block text-sm font-medium text-gray-700">NIK <span class="text-red-500">*</span></label>
                    <input type="text" class="mt-1 block w-full p-2 border border-gray-300 rounded-md @error('nik') border-red-500 @enderror" id="nik" name="nik" value="{{ old('nik') }}" required>
                    @error('nik')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="no_telepon" class="block text-sm font-medium text-gray-700">No. Telepon</label>
                    <input type="text" class="mt-1 block w-full p-2 border border-gray-300 rounded-md @error('no_telepon') border-red-500 @enderror" id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}">
                    @error('no_telepon')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea class="mt-1 block w-full p-2 border border-gray-300 rounded-md @error('alamat') border-red-500 @enderror" id="alamat" name="alamat" rows="3">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="posisi" class="block text-sm font-medium text-gray-700">Posisi <span class="text-red-500">*</span></label>
                    <input type="text" class="mt-1 block w-full p-2 border border-gray-300 rounded-md @error('posisi') border-red-500 @enderror" id="posisi" name="posisi" value="{{ old('posisi') }}" required>
                    @error('posisi')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="tanggal_masuk" class="block text-sm font-medium text-gray-700">Tanggal Masuk <span class="text-red-500">*</span></label>
                    <input type="date" class="mt-1 block w-full p-2 border border-gray-300 rounded-md @error('tanggal_masuk') border-red-500 @enderror" id="tanggal_masuk" name="tanggal_masuk" value="{{ old('tanggal_masuk') }}" required>
                    @error('tanggal_masuk')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="gaji_pokok" class="block text-sm font-medium text-gray-700">Gaji Pokok <span class="text-red-500">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="mt-1 block w-full p-2 border border-gray-300 rounded-md @error('gaji_pokok') border-red-500 @enderror" id="gaji_pokok" name="gaji_pokok" value="{{ old('gaji_pokok') }}" min="0" step="1000" required>
                    </div>
                    @error('gaji_pokok')
                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.karyawan.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Kembali</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection