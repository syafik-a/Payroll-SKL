@extends('layouts.app')

@section('title', 'Dashboard Karyawan')

@section('content')
<h1 class="mb-4 text-2xl font-semibold"><i class="fas fa-tachometer-alt"></i> Dashboard Karyawan</h1>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h5 class="mb-3 text-lg font-semibold"><i class="fas fa-calendar-check"></i> Absensi Bulan Ini</h5>
        @php
            $bulanIni = \App\Models\Absensi::where('karyawan_id', Auth::user()->karyawan->id)
                ->whereMonth('tanggal', date('m'))
                ->whereYear('tanggal', date('Y'))
                ->selectRaw('status, COUNT(*) as total')
                ->groupBy('status')
                ->get();

            $totalAbsensi = $bulanIni->sum('total');
        @endphp
        
        @if($totalAbsensi > 0)
            <ul class="list-none">
                @foreach($bulanIni as $status)
                <li class="flex justify-between">
                    {{ ucfirst($status->status) }}: <span class="font-bold">{{ $status->total }}</span>
                </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">Belum ada data absensi bulan ini.</p>
        @endif
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <h5 class="mb-3 text-lg font-semibold"><i class="fas fa-money-bill-wave"></i> Gaji Bulan Ini</h5>
        @php
            $gaji = \App\Models\Gaji::where('karyawan_id', Auth::user()->karyawan->id)
                ->where('bulan', date('m'))
                ->where('tahun', date('Y'))
                ->first();
        @endphp
        
        @if($gaji)
            <p><strong>Gaji Pokok:</strong> Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</p>
            <p><strong>Potongan:</strong> Rp {{ number_format($gaji->potongan, 0, ',', '.') }}</p>
            <p class="font-bold"><strong>Gaji Bersih:</strong> Rp {{ number_format($gaji->gaji_bersih, 0, ',', '.') }}</p>
        @else
            <p class="text-gray-500">Gaji untuk bulan ini belum tersedia.</p>
        @endif
    </div>
</div>

<div class="bg-white shadow-md rounded-lg p-6">
    <h5 class="mb-4 text-lg font-semibold"><i class="fas fa-history"></i> Riwayat Absensi</h5>
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 border border-gray-300">Tanggal</th>
                    <th class="px-4 py-2 border border-gray-300">Jam Masuk</th>
                    <th class="px-4 py-2 border border-gray-300">Jam Pulang</th>
                    <th class="px-4 py-2 border border-gray-300">Status</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $riwayatAbsensi = \App\Models\Absensi::where('karyawan_id', Auth::user()->karyawan->id)
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
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center px-4 py-2">Belum ada riwayat absensi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection