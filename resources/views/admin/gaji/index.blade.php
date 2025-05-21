@extends('layouts.app')

@section('title', 'Data Gaji')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-semibold"><i class="fas fa-money-bill-wave"></i> Data Gaji</h1>
    <a href="{{ route('admin.gaji.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 flex items-center">
        <i class="fas fa-plus mr-2"></i> Tambah Gaji
    </a>
</div>

<div class="bg-white shadow-md rounded-lg">
    <div class="p-4">
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2">No</th>
                        <th class="px-4 py-2">Bulan</th>
                        <th class="px-4 py-2">Tahun</th>
                        <th class="px-4 py-2">Karyawan</th>
                        <th class="px-4 py-2">Gaji Pokok</th>
                        <th class="px-4 py-2">Gaji Bersih</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($gajiList as $gaji)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $loop->iteration + $gajiList->firstItem() - 1 }}</td>
                        <td class="px-4 py-2">{{ DateTime::createFromFormat('!m', $gaji->bulan)->format('F') }}</td>
                        <td class="px-4 py-2">{{ $gaji->tahun }}</td>
                        <td class="px-4 py-2">{{ $gaji->karyawan->user->name }}</td>
                        <td class="px-4 py-2">Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">Rp {{ number_format($gaji->gaji_bersih, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.gaji.show', $gaji) }}" class="bg-blue-600 text-white px-2 py-1 rounded-md hover:bg-blue-700" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.gaji.edit', $gaji) }}" class="bg-yellow-500 text-white px-2 py-1 rounded-md hover:bg-yellow-600" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.gaji.destroy', $gaji) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus gaji ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded-md hover:bg-red-700" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center px-4 py-2">Tidak ada data gaji</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $gajiList->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Optional JavaScript
</script>
@endpush