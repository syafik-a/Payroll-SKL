@extends('layouts.app')

@section('title', 'Detail Karyawan')

@section('content')
<div class="mb-4">
    <h1 class="text-2xl font-semibold"><i class="fas fa-user"></i> Detail Karyawan</h1>
    <nav aria-label="breadcrumb">
        <ol class="flex text-gray-500">
            <li><a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a></li>
            <li class="mx-2">/</li>
            <li><a href="{{ route('admin.karyawan.index') }}" class="text-blue-600 hover:underline">Data Karyawan</a></li>
            <li class="mx-2">/</li>
            <li class="font-medium">Detail Karyawan</li>
        </ol>
    </nav>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h5 class="mb-4 text-lg font-semibold">Informasi Karyawan</h5>
        <table class="min-w-full">
            <tbody>
                <tr>
                    <th class="text-left">Nama Lengkap:</th>
                    <td>{{ $karyawan->user->name }}</td>
                </tr>
                <tr>
                    <th class="text-left">NIK:</th>
                    <td>{{ $karyawan->nik }}</td>
                </tr>
                <tr>
                    <th class="text-left">Email:</th>
                    <td>{{ $karyawan->user->email }}</td>
                </tr>
                <tr>
                    <th class="text-left">No. Telepon:</th>
                    <td>{{ $karyawan->no_telepon ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-left">Alamat:</th>
                    <td>{{ $karyawan->alamat ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-left">Posisi:</th>
                    <td>{{ $karyawan->posisi }}</td>
                </tr>
                <tr>
                    <th class="text-left">Tanggal Masuk:</th>
                    <td>{{ $karyawan->tanggal_masuk->format('d M Y') }}</td>
                </tr>
                <tr>
                    <th class="text-left">Gaji Pokok:</th>
                    <td>Rp {{ number_format($karyawan->gaji_pokok, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th class="text-left">Role:</th>
                    <td><span class="badge bg-info">{{ ucfirst($karyawan->user->role) }}</span></td>
                </tr>
            </tbody>
        </table>

        <div class="mt-4">
            <a href="{{ route('admin.karyawan.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="{{ route('admin.karyawan.edit', $karyawan) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <h5 class="mb-4 text-lg font-semibold">Statistik Absensi Bulan Ini</h5>
        @php
            $bulanIni = \App\Models\Absensi::where('karyawan_id', $karyawan->id)
                ->whereMonth('tanggal', date('m'))
                ->whereYear('tanggal', date('Y'))
                ->get();
        @endphp
        <ul class="list-disc list-inside">
            <li class="flex justify-between">
                Hadir: <span class="font-bold">{{ $bulanIni->where('status', 'hadir')->count() }}</span>
            </li>
            <li class="flex justify-between">
                Izin: <span class="font-bold">{{ $bulanIni->where('status', 'izin')->count() }}</span>
            </li>
            <li class="flex justify-between">
                Sakit: <span class="font-bold">{{ $bulanIni->where('status', 'sakit')->count() }}</span>
            </li>
            <li class="flex justify-between">
                Tanpa Keterangan: <span class="font-bold">{{ $bulanIni->where('status', 'tanpa keterangan')->count() }}</span>
            </li>
        </ul>
    </div>
</div>

<div class="bg-white shadow-md rounded-lg p-6">
    <h5 class="mb-4 text-lg font-semibold">Riwayat Absensi Terakhir</h5>
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 border border-gray-300">Tanggal</th>
                    <th class="px-4 py-2 border border-gray-300">Jam Masuk</th>
                    <th class="px-4 py-2 border border-gray-300">Jam Pulang</th>
                    <th class="px-4 py-2 border border-gray-300">Status</th>
                    <th class="px-4 py-2 border border-gray-300">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $riwayatAbsensi = \App\Models\Absensi::where('karyawan_id', $karyawan->id)
                        ->orderBy('tanggal', 'desc')
                        ->limit(10)
                        ->get();
                @endphp
                @forelse($riwayatAbsensi as $absensi)
                <tr class="border-b border-gray-300">
                    <td class="px-4 py-2 border border-gray-300">{{ $absensi->tanggal->format('d/m/Y') }}</td>
                    <td class="px-4 py-2 border border-gray-300">{{ $absensi->jam_masuk ?? '-' }}</td>
                    <td class="px-4 py-2 border border-gray-300">{{ $absensi->jam_pulang ?? '-' }}</td>
                    <td class="px-4 py-2 border border-gray-300">
                        <span class="bg-{{ $absensi->status == 'hadir' ? 'green' : ($absensi->status == 'izin' ? 'yellow' : 'red') }}-500 text-white rounded px-2 py-1">
                            {{ ucfirst($absensi->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-2 border border-gray-300">{{ $absensi->keterangan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center px-4 py-2">Belum ada riwayat absensi</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection