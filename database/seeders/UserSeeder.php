<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Buat user ustad
        User::create([
            'name' => 'Ahmad',
            'email' => 'ustad@maknende.edu',
            'password' => Hash::make('password'),
            'role' => 'ustad',
        ]);

        // Buat user santri contoh
        User::create([
            'name' => 'Santri',
            'email' => 'santri@maknende.edu',
            'password' => Hash::make('password'),
            'role' => 'santri',
            'nisn' => '1234567890',
            'kelas' => 'X',
        ]);
    }
}