<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gaji;
use App\Models\Karyawan;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminGajiController extends Controller // Nama kelas diperbaiki
{
    // Asumsi potongan per hari tidak hadir tanpa keterangan adalah 1/22 dari gaji pokok
    const POTONGAN_PER_HARI_FAKTOR = 1/22; // Atau bisa disimpan di config

    public function index(Request $request)
    {
        $bulan = $request->input('bulan', Carbon::now()->month);
        $tahun = $request->input('tahun', Carbon::now()->year);

        $gajis = Gaji::with('karyawan.user')
                    ->where('bulan', $bulan)
                    ->where('tahun', $tahun)
                    ->orderBy('karyawan_id')
                    ->paginate(15);
        
        return view('admin.gaji.index', compact('gajis', 'bulan', 'tahun'));
        // return response()->json(['data' => $gajis, 'bulan' => $bulan, 'tahun' => $tahun]);
    }


    public function prosesHitungGajiBulanan(Request $request)
    {
        $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:'.(date('Y')-5).'|max:'.(date('Y')+1), // Batas tahun
        ]);

        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $karyawans = Karyawan::where('tanggal_masuk', '<=', Carbon::createFromDate($tahun, $bulan)->endOfMonth())->get(); // Hanya karyawan yang sudah masuk

        DB::beginTransaction();
        try {
            foreach ($karyawans as $karyawan) {
                $absensiKaryawan = Absensi::where('karyawan_id', $karyawan->id)
                                        ->whereMonth('tanggal', $bulan)
                                        ->whereYear('tanggal', $tahun)
                                        ->get();

                $totalHadir = $absensiKaryawan->where('status', 'hadir')->count();
                $totalIzin = $absensiKaryawan->where('status', 'izin')->count();
                $totalSakit = $absensiKaryawan->where('status', 'sakit')->count();
                $totalTanpaKeterangan = $absensiKaryawan->where('status', 'tanpa keterangan')->count();
                
                // Bisa juga menghitung hari kerja dalam sebulan, lalu jika tidak ada data absensi pada hari kerja dianggap 'tanpa keterangan'
                // Untuk simplisitas, kita hitung dari data absensi yang ada.

                $gajiPokok = $karyawan->gaji_pokok;
                
                // Contoh: Potongan hanya untuk 'tanpa keterangan'
                // Anda bisa membuat aturan lebih kompleks, misal potongan untuk sakit setelah N hari, dll.
                $potonganPerHari = $gajiPokok * self::POTONGAN_PER_HARI_FAKTOR;
                $totalPotongan = $totalTanpaKeterangan * $potonganPerHari;
                
                $gajiBersih = $gajiPokok - $totalPotongan;

                Gaji::updateOrCreate(
                    [
                        'karyawan_id' => $karyawan->id,
                        'bulan' => $bulan,
                        'tahun' => $tahun,
                    ],
                    [
                        'total_hadir' => $totalHadir,
                        'total_izin' => $totalIzin,
                        'total_sakit' => $totalSakit,
                        'total_tanpa_keterangan' => $totalTanpaKeterangan,
                        'gaji_pokok' => $gajiPokok,
                        'potongan' => $totalPotongan,
                        'gaji_bersih' => $gajiBersih,
                        'tanggal_pembayaran' => Carbon::now()->endOfMonth() // Atau tanggal spesifik
                    ]
                );
            }
            DB::commit();
            return redirect()->route('admin.gaji.index', ['bulan' => $bulan, 'tahun' => $tahun])->with('success', 'Perhitungan gaji berhasil diproses.');
            // return response()->json(['message' => 'Perhitungan gaji berhasil diproses.']);
        } catch (\Exception $e) {
            DB::rollBack();
            // return back()->with('error', 'Gagal memproses gaji: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal memproses gaji.', 'error' => $e->getMessage()], 500);
        }
    }

    public function cetakSlipGaji(Request $request, $gaji_id)
    {
        $gaji = Gaji::with('karyawan.user')->findOrFail($gaji_id);

        // Di sini Anda akan menyiapkan data untuk PDF
        // Contoh:
        // $pdf = PDF::loadView('admin.gaji.slip_pdf', compact('gaji'));
        // return $pdf->download('slip-gaji-'.$gaji->karyawan->nik.'-'.$gaji->bulan.'-'.$gaji->tahun.'.pdf');

        // Untuk sekarang, kembalikan data JSON saja
        return response()->json(['message' => 'Data untuk slip gaji', 'data' => $gaji]);
    }
}