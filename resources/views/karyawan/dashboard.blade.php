@extends('layouts.app')

@section('title', 'Dashboard Karyawan')

@section('content')
<h1 class="mb-4"><i class="fas fa-home"></i> Dashboard Karyawan</h1>

<div class="row">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Selamat Datang, {{ Auth::user()->name }}!</h5>
                <p class="card-text">Posisi: {{ Auth::user()->karyawan->posisi }}</p>
                <p class="card-text">NIK: {{ Auth::user()->karyawan->nik }}</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-clock"></i> Presensi Hari Ini</h5>
            </div>
            <div class="card-body">
                @php
                    $absensiHariIni = Auth::user()->karyawan->absensi()
                        ->whereDate('tanggal', today())
                        ->first();
                @endphp
                
                @if(!$absensiHariIni || !$absensiHariIni->jam_masuk)
                    <form action="{{ route('karyawan.absensi.masuk') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg" onclick="return confirm('Konfirmasi presensi masuk?')">
                            <i class="fas fa-sign-in-alt"></i> Presensi Masuk
                        </button>
                    </form>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-check-circle"></i> Anda sudah melakukan presensi masuk pada {{ $absensiHariIni->jam_masuk }}
                    </div>
                    
                    @if(!$absensiHariIni->jam_pulang)
                        <form action="{{ route('karyawan.absensi.pulang') }}" method="POST" class="mt-3">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-lg" onclick="return confirm('Konfirmasi presensi pulang?')">
                                <i class="fas fa-sign-out-alt"></i> Presensi Pulang
                            </button>
                        </form>
                    @else
                        <div class="alert alert-success mt-3">
                            <i class="fas fa-check-double"></i> Anda sudah melakukan presensi pulang pada {{ $absensiHariIni->jam_pulang }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="fas fa-calendar-check"></i> Statistik Absensi Bulan Ini</h5>
            </div>
            <div class="card-body">
                @php
                    $bulanIni = Auth::user()->karyawan->absensi()
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
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-warning">
                <h5 class="mb-0"><i class="fas fa-history"></i> Riwayat Absensi Terakhir</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                                <th>Status</th>
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
                            <tr>
                                <td>{{ $absensi->tanggal->format('d/m/Y') }}</td>
                                <td>{{ $absensi->jam_masuk ?? '-' }}</td>
                                <td>{{ $absensi->jam_pulang ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $absensi->status == 'hadir' ? 'success' : ($absensi->status == 'izin' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($absensi->status) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Belum ada data absensi</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="text-center mt-3">
                    <a href="{{ route('karyawan.absensi.riwayat') }}" class="btn btn-sm btn-primary">
                        Lihat Semua <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection