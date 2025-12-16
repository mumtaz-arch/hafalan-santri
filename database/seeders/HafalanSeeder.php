<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hafalan;

class HafalanSeeder extends Seeder
{
    public function run()
    {
        $hafalans = [
            ['nama_surah' => 'An-Naba', 'nomor_surah' => 78, 'jumlah_ayat' => 40],
            ['nama_surah' => 'An-Nazi\'at', 'nomor_surah' => 79, 'jumlah_ayat' => 46],
            ['nama_surah' => 'Abasa', 'nomor_surah' => 80, 'jumlah_ayat' => 42],
            ['nama_surah' => 'At-Takwir', 'nomor_surah' => 81, 'jumlah_ayat' => 29],
            ['nama_surah' => 'Al-Infitar', 'nomor_surah' => 82, 'jumlah_ayat' => 19],
            ['nama_surah' => 'Al-Mutaffifin', 'nomor_surah' => 83, 'jumlah_ayat' => 36],
            ['nama_surah' => 'Al-Insyiqaq', 'nomor_surah' => 84, 'jumlah_ayat' => 25],
            ['nama_surah' => 'Al-Buruj', 'nomor_surah' => 85, 'jumlah_ayat' => 22],
            ['nama_surah' => 'At-Tariq', 'nomor_surah' => 86, 'jumlah_ayat' => 17],
            ['nama_surah' => 'Al-A\'la', 'nomor_surah' => 87, 'jumlah_ayat' => 19],
            ['nama_surah' => 'Al-Ghashiyah', 'nomor_surah' => 88, 'jumlah_ayat' => 26],
            ['nama_surah' => 'Al-Fajr', 'nomor_surah' => 89, 'jumlah_ayat' => 30],
            ['nama_surah' => 'Al-Balad', 'nomor_surah' => 90, 'jumlah_ayat' => 20],
            ['nama_surah' => 'Asy-Syams', 'nomor_surah' => 91, 'jumlah_ayat' => 15],
            ['nama_surah' => 'Al-Lail', 'nomor_surah' => 92, 'jumlah_ayat' => 21],
            ['nama_surah' => 'Ad-Duhaa', 'nomor_surah' => 93, 'jumlah_ayat' => 11],
            ['nama_surah' => 'Asy-Syarh', 'nomor_surah' => 94, 'jumlah_ayat' => 8],
            ['nama_surah' => 'At-Tin', 'nomor_surah' => 95, 'jumlah_ayat' => 8],
            ['nama_surah' => 'Al-‘Alaq', 'nomor_surah' => 96, 'jumlah_ayat' => 19],
            ['nama_surah' => 'Al-Qadr', 'nomor_surah' => 97, 'jumlah_ayat' => 5],
            ['nama_surah' => 'Al-Bayyinah', 'nomor_surah' => 98, 'jumlah_ayat' => 8],
            ['nama_surah' => 'Az-Zalzalah', 'nomor_surah' => 99, 'jumlah_ayat' => 8],
            ['nama_surah' => 'Al-‘Adiyat', 'nomor_surah' => 100, 'jumlah_ayat' => 11],
            ['nama_surah' => 'Al-Qari‘ah', 'nomor_surah' => 101, 'jumlah_ayat' => 11],
            ['nama_surah' => 'At-Takatsur', 'nomor_surah' => 102, 'jumlah_ayat' => 8],
            ['nama_surah' => 'Al-‘Asr', 'nomor_surah' => 103, 'jumlah_ayat' => 3],
            ['nama_surah' => 'Al-Humazah', 'nomor_surah' => 104, 'jumlah_ayat' => 9],
            ['nama_surah' => 'Al-Fil', 'nomor_surah' => 105, 'jumlah_ayat' => 5],
            ['nama_surah' => 'Quraisy', 'nomor_surah' => 106, 'jumlah_ayat' => 4],
            ['nama_surah' => 'Al-Ma’un', 'nomor_surah' => 107, 'jumlah_ayat' => 7],
            ['nama_surah' => 'Al-Kautsar', 'nomor_surah' => 108, 'jumlah_ayat' => 3],
            ['nama_surah' => 'Al-Kafirun', 'nomor_surah' => 109, 'jumlah_ayat' => 6],
            ['nama_surah' => 'An-Nashr', 'nomor_surah' => 110, 'jumlah_ayat' => 3],
            ['nama_surah' => 'Al-Lahab', 'nomor_surah' => 111, 'jumlah_ayat' => 5],
            ['nama_surah' => 'Al-Ikhlas', 'nomor_surah' => 112, 'jumlah_ayat' => 4],
            ['nama_surah' => 'Al-Falaq', 'nomor_surah' => 113, 'jumlah_ayat' => 5],
            ['nama_surah' => 'An-Nas', 'nomor_surah' => 114, 'jumlah_ayat' => 6],
        ];

        foreach ($hafalans as $hafalan) {
            Hafalan::create($hafalan);
        }
    }
}
