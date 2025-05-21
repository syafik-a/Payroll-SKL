@extends('layouts.app')

@section('title', 'Data Karyawan')

@section('content')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-semibold"><i class="fas fa-users"></i> Data Karyawan</h1>
    <a href="{{ route('admin.karyawan.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 flex items-center">
        <i class="fas fa-plus mr-2"></i> Tambah Karyawan
    </a>
</div>

<div class="bg-white shadow-md rounded-lg">
    <div class="p-4">
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2">No</th>
                        <th class="px-4 py-2">NIK</th>
                        <th class="px-4 py-2">Nama</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Posisi</th>
                        <th class="px-4 py-2">Tanggal Masuk</th>
                        <th class="px-4 py-2">Gaji Pokok</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($karyawans as $karyawan)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $loop->iteration + $karyawans->firstItem() - 1 }}</td>
                        <td class="px-4 py-2">{{ $karyawan->nik }}</td>
                        <td class="px-4 py-2">{{ $karyawan->user->name }}</td>
                        <td class="px-4 py-2">{{ $karyawan->user->email }}</td>
                        <td class="px-4 py-2">{{ $karyawan->posisi }}</td>
                        <td class="px-4 py-2">{{ $karyawan->tanggal_masuk->format('d/m/Y') }}</td>
                        <td class="px-4 py-2">Rp {{ number_format($karyawan->gaji_pokok, 0, ',', '.') }}</td>
                        <td class="px-4 py-2">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.karyawan.show', $karyawan) }}" class="bg-blue-600 text-white px-2 py-1 rounded-md hover:bg-blue-700" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.karyawan.edit', $karyawan) }}" class="bg-yellow-500 text-white px-2 py-1 rounded-md hover:bg-yellow-600" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.karyawan.destroy', $karyawan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
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
                        <td colspan="8" class="text-center px-4 py-2">Tidak ada data karyawan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $karyawans->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Optional: Tambahkan script jika diperlukan
</script>
@endpush