<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaranRekomendasi extends Model
{
    use HasFactory;

    protected $table = 'saran_rekomendasi';

    protected $fillable = [
        'type',
        'level',
        'saran_rekomendasi'
    ];

}
