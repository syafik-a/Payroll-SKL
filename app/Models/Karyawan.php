<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property string $nik
 * @property string|null $alamat
 * @property string|null $no_telepon
 * @property string $posisi
 * @property \Illuminate\Support\Carbon $tanggal_masuk
 * @property numeric $gaji_pokok
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Absensi> $absensi
 * @property-read int|null $absensi_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Gaji> $gaji
 * @property-read int|null $gaji_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereGajiPokok($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereNik($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereNoTelepon($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan wherePosisi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereTanggalMasuk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Karyawan whereUserId($value)
 * @mixin \Eloquent
 */
class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan'; // Eksplisit nama tabel

    protected $fillable = [
        'user_id',
        'nik',
        'alamat',
        'no_telepon',
        'posisi',
        'tanggal_masuk',
        'gaji_pokok',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'gaji_pokok' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function absensi()
    {
        return $this->hasMany(Absensi::class);
    }

    public function gaji()
    {
        return $this->hasMany(Gaji::class);
    }
}