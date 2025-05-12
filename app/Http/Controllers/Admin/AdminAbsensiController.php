<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminAbsensiController extends Controller
{
    public function rekapAbsensi(Request $request)
    {
        $bulan = $request->input('bulan', Carbon::now()->month);
        $tahun = $request->input('tahun', Carbon::now()->year);

        $absensi = Absensi::with('karyawan.user')
                        ->whereMonth('tanggal', $bulan)
                        ->whereYear('tanggal', $tahun)
                        ->orderBy('tanggal', 'desc')
                        ->orderBy('karyawan_id')
                        ->paginate(20);

        return view('admin.absensi.rekap', compact('absensi', 'bulan', 'tahun'));
    }

    public function edit(Absensi $absensi)
    {
        return view('admin.absensi.edit', compact('absensi'));
    }

    public function update(Request $request, Absensi $absensi)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jam_masuk' => 'nullable|date_format:H:i,H:i:s',
            'jam_pulang' => 'nullable|date_format:H:i,H:i:s|after_or_equal:jam_masuk',
            'status' => 'required|in:hadir,izin,sakit,tanpa keterangan',
            'keterangan' => 'nullable|string',
        ]);

        $absensi->update($request->all());

        return redirect()->route('admin.absensi.rekap')->with('success', 'Data absensi berhasil diperbarui.');
    }
}