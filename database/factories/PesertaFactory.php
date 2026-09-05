<?php

namespace Database\Factories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Peserta>
 */
class PesertaFactory extends Factory
{
    public function definition(): array
    {
        $namaDepan = ['Budi', 'Siti', 'Andi', 'Rina', 'Dewi', 'Agus', 'Putri', 'Rizky', 'Dian', 'Fajar'];
        $namaBelakang = ['Santoso', 'Wijaya', 'Saputra', 'Pratama', 'Lestari', 'Hidayat', 'Permata'];

        $kota = ['Surabaya', 'Malang', 'Sidoarjo', 'Gresik', 'Jombang'];
        $jalan = ['Jl. Merdeka', 'Jl. Sudirman', 'Jl. Diponegoro', 'Jl. Ahmad Yani'];

        return [
            'nama' => $this->faker->randomElement($namaDepan) . ' ' . $this->faker->randomElement($namaBelakang),
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'tanggal_lahir' => $this->faker->date(),
            'usia' => $this->faker->numberBetween(18, 50) . ' Tahun ' . $this->faker->numberBetween(0, 11) . ' Bulan',
            'pendidikan' => $this->faker->randomElement(['SMA', 'D3', 'S1']),
            'pekerjaan' => $this->faker->randomElement([
                'Mahasiswa', 'Karyawan Swasta', 'Wiraswasta', 'Guru', 'Freelancer'
            ]),
            'status_perkawinan' => $this->faker->randomElement(['Belum Menikah', 'Menikah', 'Cerai']),
            'no_telp' => '08' . $this->faker->numberBetween(111111111, 999999999),
            'alamat' => $this->faker->randomElement($jalan) . ' No.' . rand(1, 200) . ', ' .
                         $this->faker->randomElement($kota),
            'tujuan_konsultasi' => $this->faker->randomElement([
                'Konsultasi Pribadi',
                'Masalah Keluarga',
                'Stres Akademik',
                'Kecemasan Berlebih'
            ]),
            'permasalahan' => $this->faker->randomElement([
                'Sering merasa cemas tanpa sebab',
                'Kesulitan tidur',
                'Tekanan pekerjaan meningkat',
                'Masalah dalam hubungan'
            ]),
            'yang_dirasakan' => $this->faker->randomElement([
                'Gelisah dan sulit fokus',
                'Mudah marah',
                'Merasa lelah terus-menerus',
                'Tidak bersemangat'
            ]),
            'harapan' => $this->faker->randomElement([
                'Ingin lebih tenang',
                'Mengurangi kecemasan',
                'Memperbaiki kondisi mental',
                'Lebih produktif'
            ]),
            'tanggal_pemeriksaan' => $this->faker->dateTimeBetween('-7 days', 'now'),
        ];
    }
}
