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
            ['email' => 'admin@cangkir.com'],
            [
                'name' => 'Riko',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );

        $stations = [
            'Stasiun Klimatologi Mempawah',
            'Stasiun Meteorologi Supadio',
            'Stasiun Meteorologi Susilo Sintang',
            'Stasiun Meteorologi Pangsuma Kapuas Hulu',
            'Stasiun Meteorologi Rahadi Oesman Ketapang',
            'Stasiun Meteorologi Tebelian Sintang',
        ];

        foreach ($stations as $i => $station) {
            User::firstOrCreate(
                ['email' => 'pengamat'.($i + 1).'@bmkg.go.id'],
                [
                    'name' => $station,
                    'password' => bcrypt('password'),
                    'role' => 'pengamat',
                ]
            );
        }
    }
}
