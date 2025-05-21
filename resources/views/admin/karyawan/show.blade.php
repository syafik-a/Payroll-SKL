@extends('layouts.app')

@section('title', 'Detail Karyawan')

@section('content')
<div class="mb-4">
    <h1 class="text-2xl font-semibold"><i class="fas fa-user"></i> Detail Karyawan</h1>
    <nav aria-label="breadcrumb">
        <ol class="list-reset flex text-gray-500">
            <li><a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a></li>
            <li class="mx-2">/</li>
            <li><a href="{{ route('admin.karyawan.index') }}" class="text-blue-600 hover:underline">Data Karyawan</a></li>
            <li class="mx-2">/</li>
            <li class="font-medium">Detail Karyawan</li>
        </ol>
    </nav>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="bg-white shadow-md rounded-lg">
        <div class="bg-blue-600 text-white p-4 rounded-t-lg">
            <h5 class="mb-0 text-lg font-bold">Informasi Karyawan</h5>
        </div>
        <div class="p-4">
            <table class="w-full">
                <tr>
                    <th class="text-left py-2">Nama Lengkap</th>
                    <td class="py-2">{{ $karyawan->user->name }}</td>
                </tr>
                <tr>
                    <th class="text-left py-2">NIK</th>
                    <td class="py-2">{{ $karyawan->nik }}</td>
                </tr>
                <tr>
                    <th class="text-left py-2">Email</th>
                    <td class="py-2">{{ $karyawan->user->email }}</td>
                </tr>
                <tr>
                    <th class="text-left py-2">No. Telepon</th>
                    <td class="py-2">{{ $karyawan->no_telepon ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-left py-2">Alamat</th>
                    <td class="py-2">{{ $karyawan->alamat ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-left py-2">Posisi</th>
                    <td class="py-2">{{ $karyawan->posisi }}</td>
                </tr>
                <tr>
                    <th class="text-left py-2">Tanggal Masuk</th>
                    <td class="py-2">{{ $karyawan->tanggal_masuk->format('d M Y') }}</td>
                </tr>
                <tr>
                    <th class="text-left py-2">Gaji Pokok</th>
                    <td class="py-2">Rp {{ number_format($karyawan->gaji_pokok, 0, ',', '.') }}</td>
                </tr>
            </table>
            <div class="mt-4 flex gap-2">
                <a href="{{ route('admin.karyawan.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600"><i class="fas fa-arrow-left"></i> Kembali</a>
                <a href="{{ route('admin.karyawan.edit', $karyawan) }}" class="bg-yellow-600 text-white px-4 py-2 rounded-md hover:bg-yellow-700"><i class="fas fa-edit"></i> Edit</a>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg">
        <div class="bg-blue-600 text-white p-4 rounded-t-lg">
            <h5 class="mb-0 text-lg font-bold">Statistik Absensi Bulan Ini</h5>
        </div>
        <div class="p-4">
            @php
                $bulanIni = \App\Models\Absensi::where('karyawan_id', $karyawan->id)
                    ->whereMonth('tanggal', date('m'))
                    ->whereYear('tanggal', date('Y'))
                    ->get();
            @endphp

            <ul class="list-disc pl-5">
                <li class="flex justify-between">
                    Hadir
                    <span class="bg-green-500 text-white rounded-full px-3">
                        {{ $bulanIni->where('status', 'hadir')->count() }}
                    </span>
                </li>
                <li class="flex justify-between">
                    Izin
                    <span class="bg-yellow-500 text-white rounded-full px-3">
                        {{ $bulanIni->where('status', 'izin')->count() }}
                    </span>
                </li>
                <li class="flex justify-between">
                    Sakit
                    <span class="bg-red-500 text-white rounded-full px-3">
                        {{ $bulanIni->where('status', 'sakit')->count() }}
                    </span>
                </li>
                <li class="flex justify-between">
                    Tanpa Keterangan
                    <span class="bg-gray-800 text-white rounded-full px-3">
                        {{ $bulanIni->where('status', 'tanpa keterangan')->count() }}
                    </span>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="bg-white shadow-md rounded-lg mt-4">
    <div class="bg-green-600 text-white p-4 rounded-t-lg">
        <h5 class="mb-0 text-lg font-bold">Riwayat Absensi Terakhir</h5>
    </div>
    <div class="p-4">
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Jam Masuk</th>
                        <th class="px-4 py-2">Jam Pulang</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Keterangan</th>
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
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $absensi->tanggal->format('d/m/Y') }}</td>
                        <td class="px-4 py-2">{{ $absensi->jam_masuk ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $absensi->jam_pulang ?? '-' }}</td>
                        <td class="px-4 py-2">
                            <span class="bg-{{ $absensi->status == 'hadir' ? 'green' : ($absensi->status == 'izin' ? 'yellow' : 'red') }}-500 text-white rounded-full px-3">
                                {{ ucfirst($absensi->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $absensi->keterangan ?? '-' }}</td>
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
</div>
@endsection