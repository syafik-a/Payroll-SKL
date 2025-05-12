<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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