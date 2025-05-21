@extends('layouts.app')

@section('title', 'Edit Absensi')

@section('content')
<div class="mb-4">
    <h1 class="text-2xl font-semibold"><i class="fas fa-calendar-edit"></i> Edit Absensi</h1>
    <nav aria-label="breadcrumb">
        <ol class="list-reset flex text-gray-500">
            <li><a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a></li>
            <li class="mx-2">/</li>
            <li><a href="{{ route('admin.absensi.rekap') }}" class="text-blue-600 hover:underline">Rekap Absensi</a></li>
            <li class="mx-2">/</li>
            <li class="font-medium">Edit Absensi</li>
        </ol>
    </nav>
</div>

<div class="bg-white shadow-md rounded-lg">
    <div class="p-6">
        <form action="{{ route('admin.absensi.update', $absensi) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Karyawan</label>
                    <input type="text" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" value="{{ $absensi->karyawan->user->name }}" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">NIK</label>
                    <input type="text" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" value="{{ $absensi->karyawan->nik }}" readonly>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal <span class="text-red-500">*</span></label>
                    <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', $absensi->tanggal->format('Y-m-d')) }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md @error('tanggal') border-red-500 @enderror" required>
                    @error('tanggal')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="jam_masuk" class="block text-sm font-medium text-gray-700">Jam Masuk</label>
                    <input type="time" id="jam_masuk" name="jam_masuk" value="{{ old('jam_masuk', $absensi->jam_masuk) }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md @error('jam_masuk') border-red-500 @enderror">
                    @error('jam_masuk')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <label for="jam_pulang" class="block text-sm font-medium text-gray-700">Jam Pulang</label>
                    <input type="time" id="jam_pulang" name="jam_pulang" value="{{ old('jam_pulang', $absensi->jam_pulang) }}" class="mt-1 block w-full p-2 border border-gray-300 rounded-md @error('jam_pulang') border-red-500 @enderror">
                    @error('jam_pulang')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status <span class="text-red-500">*</span></label>
                <select name="status" id="status" class="mt-1 block w-full p-2 border border-gray-300 rounded-md @error('status') border-red-500 @enderror" required>
                    <option value="hadir" {{ old('status', $absensi->status) == 'hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="izin" {{ old('status', $absensi->status) == 'izin' ? 'selected' : '' }}>Izin</option>
                    <option value="sakit" {{ old('status', $absensi->status) == 'sakit' ? 'selected' : '' }}>Sakit</option>
                    <option value="tanpa keterangan" {{ old('status', $absensi->status) == 'tanpa keterangan' ? 'selected' : '' }}>Tanpa Keterangan</option>
                </select>
                @error('status')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan</label>
                <textarea id="keterangan" name="keterangan" rows="3" class="mt-1 block w-full p-2 border border-gray-300 rounded-md @error('keterangan') border-red-500 @enderror">{{ old('keterangan', $absensi->keterangan) }}</textarea>
                @error('keterangan')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('admin.absensi.rekap') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Kembali</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection