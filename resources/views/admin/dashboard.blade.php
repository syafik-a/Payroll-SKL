@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<h1 class="mb-4 text-2xl font-semibold"><i class="fas fa-tachometer-alt"></i> Admin Dashboard</h1>

<div class="grid grid-cols-1 gap-4 md:grid-cols-4">
    <!-- Card Total Karyawan -->
    <div class="bg-blue-600 text-white p-4 rounded-lg shadow">
        <div class="flex justify-between items-center mb-2">
            <div>
                <h6 class="text-lg font-bold">Total Karyawan</h6>
                <h2 class="text-3xl">{{ \App\Models\Karyawan::count() }}</h2>
            </div>
            <div>
                <i class="fas fa-users fa-3x opacity-50"></i>
            </div>
        </div>
        <a href="{{ route('admin.karyawan.index') }}" class="text-white text-sm hover:underline">
            Lihat Detail <i class="fas fa-arrow-right"></i>
        </a>
    </div>
    
    <!-- Card Hadir Hari Ini -->
    <div class="bg-green-600 text-white p-4 rounded-lg shadow">
        <div class="flex justify-between items-center mb-2">
            <div>
                <h6 class="text-lg font-bold">Hadir Hari Ini</h6>
                <h2 class="text-3xl">{{ \App\Models\Absensi::whereDate('tanggal', today())->where('status', 'hadir')->count() }}</h2>
            </div>
            <div>
                <i class="fas fa-user-check fa-3x opacity-50"></i>
            </div>
        </div>
        <a href="{{ route('admin.absensi.rekap') }}" class="text-white text-sm hover:underline">
            Lihat Detail <i class="fas fa-arrow-right"></i>
        </a>
    </div>
    
    <!-- Card Izin/Sakit Hari Ini -->
    <div class="bg-yellow-600 text-white p-4 rounded-lg shadow">
        <div class="flex justify-between items-center mb-2">
            <div>
                <h6 class="text-lg font-bold">Izin/Sakit Hari Ini</h6>
                <h2 class="text-3xl">{{ \App\Models\Absensi::whereDate('tanggal', today())->whereIn('status', ['izin', 'sakit'])->count() }}</h2>
            </div>
            <div>
                <i class="fas fa-user-clock fa-3x opacity-50"></i>
            </div>
        </div>
        <a href="{{ route('admin.absensi.rekap') }}" class="text-white text-sm hover:underline">
            Lihat Detail <i class="fas fa-arrow-right"></i>
        </a>
    </div>
    
    <!-- Card Total Gaji Bulan Ini -->
    <div class="bg-blue-800 text-white p-4 rounded-lg shadow">
        <div class="flex justify-between items-center mb-2">
            <div>
                <h6 class="text-lg font-bold">Total Gaji Bulan Ini</h6>
                @php
                    $totalGaji = \App\Models\Gaji::where('bulan', date('m'))
                        ->where('tahun', date('Y'))
                        ->sum('gaji_bersih');
                @endphp
                <h2 class="text-3xl">Rp {{ number_format($totalGaji, 0, ',', '.') }}</h2>
            </div>
            <div>
                <i class="fas fa-money-bill-wave fa-3x opacity-50"></i>
            </div>
        </div>
        <a href="{{ route('admin.gaji.index') }}" class="text-white text-sm hover:underline">
            Lihat Detail <i class="fas fa-arrow-right"></i>
        </a>
    </div>
</div>

