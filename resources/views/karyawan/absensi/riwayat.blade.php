@extends('layouts.app')

@section('title', 'Riwayat Absensi')

@section('content')
<div class="mb-4">
    <h1><i class="fas fa-history"></i> Riwayat Absensi</h1>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $absensi)
                    <tr>
                        <td>{{ $loop->iteration + $riwayat->firstItem() - 1 }}</td>
                        <td>{{ $absensi->tanggal->format('d/m/Y') }}</td>
                        <td>{{ $absensi->jam_masuk ?? '-' }}</td>
                        <td>{{ $absensi->jam_pulang ?? '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $absensi->status == 'hadir' ? 'success' : ($absensi->status == 'izin' ? 'warning' : ($absensi->status == 'sakit' ? 'info' : 'danger')) }}">
                                {{ ucfirst($absensi->status) }}
                            </span>
                        </td>
                        <td>{{ $absensi->keterangan ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada riwayat absensi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{ $riwayat->links() }}
    </div>
</div>

<div class="card mt-4">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0"><i class="fas fa-chart-bar"></i> Statistik Absensi Bulan Ini</h5>
    </div>
    <div class="card-body">
        @php
            $bulanIni = Auth::user()->karyawan->absensi()
                ->whereMonth('tanggal', date('m'))
                ->whereYear('tanggal', date('Y'))
                ->get();
                
            $totalHari = $bulanIni->count();
            $hadir = $bulanIni->where('status', 'hadir')->count();
            $izin = $bulanIni->where('status', 'izin')->count();
            $sakit = $bulanIni->where('status', 'sakit')->count();
            $tanpaKeterangan = $bulanIni->where('status', 'tanpa keterangan')->count();
        @endphp
        
        <div class="row text-center">
            <div class="col-md-3">
                <div class="card bg-success text-white mb-3">
                    <div class="card-body">
                        <h3>{{ $hadir }}</h3>
                        <p>Hadir</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white mb-3">
                    <div class="card-body">
                        <h3>{{ $izin }}</h3>
                        <p>Izin</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white mb-3">
                    <div class="card-body">
                        <h3>{{ $sakit }}</h3>
                        <p>Sakit</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white mb-3">
                    <div class="card-body">
                        <h3>{{ $tanpaKeterangan }}</h3>
                        <p>Tanpa Ket.</p>
                    </div>
                </div>
            </div>
        </div>
        
        @if($totalHari > 0)
        <div class="progress" style="height: 25px;">
            <div class="progress-bar bg-success" role="progressbar" style="width: {{ ($hadir/$totalHari)*100 }}%">
                {{ round(($hadir/$totalHari)*100) }}%
            </div>
            <div class="progress-bar bg-warning" role="progressbar" style="width: {{ ($izin/$totalHari)*100 }}%">
                {{ round(($izin/$totalHari)*100) }}%
            </div>
            <div class="progress-bar bg-info" role="progressbar" style="width: {{ ($sakit/$totalHari)*100 }}%">
                {{ round(($sakit/$totalHari)*100) }}%
            </div>
            <div class="progress-bar bg-danger" role="progressbar" style="width: {{ ($tanpaKeterangan/$totalHari)*100 }}%">
                {{ round(($tanpaKeterangan/$totalHari)*100) }}%
            </div>
        </div>
        @endif
    </div>
</div>
@endsection