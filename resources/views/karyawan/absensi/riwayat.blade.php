@extends('layouts.app')

@section('title', 'Riwayat Absensi')

@section('content')
<div class="mb-4">
    <h1 class="text-2xl font-semibold"><i class="fas fa-history"></i> Riwayat Absensi</h1>
</div>

<div class="bg-white shadow-md rounded-lg">
    <div class="p-4">
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2">No</th>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Jam Masuk</th>
                        <th class="px-4 py-2">Jam Pulang</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $absensi)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $loop->iteration + $riwayat->firstItem() - 1 }}</td>
                        <td class="px-4 py-2">{{ $absensi->tanggal->format('d/m/Y') }}</td>
                        <td class="px-4 py-2">{{ $absensi->jam_masuk ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $absensi->jam_pulang ?? '-' }}</td>
                        <td class="px-4 py-2">
                            <span class="bg-{{ $absensi->status == 'hadir' ? 'green' : ($absensi->status == 'izin' ? 'yellow' : ($absensi->status == 'sakit' ? 'blue' : 'red')) }}-500 text-white rounded-full px-3">
                                {{ ucfirst($absensi->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $absensi->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center px-4 py-2">Tidak ada riwayat absensi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $riwayat->links() }}
    </div>
</div>

<div class="bg-white shadow-md rounded-lg mt-4">
    <div class="bg-blue-500 text-white p-4 rounded-t-lg">
        <h5 class="mb-0 text-lg font-bold"><i class="fas fa-chart-bar"></i> Statistik Absensi Bulan Ini</h5>
    </div>
    <div class="p-4">
        @php
            $bulanIni = Auth::user()->karyawan->absensi()
                ->whereMonth('tanggal', date('m'))
                ->whereYear('tanggal', date('Y'))
                ->get();
                
            $totalHari = $bulanIni->count();
            $hadir = $bulanIni->where('status', 'hadir')->count();
            $izin = $bulanIni->where('status', 'izin')->count();
            $sakit = $bulanIni->where('status', 'sakit')->count();
            $tanpaKeterangan = $bulanIni->where('status', 'tanpa keterangan')->count();
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-center">
            <div class="bg-green-500 text-white p-4 rounded-lg">
                <h3 class="text-2xl">{{ $hadir }}</h3>
                <p>Hadir</p>
            </div>
            <div class="bg-yellow-500 text-white p-4 rounded-lg">
                <h3 class="text-2xl">{{ $izin }}</h3>
                <p>Izin</p>
            </div>
            <div class="bg-blue-500 text-white p-4 rounded-lg">
                <h3 class="text-2xl">{{ $sakit }}</h3>
                <p>Sakit</p>
            </div>
            <div class="bg-red-500 text-white p-4 rounded-lg">
                <h3 class="text-2xl">{{ $tanpaKeterangan }}</h3>
                <p>Tanpa Ket.</p>
            </div>
        </div>
        
        @if($totalHari > 0)
        <div class="mt-4">
            <div class="relative h-6 bg-gray-300 rounded">
                <div class="absolute h-full bg-green-500" style="width: {{ ($hadir/$totalHari)*100 }}%"></div>
                <div class="absolute h-full bg-yellow-500" style="width: {{ ($izin/$totalHari)*100 }}%"></div>
                <div class="absolute h-full bg-blue-500" style="width: {{ ($sakit/$totalHari)*100 }}%"></div>
                <div class="absolute h-full bg-red-500" style="width: {{ ($tanpaKeterangan/$totalHari)*100 }}%"></div>
            </div>
            <div class="flex justify-between text-xs mt-1">
                <span>{{ round(($hadir/$totalHari)*100) }}% Hadir</span>
                <span>{{ round(($izin/$totalHari)*100) }}% Izin</span>
                <span>{{ round(($sakit/$totalHari)*100) }}% Sakit</span>
                <span>{{ round(($tanpaKeterangan/$totalHari)*100) }}% Tanpa Ket.</span>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection