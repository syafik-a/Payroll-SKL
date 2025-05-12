@extends('layouts.app')

@section('title', 'Detail Karyawan')

@section('content')
<div class="mb-4">
    <h1><i class="fas fa-user"></i> Detail Karyawan</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.karyawan.index') }}">Data Karyawan</a></li>
            <li class="breadcrumb-item active">Detail Karyawan</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Informasi Karyawan</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th width="200">Nama Lengkap</th>
                        <td>{{ $karyawan->user->name }}</td>
                    </tr>
                    <tr>
                        <th>NIK</th>
                        <td>{{ $karyawan->nik }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $karyawan->user->email }}</td>
                    </tr>
                    <tr>
                        <th>No. Telepon</th>
                        <td>{{ $karyawan->no_telepon ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Alamat</th>
                        <td>{{ $karyawan->alamat ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Posisi</th>
                        <td>{{ $karyawan->posisi }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Masuk</th>
                        <td>{{ $karyawan->tanggal_masuk->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <th>Gaji Pokok</th>
                        <td>Rp {{ number_format($karyawan->gaji_pokok, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td>
                            <span class="badge bg-info">{{ ucfirst($karyawan->user->role) }}</span>
                        </td>
                    </tr>
                </table>
                
                <div class="mt-3">
                    <a href="{{ route('admin.karyawan.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('admin.karyawan.edit', $karyawan) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Statistik Absensi Bulan Ini</h5>
            </div>
            <div class="card-body">
                @php
                    $bulanIni = \App\Models\Absensi::where('karyawan_id', $karyawan->id)
                        ->whereMonth('tanggal', date('m'))
                        ->whereYear('tanggal', date('Y'))
                        ->get();
                @endphp
                
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Hadir
                        <span class="badge bg-success rounded-pill">
                            {{ $bulanIni->where('status', 'hadir')->count() }}
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Izin
                        <span class="badge bg-warning rounded-pill">
                            {{ $bulanIni->where('status', 'izin')->count() }}
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Sakit
                        <span class="badge bg-danger rounded-pill">
                            {{ $bulanIni->where('status', 'sakit')->count() }}
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Tanpa Keterangan
                        <span class="badge bg-dark rounded-pill">
                            {{ $bulanIni->where('status', 'tanpa keterangan')->count() }}
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">Riwayat Absensi Terakhir</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $riwayatAbsensi = \App\Models\Absensi::where('karyawan_id', $karyawan->id)
                            ->orderBy('tanggal', 'desc')
                            ->limit(10)
                            ->get();
                    @endphp
                    @forelse($riwayatAbsensi as $absensi)
                    <tr>
                        <td>{{ $absensi->tanggal->format('d/m/Y') }}</td>
                        <td>{{ $absensi->jam_masuk ?? '-' }}</td>
                        <td>{{ $absensi->jam_pulang ?? '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $absensi->status == 'hadir' ? 'success' : ($absensi->status == 'izin' ? 'warning' : 'danger') }}">
                                {{ ucfirst($absensi->status) }}
                            </span>
                        </td>
                        <td>{{ $absensi->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada riwayat absensi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection