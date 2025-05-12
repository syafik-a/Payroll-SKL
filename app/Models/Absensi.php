<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $karyawan_id
 * @property \Illuminate\Support\Carbon $tanggal
 * @property string|null $jam_masuk
 * @property string|null $jam_pulang
 * @property string $status
 * @property string|null $keterangan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Karyawan $karyawan
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi whereJamMasuk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi whereJamPulang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi whereKaryawanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi whereKeterangan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi whereTanggal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Absensi whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Absensi extends Model
{
    use HasFactory;

    protected $table = 'absensi'; // Eksplisit nama tabel

    protected $fillable = [
        'karyawan_id',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        // 'jam_masuk' => 'datetime:H:i', // Jika ingin format spesifik saat casting
        // 'jam_pulang' => 'datetime:H:i',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}