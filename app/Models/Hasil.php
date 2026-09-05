<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hasil extends Model
{
    use HasFactory;

    protected $table = 'hasil';

    protected $fillable = [
        'peserta_id',
        'skor_depresi',
        'skor_kecemasan',
        'skor_stres',
        'kategori_depresi',
        'kategori_kecemasan',
        'kategori_stres',
        // 'dinamika_psikologis',
        // 'saran_rekomendasi',
    ];

    protected $casts = [
        'dinamika_psikologis' => 'array',
        'saran_rekomendasi'   => 'array',
    ];

    // RELASI
    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }
    public function getDinamikaPsikologis($type, $level)
    {
        return DinamikaPsikologis::where('type', $type)
            ->where('level', $level)
            ->value('dinamika_psikologis');
    }

    public function getSaranRekomendasi($type, $level)
    {
        return SaranRekomendasi::where('type', $type)
            ->where('level', $level)
            ->value('saran_rekomendasi');
    }
}
