@extends('layouts.app')

@section('title', 'Riwayat Absensi')

@section('content')
<div class="mb-4">
    <h1 class="text-2xl font-semibold"><i class="fas fa-history"></i> Riwayat Absensi</h1>
</div>

<div class="bg-white shadow-md rounded-lg">
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2 border border-gray-300">No</th>
                        <th class="px-4 py-2 border border-gray-300">Tanggal</th>
                        <th class="px-4 py-2 border border-gray-300">Jam Masuk</th>
                        <th class="px-4 py-2 border border-gray-300">Jam Pulang</th>
                        <th class="px-4 py-2 border border-gray-300">Status</th>
                        <th class="px-4 py-2 border border-gray-300">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $absensi)
                    <tr class="border-b border-gray-300">
                        <td class="px-4 py-2 border border-gray-300">{{ $loop->iteration + $riwayat->firstItem() - 1 }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $absensi->tanggal->format('d/m/Y') }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $absensi->jam_masuk ?? '-' }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $absensi->jam_pulang ?? '-' }}</td>
                        <td class="px-4 py-2 border border-gray-300">
                            <span class="bg-{{ $absensi->status == 'hadir' ? 'green' : ($absensi->status == 'izin' ? 'yellow' : ($absensi->status == 'sakit' ? 'blue' : 'red')) }}-500 text-white rounded px-2 py-1">
                                {{ ucfirst($absensi->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2 border border-gray-300">{{ $absensi->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center px-4 py-2">Tidak ada riwayat absensi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $riwayat->links() }}
        </div>
    </div>
</div>
@endsection