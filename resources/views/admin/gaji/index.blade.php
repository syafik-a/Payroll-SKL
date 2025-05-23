@extends('layouts.app')

@section('title', 'Data Gaji')

@section('content')
<div class="mb-4">
    <h1 class="text-2xl font-semibold"><i class="fas fa-money-bill-wave"></i> Data Gaji</h1>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
    <div>
        <div class="bg-white p-6 shadow-md rounded-lg">
            <form action="{{ route('admin.gaji.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
            </form>
        </div>
    </div>

    <div>
        <div class="bg-white p-6 shadow-md rounded-lg">
            <h5 class="text-lg font-semibold">Hitung Gaji Bulanan</h5>
            <form action="{{ route('admin.gaji.hitung') }}" method="POST">
                @csrf
                <input type="hidden" name="bulan" value="{{ $bulan }}">
                <input type="hidden" name="tahun" value="{{ $tahun }}">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 mt-2 rounded-md hover:bg-green-700 w-full" 
                        onclick="return confirm('Yakin ingin menghitung gaji untuk {{ DateTime::createFromFormat('!m', $bulan)->format('F') }} {{ $tahun }}?')">
                    <i class="fas fa-calculator"></i> Hitung Gaji
                </button>
            </form>
        </div>
    </div>
</div>

<div class="bg-white shadow-md rounded-lg">
    <div class="p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2 border border-gray-300">No</th>
                        <th class="px-4 py-2 border border-gray-300">Nama Karyawan</th>
                        <th class="px-4 py-2 border border-gray-300">NIK</th>
                        <th class="px-4 py-2 border border-gray-300">Hadir</th>
                        <th class="px-4 py-2 border border-gray-300">Izin</th>
                        <th class="px-4 py-2 border border-gray-300">Sakit</th>
                        <th class="px-4 py-2 border border-gray-300">Tanpa Ket.</th>
                        <th class="px-4 py-2 border border-gray-300">Gaji Pokok</th>
                        <th class="px-4 py-2 border border-gray-300">Potongan</th>
                        <th class="px-4 py-2 border border-gray-300">Gaji Bersih</th>
                        <th class="px-4 py-2 border border-gray-300">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($gajis as $gaji)
                    <tr class="border-b border-gray-300">
                        <td class="px-4 py-2 border border-gray-300">{{ $loop->iteration + $gajis->firstItem() - 1 }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $gaji->karyawan->user->name }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $gaji->karyawan->nik }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $gaji->total_hadir }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $gaji->total_izin }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $gaji->total_sakit }}</td>
                        <td class="px-4 py-2 border border-gray-300">{{ $gaji->total_tanpa_keterangan }}</td>
                        <td class="px-4 py-2 border border-gray-300">Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</td>
                        <td class="px-4 py-2 border border-gray-300">Rp {{ number_format($gaji->potongan, 0, ',', '.') }}</td>
                        <td class="px-4 py-2 border border-gray-300">Rp {{ number_format($gaji->gaji_bersih, 0, ',', '.') }}</td>
                        <td class="px-4 py-2 border border-gray-300">
                            <a href="{{ route('admin.gaji.slip', $gaji->id) }}" class="bg-info text-white px-2 py-1 rounded hover:bg-blue-600" title="Cetak Slip" target="_blank">
                                <i class="fas fa-print"></i> Cetak
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="text-center px-4 py-2">Tidak ada data gaji untuk periode ini</td>
                    </tr>
                    @endforelse
                </tbody>
                @if($gajis->count() > 0)
                <tfoot>
                    <tr class="font-bold">
                        <td colspan="7" class="text-right px-4 py-2">Total:</td>
                        <td>Rp {{ number_format($gajis->sum('gaji_pokok'), 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($gajis->sum('potongan'), 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($gajis->sum('gaji_bersih'), 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
        
        <div class="mt-4">
            {{ $gajis->appends(['bulan' => $bulan, 'tahun' => $tahun])->links() }}
        </div>
    </div>
</div>
@endsection