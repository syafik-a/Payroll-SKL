@extends('layouts.app')

@section('title', 'Edit Absensi')

@section('content')
<div class="mb-4">
    <h1><i class="fas fa-calendar-edit"></i> Edit Absensi</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.absensi.rekap') }}">Rekap Absensi</a></li>
            <li class="breadcrumb-item active">Edit Absensi</li>
        </ol>
    </nav>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.absensi.update', $absensi) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Karyawan</label>
                    <input type="text" class="form-control" value="{{ $absensi->karyawan->user->name }}" readonly>
                </div>
                
                <div class="col-md-6">
                    <label class="form-label">NIK</label>
                    <input type="text" class="form-control" value="{{ $absensi->karyawan->nik }}" readonly>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror" 
                           id="tanggal" name="tanggal" 
                           value="{{ old('tanggal', $absensi->tanggal->format('Y-m-d')) }}" required>
                    @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4">
                    <label for="jam_masuk" class="form-label">Jam Masuk</label>
                    <input type="time" class="form-control @error('jam_masuk') is-invalid @enderror" 
                           id="jam_masuk" name="jam_masuk" 
                           value="{{ old('jam_masuk', $absensi->jam_masuk) }}">
                    @error('jam_masuk')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-4">
                    <label for="jam_pulang" class="form-label">Jam Pulang</label>
                    <input type="time" class="form-control @error('jam_pulang') is-invalid @enderror" 
                           id="jam_pulang" name="jam_pulang" 
                           value="{{ old('jam_pulang', $absensi->jam_pulang) }}">
                    @error('jam_pulang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="mb-3">
                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                    <option value="hadir" {{ old('status', $absensi->status) == 'hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="izin" {{ old('status', $absensi->status) == 'izin' ? 'selected' : '' }}>Izin</option>
                    <option value="sakit" {{ old('status', $absensi->status) == 'sakit' ? 'selected' : '' }}>Sakit</option>
                    <option value="tanpa keterangan" {{ old('status', $absensi->status) == 'tanpa keterangan' ? 'selected' : '' }}>Tanpa Keterangan</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea class="form-control @error('keterangan') is-invalid @enderror" 
                          id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $absensi->keterangan) }}</textarea>
                @error('keterangan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.absensi.rekap') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection