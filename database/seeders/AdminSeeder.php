<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user if not exists
        User::updateOrCreate(
            ['email' => 'admin@maknende.edu'],
            [
                'name' => 'Admin System',
                'email' => 'admin@maknende.edu',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'verification_status' => 'verified',
                'verified_at' => now(),
            ]
        );
        
        $this->command->info('Admin user created successfully!');
    }
}