<!-- Chart & Recent Activities -->
<div class="grid grid-cols-1 gap-4 mt-4 md:grid-cols-2">
    <!-- Absensi Hari Ini -->
    <div class="bg-white shadow-md rounded-lg">
        <div class="bg-blue-600 text-white p-4 rounded-t-lg">
            <h5 class="text-lg font-bold"><i class="fas fa-clock mr-2"></i> Absensi Hari Ini</h5>
        </div>
        <div class="p-4">
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">Jam Masuk</th>
                            <th class="px-4 py-2">Jam Pulang</th>
                            <th class="px-4 py-2">Status</th>
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
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $absensi->karyawan->user->name }}</td>
                            <td class="px-4 py-2">{{ $absensi->jam_masuk ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $absensi->jam_pulang ?? '-' }}</td>
                            <td class="px-4 py-2">
                                <span class="bg-{{ $absensi->status == 'hadir' ? 'green' : ($absensi->status == 'izin' ? 'yellow' : 'red') }}-500 text-white rounded-full px-3">
                                    {{ ucfirst($absensi->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center px-4 py-2">Belum ada data absensi hari ini</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="text-center mt-3">
                <a href="{{ route('admin.absensi.rekap') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md">
                    Lihat Semua <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Karyawan Baru -->
    <div class="bg-white shadow-md rounded-lg">
        <div class="bg-green-600 text-white p-4 rounded-t-lg">
            <h5 class="text-lg font-bold"><i class="fas fa-users mr-2"></i> Karyawan Baru</h5>
        </div>
        <div class="p-4">
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">Posisi</th>
                            <th class="px-4 py-2">Tanggal Masuk</th>
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
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $karyawan->user->name }}</td>
                            <td class="px-4 py-2">{{ $karyawan->posisi }}</td>
                            <td class="px-4 py-2">{{ $karyawan->tanggal_masuk->format('d/m/Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center px-4 py-2">Belum ada data karyawan</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="text-center mt-3">
                <a href="{{ route('admin.karyawan.index') }}" class="bg-green-600 text-white px-4 py-2 rounded-md">
                    Lihat Semua <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Chart -->
<div class="bg-white shadow-md rounded-lg mt-4">
    <div class="bg-gray-800 text-white p-4 rounded-t-lg">
        <h5 class="text-lg font-bold"><i class="fas fa-chart-bar mr-2"></i> Statistik Absensi Bulan Ini</h5>
    </div>
    <div class="p-4">
        @php
            $bulanIni = \App\Models\Absensi::whereMonth('tanggal', date('m'))
                ->whereYear('tanggal', date('Y'))
                ->selectRaw('status, COUNT(*) as total')
                ->groupBy('status')
                ->get();
            
            $totalAbsensi = $bulanIni->sum('total');
        @endphp
        
        @if($totalAbsensi > 0)
            <div class="grid grid-cols-1 gap-4 md:grid-cols-4 text-center">
                @foreach($bulanIni as $status)
                <div class="bg-{{ $status->status == 'hadir' ? 'green' : ($status->status == 'izin' ? 'yellow' : ($status->status == 'sakit' ? 'blue' : 'red')) }}-500 text-white p-4 rounded-lg">
                    <h4 class="text-2xl">{{ $status->total }}</h4>
                    <p>{{ ucfirst($status->status) }}</p>
                    <div class="relative mt-2 h-2 bg-gray-200 rounded">
                        <div class="absolute h-full bg-{{ $status->status == 'hadir' ? 'green' : ($status->status == 'izin' ? 'yellow' : ($status->status == 'sakit' ? 'blue' : 'red')) }}-500" 
                             style="width: {{ ($status->total / $totalAbsensi) * 100 }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <p class="text-center">Belum ada data absensi bulan ini</p>
        @endif
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 gap-4 mt-4">
    <div class="bg-white shadow-md rounded-lg">
        <div class="bg-gray-700 text-white p-4 rounded-t-lg">
            <h5 class="mb-0 text-lg font-bold"><i class="fas fa-bolt"></i> Quick Actions</h5>
        </div>
        <div class="p-4">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                <div>
                    <a href="{{ route('admin.karyawan.create') }}" class="block text-center bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-200">
                        <i class="fas fa-user-plus"></i> Tambah Karyawan
                    </a>
                </div>
                <div>
                    <a href="{{ route('admin.absensi.rekap') }}" class="block text-center bg-green-600 text-white py-2 rounded-md hover:bg-green-700 transition duration-200">
                        <i class="fas fa-calendar-check"></i> Rekap Absensi
                    </a>
                </div>
                <div>
                    <a href="{{ route('admin.gaji.index') }}" class="block text-center bg-yellow-600 text-white py-2 rounded-md hover:bg-yellow-700 transition duration-200">
                        <i class="fas fa-money-bill"></i> Data Gaji
                    </a>
                </div>
                <div>
                    <form action="{{ route('admin.gaji.hitung') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="bulan" value="{{ date('m') }}">
                        <input type="hidden" name="tahun" value="{{ date('Y') }}">
                        <button type="submit" class="block w-full text-center bg-red-600 text-white py-2 rounded-md hover:bg-red-700 transition duration-200">
                            <i class="fas fa-calculator"></i> Hitung Gaji
                        </button>
                    </form>
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