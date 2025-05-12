<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji - {{ $gaji->karyawan->user->name }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { margin: 0; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 5px 0; }
        .detail-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .detail-table th, .detail-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .detail-table th { background-color: #f4f4f4; }
        .text-right { text-align: right; }
        .signature { margin-top: 50px; text-align: right; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>SLIP GAJI</h1>
            <h2>PT. NAMA PERUSAHAAN</h2>
            <p>Periode: {{ DateTime::createFromFormat('!m', $gaji->bulan)->format('F') }} {{ $gaji->tahun }}</p>
        </div>
        
        <table class="info-table">
            <tr>
                <td width="150">Nama Karyawan</td>
                <td>: {{ $gaji->karyawan->user->name }}</td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>: {{ $gaji->karyawan->nik }}</td>
            </tr>
            <tr>
                <td>Posisi</td>
                <td>: {{ $gaji->karyawan->posisi }}</td>
            </tr>
        </table>
        
        <table class="detail-table">
            <thead>
                <tr>
                    <th colspan="2">DETAIL ABSENSI</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Total Hadir</td>
                    <td class="text-right">{{ $gaji->total_hadir }} hari</td>
                </tr>
                <tr>
                    <td>Total Izin</td>
                    <td class="text-right">{{ $gaji->total_izin }} hari</td>
                </tr>
                <tr>
                    <td>Total Sakit</td>
                    <td class="text-right">{{ $gaji->total_sakit }} hari</td>
                </tr>
                <tr>
                    <td>Total Tanpa Keterangan</td>
                    <td class="text-right">{{ $gaji->total_tanpa_keterangan }} hari</td>
                </tr>
            </tbody>
        </table>
        
        <table class="detail-table">
            <thead>
                <tr>
                    <th colspan="2">PERHITUNGAN GAJI</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Gaji Pokok</td>
                    <td class="text-right">Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Potongan</td>
                    <td class="text-right">Rp {{ number_format($gaji->potongan, 0, ',', '.') }}</td>
                </tr>
                <tr style="font-weight: bold;">
                    <td>Gaji Bersih</td>
                    <td class="text-right">Rp {{ number_format($gaji->gaji_bersih, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
        
        @if($gaji->keterangan_gaji)
        <p><strong>Keterangan:</strong> {{ $gaji->keterangan_gaji }}</p>
        @endif
        
        <div class="signature">
            <p>Jakarta, {{ now()->format('d F Y') }}</p>
            <br><br><br>
            <p>( ___________________ )</p>
            <p>HRD Manager</p>
        </div>
        
        <div class="text-center no-print" style="margin-top: 30px;">
            <button onclick="window.print()" class="btn btn-primary">Cetak</button>
            <a href="{{ route('admin.gaji.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</body>
</html>