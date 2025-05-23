@extends('layouts.app')

@section('title', 'Data Karyawan')

@section('content')
<div class="mb-4">
    <h1 class="text-2xl font-semibold"><i class="fas fa-users"></i> Data Karyawan</h1>
    <nav aria-label="breadcrumb">
        <ol class="flex text-gray-500">
            <li><a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a></li>
            <li class="mx-2">/</li>
            <li class="font-medium">Data Karyawan</li>
        </ol>
    </nav>
</div>

<div class="bg-white shadow-md rounded-lg mb-4">
    <div class="p-6">
        <a href="{{ route('admin.karyawan.create') }}" class="bg-blue-600 text-white px-4 py-2 mb-4 rounded-md hover:bg-blue-700">
            <i class="fas fa-user-plus"></i> Tambah Karyawan
        </a>

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2 border border-gray-300">No</th>
                        <th class="px-4 py-2 border border-gray-300">Nama Karyawan</th>
                        <th class="px-4 py-2 border border-gray-300">NIK</th>
                        <th class="px-4 py-2 border border-gray-300">Posisi</th>
                        <th class="px-4 py-2 border border-gray-300">Gaji Pokok</th>
                        <th class="px-4 py-2 border border-gray-300">Tanggal Masuk</th>
                        <th class="px-4 py-2 border border-gray-300">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($karyawans as $karyawan)
                    <tr class="border-b border-gray-300">
                        <td class="px-4 py-2 border border-gray-300">{{ $loop->iteration + $karyawans->firstItem() - 1 }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $karyawan->user->name }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $karyawan->nik }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $karyawan->posisi }}</td>
                        <td class="px-4 py-2 border border-gray-300">Rp {{ number_format($karyawan->gaji_pokok, 0, ',', '.') }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $karyawan->tanggal_masuk->format('d/m/Y') }}</td>
                        <td class="px-4 py-2 border border-gray-300">
                            <a href="{{ route('admin.karyawan.show', $karyawan) }}" class="bg-green-600 text-white px-2 py-1 rounded hover:bg-green-700" title="Detail Karyawan">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.karyawan.edit', $karyawan) }}" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600" title="Edit Karyawan">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center px-4 py-2">Tidak ada data karyawan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $karyawans->links() }}
        </div>
    </div>
</div>
@endsection