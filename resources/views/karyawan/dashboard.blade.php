@extends('layouts.app')

@section('title', 'Dashboard Karyawan')

@section('content')
<h1 class="mb-4 text-2xl font-semibold text-gray-800"><i class="fas fa-home"></i> Dashboard Karyawan</h1>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-blue-600 text-white p-4 rounded-lg">
        <h5 class="text-lg font-bold">Selamat Datang, {{ Auth::user()->name }}!</h5>
        <p>Posisi: {{ Auth::user()->karyawan->posisi }}</p>
        <p>NIK: {{ Auth::user()->karyawan->nik }}</p>
    </div>
   
    <div class="md:col-span-2 bg-white shadow-md rounded-lg">
        <div class="bg-green-600 text-white p-4 rounded-t-lg">
            <h5 class="mb-0 text-lg font-bold"><i class="fas fa-clock"></i> Presensi Hari Ini</h5>
        </div>
        <div class="p-4">
            @php
                $absensiHariIni = Auth::user()->karyawan->absensi()
                    ->whereDate('tanggal', today())
                    ->first();
            @endphp
            
            @if(!$absensiHariIni || !$absensiHariIni->jam_masuk)
                <form action="{{ route('karyawan.absensi.masuk') }}" method="POST" class="inline-block">
                    @csrf
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg" onclick="return confirm('Konfirmasi presensi masuk?')">
                        <i class="fas fa-sign-in-alt"></i> Presensi Masuk
                    </button>
                </form>
            @else
                <div class="bg-blue-100 text-blue-800 p-3 rounded-lg">
                    <i class="fas fa-check-circle"></i> Anda sudah melakukan presensi masuk pada {{ $absensiHariIni->jam_masuk }}
                </div>
                
                @if(!$absensiHariIni->jam_pulang)
                    <form action="{{ route('karyawan.absensi.pulang') }}" method="POST" class="mt-3">
                        @csrf
                        <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded-lg" onclick="return confirm('Konfirmasi presensi pulang?')">
                            <i class="fas fa-sign-out-alt"></i> Presensi Pulang
                        </button>
                    </form>
                @else
                    <div class="bg-green-100 text-green-800 p-3 rounded-lg mt-3">
                        <i class="fas fa-check-double"></i> Anda sudah melakukan presensi pulang pada {{ $absensiHariIni->jam_pulang }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
    <div class="bg-white shadow-md rounded-lg">
        <div class="bg-blue-500 text-white p-4 rounded-t-lg">
            <h5 class="mb-0 text-lg font-bold"><i class="fas fa-calendar-check"></i> Statistik Absensi Bulan Ini</h5>
        </div>
        <div class="p-4">
            @php
                $bulanIni = Auth::user()->karyawan->absensi()
                    ->whereMonth('tanggal', date('m'))
                    ->whereYear('tanggal', date('Y'))
                    ->get();
            @endphp
            
            <ul class="list-disc pl-5">
                <li class="flex justify-between items-center">
                    Hadir
                    <span class="bg-green-500 text-white rounded-full px-3">{{ $bulanIni->where('status', 'hadir')->count() }}</span>
                </li>
                <li class="flex justify-between items-center">
                    Izin
                    <span class="bg-yellow-500 text-white rounded-full px-3">{{ $bulanIni->where('status', 'izin')->count() }}</span>
                </li>
                <li class="flex justify-between items-center">
                    Sakit
                    <span class="bg-red-500 text-white rounded-full px-3">{{ $bulanIni->where('status', 'sakit')->count() }}</span>
                </li>
                <li class="flex justify-between items-center">
                    Tanpa Keterangan
                    <span class="bg-gray-800 text-white rounded-full px-3">{{ $bulanIni->where('status', 'tanpa keterangan')->count() }}</span>
                </li>
            </ul>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg">
        <div class="bg-yellow-500 text-white p-4 rounded-t-lg">
            <h5 class="mb-0 text-lg font-bold"><i class="fas fa-history"></i> Riwayat Absensi Terakhir</h5>
        </div>
        <div class="p-4">
            <div class="overflow-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="px-4 py-2">Tanggal</th>
                            <th class="px-4 py-2">Jam Masuk</th>
                            <th class="px-4 py-2">Jam Pulang</th>
                            <th class="px-4 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $riwayatTerakhir = Auth::user()->karyawan->absensi()
                                ->orderBy('tanggal', 'desc')
                                ->limit(5)
                                ->get();
                        @endphp
                        @forelse($riwayatTerakhir as $absensi)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $absensi->tanggal->format('d/m/Y') }}</td>
                            <td class="px-4 py-2">{{ $absensi->jam_masuk ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $absensi->jam_pulang ?? '-' }}</td>
                            <td class="px-4 py-2">
                                <span class="bg-{{ $absensi->status == 'hadir' ? 'green' : ($absensi->status == 'izin' ? 'yellow' : 'red') }}-500 text-white rounded-full px-3">
                                    {{ ucfirst($absensi->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center px-4 py-2">Belum ada data absensi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="text-center mt-3">
                <a href="{{ route('karyawan.absensi.riwayat') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg">
                    Lihat Semua <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection