@extends('layouts.app')

@section('title', 'Rekap Absensi')

@section('content')
<div class="mb-4">
    <h1 class="text-2xl font-semibold"><i class="fas fa-calendar-check"></i> Rekap Absensi</h1>
</div>

<div class="bg-white shadow-md rounded-lg mb-4">
    <div class="p-6">
        <form action="{{ route('admin.absensi.rekap') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label for="bulan" class="block text-sm font-medium text-gray-700">Bulan</label>
                    <select name="bulan" id="bulan" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label for="tahun" class="block text-sm font-medium text-gray-700">Tahun</label>
                    <select name="tahun" id="tahun" class="mt-1 block w-full p-2 border border-gray-300 rounded-md">
                        @for($i = date('Y') - 5; $i <= date('Y'); $i++)
                            <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 w-full">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="bg-white shadow-md rounded-lg">
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2">No</th>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Nama Karyawan</th>
                        <th class="px-4 py-2">NIK</th>
                        <th class="px-4 py-2">Jam Masuk</th>
                        <th class="px-4 py-2">Jam Pulang</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Keterangan</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($absensi as $data)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $loop->iteration + $absensi->firstItem() - 1 }}</td>
                        <td class="px-4 py-2">{{ $data->tanggal->format('d/m/Y') }}</td>
                        <td class="px-4 py-2">{{ $data->karyawan->user->name }}</td>
                        <td class="px-4 py-2">{{ $data->karyawan->nik }}</td>
                        <td class="px-4 py-2">{{ $data->jam_masuk ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $data->jam_pulang ?? '-' }}</td>
                        <td class="px-4 py-2">
                            <span class="bg-{{ $data->status == 'hadir' ? 'green' : ($data->status == 'izin' ? 'yellow' : 'red') }}-500 text-white rounded px-2 py-1">
                                {{ ucfirst($data->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $data->keterangan ?? '-' }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.absensi.edit', $data) }}" class="bg-yellow-500 text-white px-2 py-1 rounded hover:bg-yellow-600" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center px-4 py-2">Tidak ada data absensi untuk periode ini</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $absensi->appends(['bulan' => $bulan, 'tahun' => $tahun])->links() }}
        </div>
    </div>
</div>
@endsection