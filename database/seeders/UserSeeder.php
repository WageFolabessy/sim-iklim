<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@cangkir.com'],
            [
                'name' => 'Riko',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );
        
        \App\Models\User::firstOrCreate(
            ['email' => 'pengamat@bmkg.go.id'],
            [
                'name' => 'Petugas Supadio',
                'password' => bcrypt('password'),
                'role' => 'pengamat',
            ]
        );
    }
}
