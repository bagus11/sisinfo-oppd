<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventoryBrand extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('inventory_brands')->insert([
            ['id' => 1, 'name' => 'Mitsubishi Strada Triton', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Mitsubishi Triton', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'VAB - NG / APC', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Ford', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Strada', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'Anoa', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'name' => 'VAB / APC', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'name' => 'Kia Minibus', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'name' => 'Fortuner VRZ', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'name' => 'Hiace Commuter', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'name' => 'Isuzu', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'name' => 'Cargo', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 13, 'name' => 'Ford Everest', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 14, 'name' => 'Hino', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 15, 'name' => 'Isuzu NPS', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 16, 'name' => 'Kia Medium Cargo Single Axle', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 17, 'name' => 'Water Trailer (2.000 to 7000 Liters)', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 18, 'name' => 'Servicing Trailer', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 19, 'name' => 'Toyota', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 20, 'name' => 'Renault', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 21, 'name' => 'Refrigator (Container 1)', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 22, 'name' => 'Refrigator (Container 2)', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 23, 'name' => 'Isuzu FTR33KE2', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 24, 'name' => 'Semi Trailer', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 25, 'name' => 'Generator 42,5 KVA', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 26, 'name' => 'Generator 13 KVA', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 27, 'name' => 'VAB-NG / APC (Ambulance)', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 28, 'name' => 'VAB-NG / APC CO', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 29, 'name' => 'BTR 80 - A', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 30, 'name' => 'Anoa Pindad', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 31, 'name' => 'Sherpa Light Scout', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 32, 'name' => 'Panhard', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 33, 'name' => 'Kia Pregio', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 34, 'name' => 'Toyota Land Cuiser', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 35, 'name' => 'Mitsubishi L300', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 36, 'name' => 'Mitsubishi PS 120', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 37, 'name' => 'Hino 500', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 38, 'name' => 'Ural ATsV-8', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 39, 'name' => 'Dyna Rino', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 40, 'name' => 'Triton (Ambulance)', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 41, 'name' => 'Jeep Ambulance', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 42, 'name' => 'Hilux Ambulance', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 43, 'name' => 'Defender (KOMOB)', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 44, 'name' => 'Unimog', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 45, 'name' => 'Mitsubishi / L-200 Strada', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 46, 'name' => 'Mitsubishi Recovery', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 47, 'name' => 'Bechoe Loader', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 48, 'name' => 'Fire Fighting Truck', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 49, 'name' => 'TCM Forklift 2,5 Ton', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 50, 'name' => 'TCM Forklift 5 Ton', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
