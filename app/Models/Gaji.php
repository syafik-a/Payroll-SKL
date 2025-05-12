<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $karyawan_id
 * @property int $bulan
 * @property string $tahun
 * @property int $total_hadir
 * @property int $total_izin
 * @property int $total_sakit
 * @property int $total_tanpa_keterangan
 * @property numeric $gaji_pokok
 * @property numeric $potongan
 * @property numeric $gaji_bersih
 * @property string|null $keterangan_gaji
 * @property \Illuminate\Support\Carbon|null $tanggal_pembayaran
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Karyawan $karyawan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gaji newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gaji newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gaji query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gaji whereBulan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gaji whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gaji whereGajiBersih($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gaji whereGajiPokok($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gaji whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gaji whereKaryawanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gaji whereKeteranganGaji($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gaji wherePotongan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gaji whereTahun($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gaji whereTanggalPembayaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gaji whereTotalHadir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gaji whereTotalIzin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gaji whereTotalSakit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gaji whereTotalTanpaKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Gaji whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Gaji extends Model
{
    use HasFactory;

    protected $table = 'gaji'; // Eksplisit nama tabel

    protected $fillable = [
        'karyawan_id',
        'bulan',
        'tahun',
        'total_hadir',
        'total_izin',
        'total_sakit',
        'total_tanpa_keterangan',
        'gaji_pokok',
        'potongan',
        'gaji_bersih',
        'keterangan_gaji',
        'tanggal_pembayaran',
    ];

    protected $casts = [
        'gaji_pokok' => 'decimal:2',
        'potongan' => 'decimal:2',
        'gaji_bersih' => 'decimal:2',
        'tanggal_pembayaran' => 'date',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}