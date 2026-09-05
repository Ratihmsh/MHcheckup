<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DinamikaPsikologis extends Model
{
    use HasFactory;

    protected $table = 'dinamika_psikologi';

    protected $fillable = [
        'type',
        'level',
        'dinamika_psikologis'
    ];

}
