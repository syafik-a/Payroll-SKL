<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    public function presensiMasuk(Request $request)
    {
        $karyawan = Auth::user()->karyawan;
        if (!$karyawan) {
            return response()->json(['error' => 'Data karyawan tidak ditemukan.'], 404);
        }

        $today = Carbon::today();
        $absensiHariIni = Absensi::where('karyawan_id', $karyawan->id)
                            ->whereDate('tanggal', $today)
                            ->first();

        if ($absensiHariIni && $absensiHariIni->jam_masuk) {
            return response()->json(['message' => 'Anda sudah melakukan presensi masuk hari ini.'], 400);
        }
        
        if (!$absensiHariIni) {
             $absensiHariIni = Absensi::create([
                'karyawan_id' => $karyawan->id,
                'tanggal' => $today,
                'jam_masuk' => Carbon::now()->format('H:i:s'),
                'status' => 'hadir', // Default status saat masuk
            ]);
        } else {
             $absensiHariIni->jam_masuk = Carbon::now()->format('H:i:s');
             $absensiHariIni->status = 'hadir'; // Pastikan status hadir
             $absensiHariIni->save();
        }


        return redirect()->back()->with('success', 'Presensi masuk berhasil.');
        // return response()->json(['message' => 'Presensi masuk berhasil.', 'data' => $absensiHariIni]);
    }

    public function presensiPulang(Request $request)
    {
        $karyawan = Auth::user()->karyawan;
         if (!$karyawan) {
            return response()->json(['error' => 'Data karyawan tidak ditemukan.'], 404);
        }

        $today = Carbon::today();
        $absensiHariIni = Absensi::where('karyawan_id', $karyawan->id)
                            ->whereDate('tanggal', $today)
                            ->first();

        if (!$absensiHariIni || !$absensiHariIni->jam_masuk) {
            return response()->json(['message' => 'Anda belum melakukan presensi masuk hari ini.'], 400);
        }

        if ($absensiHariIni->jam_pulang) {
            return response()->json(['message' => 'Anda sudah melakukan presensi pulang hari ini.'], 400);
        }

        $absensiHariIni->jam_pulang = Carbon::now()->format('H:i:s');
        $absensiHariIni->save();

        return redirect()->back()->with('success', 'Presensi pulang berhasil.');
        // return response()->json(['message' => 'Presensi pulang berhasil.', 'data' => $absensiHariIni]);
    }

    public function riwayatAbsensi()
    {
        $karyawan = Auth::user()->karyawan;
        if (!$karyawan) {
            return response()->json(['error' => 'Data karyawan tidak ditemukan.'], 404);
        }
        $riwayat = Absensi::where('karyawan_id', $karyawan->id)
                        ->orderBy('tanggal', 'desc')
                        ->paginate(10); // atau get()

        return view('karyawan.absensi.riwayat', compact('riwayat'));
        // return response()->json(['message' => 'Riwayat Absensi Karyawan', 'data' => $riwayat]);
    }
}