<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
class PersonaliaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID'); // Menggunakan locale Indonesia
        $data = [];

        for ($i = 1; $i <= 85; $i++) {
            $data[] = [
                'nama' => $faker->name,
                'nik' => $faker->unique()->numerify('################'), // 16 digit
                'jabatan' => $faker->randomElement([
                    'JABATAN 001',
                    'JABATAN 002',
                    'JABATAN 003',
                    'JABATAN 004',
                    'JABATAN 005'
                ]),
                'satgas' => $faker->randomElement([
                    'UNIFIL',
                    'KIZI MINUSCA',
                    'KIZI MONUSCO',
                    'BGC MONUSCO',
                ]),
                'join_date' => $faker->date('Y-m-d', 'now'),
                'status' => $faker->randomElement([1,0]),
            ];
        }

        // Insert data ke tabel
        DB::table('personalia')->insert($data);
    }
}
