@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<h1 class="mb-4"><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h1>

<div class="row">
    <!-- Card Total Karyawan -->
    <div class="col-md-3 mb-4">
        <div class="card bg-primary text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Total Karyawan</h6>
                        <h2 class="mb-0">{{ \App\Models\Karyawan::count() }}</h2>
                    </div>
                    <div>
                        <i class="fas fa-users fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.karyawan.index') }}" class="text-white text-decoration-none">
                    Lihat Detail <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Card Hadir Hari Ini -->
    <div class="col-md-3 mb-4">
        <div class="card bg-success text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Hadir Hari Ini</h6>
                        <h2 class="mb-0">{{ \App\Models\Absensi::whereDate('tanggal', today())->where('status', 'hadir')->count() }}</h2>
                    </div>
                    <div>
                        <i class="fas fa-user-check fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.absensi.rekap') }}" class="text-white text-decoration-none">
                    Lihat Detail <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Card Izin/Sakit Hari Ini -->
    <div class="col-md-3 mb-4">
        <div class="card bg-warning text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Izin/Sakit Hari Ini</h6>
                        <h2 class="mb-0">{{ \App\Models\Absensi::whereDate('tanggal', today())->whereIn('status', ['izin', 'sakit'])->count() }}</h2>
                    </div>
                    <div>
                        <i class="fas fa-user-clock fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.absensi.rekap') }}" class="text-white text-decoration-none">
                    Lihat Detail <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Card Total Gaji Bulan Ini -->
    <div class="col-md-3 mb-4">
        <div class="card bg-info text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Total Gaji Bulan Ini</h6>
                        <h2 class="mb-0">
                            @php
                                $totalGaji = \App\Models\Gaji::where('bulan', date('m'))
                                    ->where('tahun', date('Y'))
                                    ->sum('gaji_bersih');
                            @endphp
                            Rp {{ number_format($totalGaji, 0, ',', '.') }}
                        </h2>
                    </div>
                    <div>
                        <i class="fas fa-money-bill-wave fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.gaji.index') }}" class="text-white text-decoration-none">
                    Lihat Detail <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Chart & Recent Activities -->
<div class="row mt-4">
    <!-- Absensi Hari Ini -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-clock"></i> Absensi Hari Ini</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $absensiHariIni = \App\Models\Absensi::with('karyawan.user')
                                    ->whereDate('tanggal', today())
                                    ->latest()
                                    ->limit(10)
                                    ->get();
                            @endphp
                            @forelse($absensiHariIni as $absensi)
                                <tr>
                                    <td>{{ $absensi->karyawan->user->name }}</td>
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
                                    <td colspan="4" class="text-center">Belum ada data absensi hari ini</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-3">
                    <a href="{{ route('admin.absensi.rekap') }}" class="btn btn-sm btn-primary">
                        Lihat Semua <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Karyawan Baru -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-users"></i> Karyawan Baru</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Posisi</th>
                                <th>Tanggal Masuk</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $karyawanBaru = \App\Models\Karyawan::with('user')
                                    ->orderBy('tanggal_masuk', 'desc')
                                    ->limit(5)
                                    ->get();
                            @endphp
                            @forelse($karyawanBaru as $karyawan)
                                <tr>
                                    <td>{{ $karyawan->user->name }}</td>
                                    <td>{{ $karyawan->posisi }}</td>
                                    <td>{{ $karyawan->tanggal_masuk->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada data karyawan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="text-center mt-3">
                    <a href="{{ route('admin.karyawan.index') }}" class="btn btn-sm btn-success">
                        Lihat Semua <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Chart -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0"><i class="fas fa-chart-bar"></i> Statistik Absensi Bulan Ini</h5>
            </div>
            <div class="card-body">
                @php
                    $bulanIni = \App\Models\Absensi::whereMonth('tanggal', date('m'))
                        ->whereYear('tanggal', date('Y'))
                        ->selectRaw('status, COUNT(*) as total')
                        ->groupBy('status')
                        ->get();
                    
                    $totalAbsensi = $bulanIni->sum('total');
                @endphp
                
                @if($totalAbsensi > 0)
                    <div class="row">
                        @foreach($bulanIni as $status)
                            <div class="col-md-3">
                                <div class="text-center">
                                    <h4>{{ $status->total }}</h4>
                                    <p>{{ ucfirst($status->status) }}</p>
                                    <div class="progress" style="height: 25px;">
                                        <div class="progress-bar bg-{{ $status->status == 'hadir' ? 'success' : ($status->status == 'izin' ? 'warning' : ($status->status == 'sakit' ? 'info' : 'danger')) }}" 
                                             role="progressbar" 
                                             style="width: {{ ($status->total / $totalAbsensi) * 100 }}%">
                                            {{ round(($status->total / $totalAbsensi) * 100, 1) }}%
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center">Belum ada data absensi bulan ini</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0"><i class="fas fa-bolt"></i> Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <a href="{{ route('admin.karyawan.create') }}" class="btn btn-primary btn-block mb-2">
                            <i class="fas fa-user-plus"></i> Tambah Karyawan
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.absensi.rekap') }}" class="btn btn-info btn-block mb-2">
                            <i class="fas fa-calendar-check"></i> Rekap Absensi
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ route('admin.gaji.index') }}" class="btn btn-success btn-block mb-2">
                            <i class="fas fa-money-bill"></i> Data Gaji
                        </a>
                    </div>
                    <div class="col-md-3">
                        <form action="{{ route('admin.gaji.hitung') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="bulan" value="{{ date('m') }}">
                            <input type="hidden" name="tahun" value="{{ date('Y') }}">
                            <button type="submit" class="btn btn-warning btn-block mb-2" 
                                    onclick="return confirm('Hitung gaji untuk bulan {{ date('F Y') }}?')">
                                <i class="fas fa-calculator"></i> Hitung Gaji
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Auto refresh dashboard every 5 minutes
setInterval(function() {
    window.location.reload();
}, 300000);
</script>
@endpush