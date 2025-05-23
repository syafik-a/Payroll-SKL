@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<h1 class="mb-4 text-2xl font-semibold"><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h1>

<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
    <div class="bg-blue-600 text-white p-4 rounded-lg shadow-md">
        <div class="flex justify-between items-center">
            <div>
                <h6 class="uppercase mb-1">Total Karyawan</h6>
                <h2 class="text-3xl">{{ \App\Models\Karyawan::count() }}</h2>
            </div>
            <i class="fas fa-users fa-3x opacity-50"></i>
        </div>
        <a href="{{ route('admin.karyawan.index') }}" class="text-white text-sm hover:underline">Lihat Detail <i class="fas fa-arrow-right"></i></a>
    </div>

    <div class="bg-green-600 text-white p-4 rounded-lg shadow-md">
        <div class="flex justify-between items-center">
            <div>
                <h6 class="uppercase mb-1">Hadir Hari Ini</h6>
                <h2 class="text-3xl">{{ \App\Models\Absensi::whereDate('tanggal', today())->where('status', 'hadir')->count() }}</h2>
            </div>
            <i class="fas fa-user-check fa-3x opacity-50"></i>
        </div>
        <a href="{{ route('admin.absensi.rekap') }}" class="text-white text-sm hover:underline">Lihat Detail <i class="fas fa-arrow-right"></i></a>
    </div>

    <div class="bg-yellow-600 text-white p-4 rounded-lg shadow-md">
        <div class="flex justify-between items-center">
            <div>
                <h6 class="uppercase mb-1">Izin/Sakit Hari Ini</h6>
                <h2 class="text-3xl">{{ \App\Models\Absensi::whereDate('tanggal', today())->whereIn('status', ['izin', 'sakit'])->count() }}</h2>
            </div>
            <i class="fas fa-user-clock fa-3x opacity-50"></i>
        </div>
        <a href="{{ route('admin.absensi.rekap') }}" class="text-white text-sm hover:underline">Lihat Detail <i class="fas fa-arrow-right"></i></a>
    </div>

    <div class="bg-purple-600 text-white p-4 rounded-lg shadow-md">
        <div class="flex justify-between items-center">
            <div>
                <h6 class="uppercase mb-1">Total Gaji Bulan Ini</h6>
                <h2 class="text-3xl">
                    @php
                        $totalGaji = \App\Models\Gaji::where('bulan', date('m'))->where('tahun', date('Y'))->sum('gaji_bersih');
                    @endphp
                    Rp {{ number_format($totalGaji, 0, ',', '.') }}
                </h2>
            </div>
            <i class="fas fa-money-bill-wave fa-3x opacity-50"></i>
        </div>
        <a href="{{ route('admin.gaji.index') }}" class="text-white text-sm hover:underline">Lihat Detail <i class="fas fa-arrow-right"></i></a>
    </div>
</div>

<!-- Chart & Recent Activities -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h5 class="mb-3 text-lg font-semibold"><i class="fas fa-clock"></i> Absensi Hari Ini</h5>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2 text-left">Nama</th>
                        <th class="px-4 py-2 text-left">Jam Masuk</th>
                        <th class="px-4 py-2 text-left">Jam Pulang</th>
                        <th class="px-4 py-2 text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $absensiHariIni = \App\Models\Absensi::with('karyawan.user')->whereDate('tanggal', today())->latest()->limit(10)->get();
                    @endphp
                    @forelse($absensiHariIni as $absensi)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $absensi->karyawan->user->name }}</td>
                            <td class="px-4 py-2">{{ $absensi->jam_masuk ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $absensi->jam_pulang ?? '-' }}</td>
                            <td class="px-4 py-2">
                                <span class="bg-{{ $absensi->status == 'hadir' ? 'green' : ($absensi->status == 'izin' ? 'yellow' : 'red') }}-500 text-white rounded px-2 py-1">
                                    {{ ucfirst($absensi->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center px-4 py-2">Belum ada data absensi hari ini</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <h5 class="mb-3 text-lg font-semibold"><i class="fas fa-users"></i> Karyawan Baru</h5>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2 text-left">Nama</th>
                        <th class="px-4 py-2 text-left">Posisi</th>
                        <th class="px-4 py-2 text-left">Tanggal Masuk</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $karyawanBaru = \App\Models\Karyawan::with('user')->orderBy('tanggal_masuk', 'desc')->limit(5)->get();
                    @endphp
                    @forelse($karyawanBaru as $karyawan)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $karyawan->user->name }}</td>
                            <td class="px-4 py-2">{{ $karyawan->posisi }}</td>
                            <td class="px-4 py-2">{{ $karyawan->tanggal_masuk->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center px-4 py-2">Belum ada data karyawan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection