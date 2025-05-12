@extends('layouts.app')

@section('title', 'Data Karyawan')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="fas fa-users"></i> Data Karyawan</h1>
    <a href="{{ route('admin.karyawan.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Karyawan
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Posisi</th>
                        <th>Tanggal Masuk</th>
                        <th>Gaji Pokok</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($karyawans as $karyawan)
                    <tr>
                        <td>{{ $loop->iteration + $karyawans->firstItem() - 1 }}</td>
                        <td>{{ $karyawan->nik }}</td>
                        <td>{{ $karyawan->user->name }}</td>
                        <td>{{ $karyawan->user->email }}</td>
                        <td>{{ $karyawan->posisi }}</td>
                        <td>{{ $karyawan->tanggal_masuk->format('d/m/Y') }}</td>
                        <td>Rp {{ number_format($karyawan->gaji_pokok, 0, ',', '.') }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.karyawan.show', $karyawan) }}" class="btn btn-sm btn-info" title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.karyawan.edit', $karyawan) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.karyawan.destroy', $karyawan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data karyawan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{ $karyawans->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
// Optional: Tambahkan script jika diperlukan
</script>
@endpush