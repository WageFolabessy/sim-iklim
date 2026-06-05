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
        User::firstOrCreate(
            ['email' => 'admin@pmg.com'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );

        User::firstOrCreate(
            ['email' => 'pengamat@pmg.com'],
            [
                'name' => 'Petugas Pengamat',
                'password' => bcrypt('password'),
                'role' => 'pengamat',
            ]
        );
    }
}
