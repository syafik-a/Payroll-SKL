<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji - {{ $gaji->karyawan->user->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body class="font-sans">
    <div class="max-w-2xl mx-auto p-5">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold">SLIP GAJI</h1>
            <h2 class="text-2xl font-medium">PT. NAMA PERUSAHAAN</h2>
            <p>Periode: {{ DateTime::createFromFormat('!m', $gaji->bulan)->format('F') }} {{ $gaji->tahun }}</p>
        </div>

        <table class="min-w-full border border-gray-300 mb-5">
            <tbody>
                <tr>
                    <td class="border px-4 py-2 w-1/3">Nama Karyawan</td>
                    <td class="border px-4 py-2">: {{ $gaji->karyawan->user->name }}</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">NIK</td>
                    <td class="border px-4 py-2">: {{ $gaji->karyawan->nik }}</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">Posisi</td>
                    <td class="border px-4 py-2">: {{ $gaji->karyawan->posisi }}</td>
                </tr>
            </tbody>
        </table>

        <table class="min-w-full border-collapse border border-gray-300 mb-5">
            <thead>
                <tr>
                    <th colspan="2" class="border text-left px-4 py-2 bg-gray-200">DETAIL ABSENSI</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border px-4 py-2">Total Hadir</td>
                    <td class="border px-4 py-2 text-right">{{ $gaji->total_hadir }} hari</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">Total Izin</td>
                    <td class="border px-4 py-2 text-right">{{ $gaji->total_izin }} hari</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">Total Sakit</td>
                    <td class="border px-4 py-2 text-right">{{ $gaji->total_sakit }} hari</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">Total Tanpa Keterangan</td>
                    <td class="border px-4 py-2 text-right">{{ $gaji->total_tanpa_keterangan }} hari</td>
                </tr>
            </tbody>
        </table>

        <table class="min-w-full border-collapse border border-gray-300 mb-5">
            <thead>
                <tr>
                    <th colspan="2" class="border text-left px-4 py-2 bg-gray-200">PERHITUNGAN GAJI</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border px-4 py-2">Gaji Pokok</td>
                    <td class="border px-4 py-2 text-right">Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td class="border px-4 py-2">Potongan</td>
                    <td class="border px-4 py-2 text-right">Rp {{ number_format($gaji->potongan, 0, ',', '.') }}</td>
                </tr>
                <tr class="font-bold">
                    <td class="border px-4 py-2">Gaji Bersih</td>
                    <td class="border px-4 py-2 text-right">Rp {{ number_format($gaji->gaji_bersih, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        @if($gaji->keterangan_gaji)
        <p><strong>Keterangan:</strong> {{ $gaji->keterangan_gaji }}</p>
        @endif

        <div class="text-right mt-16">
            <p>Jakarta, {{ now()->format('d F Y') }}</p>
            <br><br><br>
            <p>( ___________________ )</p>
            <p>HRD Manager</p>
        </div>

        <div class="text-center mt-8 no-print">
            <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Cetak</button>
            <a href="{{ route('admin.gaji.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Kembali</a>
        </div>
    </div>
</body>
</html>