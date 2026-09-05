<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jawaban extends Model
{
    use HasFactory;

    protected $table = 'jawaban';

    protected $guarded = []; // biar semua bisa diisi (karena banyak kolom)

    // RELASI
    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }
}
