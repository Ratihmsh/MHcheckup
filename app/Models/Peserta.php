<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peserta extends Model
{
    use HasFactory;

    protected $table = 'peserta';

    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'tanggal_lahir',
        'usia',
        'pendidikan',
        'pekerjaan',
        'status_perkawinan',
        'no_telp',
        'alamat',
        'tujuan_konsultasi',
        'permasalahan',
        'yang_dirasakan',
        'harapan',
        'tanggal_pemeriksaan'
    ];

    // RELASI
    public function jawaban()
    {
        return $this->hasOne(Jawaban::class);
    }

    public function hasil()
    {
        return $this->hasOne(Hasil::class);
    }
}
