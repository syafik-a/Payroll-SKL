@extends('layouts.app')

@section('title', 'Data Gaji')

@section('content')
<div class="mb-4">
    <h1><i class="fas fa-money-bill-wave"></i> Data Gaji</h1>
</div>

<div class="row mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.gaji.index') }}" method="GET" class="row g-3">
                    <div class="col-md-5">
                        <label for="bulan" class="form-label">Bulan</label>
                        <select name="bulan" id="bulan" class="form-select">
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    
                    <div class="col-md-5">
                        <label for="tahun" class="form-label">Tahun</label>
                        <select name="tahun" id="tahun" class="form-select">
                            @for($i = date('Y') - 5; $i <= date('Y'); $i++)
                                <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary d-block w-100">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Hitung Gaji Bulanan</h5>
                <form action="{{ route('admin.gaji.hitung') }}" method="POST">
                    @csrf
                    <input type="hidden" name="bulan" value="{{ $bulan }}">
                    <input type="hidden" name="tahun" value="{{ $tahun }}">
                    <button type="submit" class="btn btn-success w-100" 
                            onclick="return confirm('Yakin ingin menghitung gaji untuk {{ DateTime::createFromFormat('!m', $bulan)->format('F') }} {{ $tahun }}?')">
                        <i class="fas fa-calculator"></i> Hitung Gaji
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Karyawan</th>
                        <th>NIK</th>
                        <th>Hadir</th>
                        <th>Izin</th>
                        <th>Sakit</th>
                        <th>Tanpa Ket.</th>
                        <th>Gaji Pokok</th>
                        <th>Potongan</th>
                        <th>Gaji Bersih</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($gajis as $gaji)
                    <tr>
                        <td>{{ $loop->iteration + $gajis->firstItem() - 1 }}</td>
                        <td>{{ $gaji->karyawan->user->name }}</td>
                        <td>{{ $gaji->karyawan->nik }}</td>
                        <td>{{ $gaji->total_hadir }}</td>
                        <td>{{ $gaji->total_izin }}</td>
                        <td>{{ $gaji->total_sakit }}</td>
                        <td>{{ $gaji->total_tanpa_keterangan }}</td>
                        <td>Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($gaji->potongan, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($gaji->gaji_bersih, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('admin.gaji.slip', $gaji->id) }}" 
                               class="btn btn-sm btn-info" title="Cetak Slip" target="_blank">
                                <i class="fas fa-print"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="text-center">Tidak ada data gaji untuk periode ini</td>
                    </tr>
                    @endforelse
                </tbody>
                @if($gajis->count() > 0)
                <tfoot>
                    <tr class="fw-bold">
                        <td colspan="7" class="text-end">Total:</td>
                        <td>Rp {{ number_format($gajis->sum('gaji_pokok'), 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($gajis->sum('potongan'), 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($gajis->sum('gaji_bersih'), 0, ',', '.') }}</td>
                        <td></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
        
        {{ $gajis->appends(['bulan' => $bulan, 'tahun' => $tahun])->links() }}
    </div>
</div>
@endsection