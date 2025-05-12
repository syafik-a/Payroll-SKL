@extends('layouts.app')

@section('title', 'Rekap Absensi')

@section('content')
<div class="mb-4">
    <h1><i class="fas fa-calendar-check"></i> Rekap Absensi</h1>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('admin.absensi.rekap') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label for="bulan" class="form-label">Bulan</label>
                <select name="bulan" id="bulan" class="form-select">
                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                        </option>
                    @endfor
                </select>
            </div>
            
            <div class="col-md-4">
                <label for="tahun" class="form-label">Tahun</label>
                <select name="tahun" id="tahun" class="form-select">
                    @for($i = date('Y') - 5; $i <= date('Y'); $i++)
                        <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>
            
            <div class="col-md-4">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-primary d-block">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Karyawan</th>
                        <th>NIK</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($absensi as $data)
                    <tr>
                        <td>{{ $loop->iteration + $absensi->firstItem() - 1 }}</td>
                        <td>{{ $data->tanggal->format('d/m/Y') }}</td>
                        <td>{{ $data->karyawan->user->name }}</td>
                        <td>{{ $data->karyawan->nik }}</td>
                        <td>{{ $data->jam_masuk ?? '-' }}</td>
                        <td>{{ $data->jam_pulang ?? '-' }}</td>
                        <td>
                            <span class="badge bg-{{ $data->status == 'hadir' ? 'success' : ($data->status == 'izin' ? 'warning' : ($data->status == 'sakit' ? 'info' : 'danger')) }}">
                                {{ ucfirst($data->status) }}
                            </span>
                        </td>
                        <td>{{ $data->keterangan ?? '-' }}</td>
                        <td>
                            <a href="{{ route('admin.absensi.edit', $data) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data absensi untuk periode ini</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{ $absensi->appends(['bulan' => $bulan, 'tahun' => $tahun])->links() }}
    </div>
</div>
@endsection
