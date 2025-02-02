<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventoryType extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('inventory_types')->insert([
            ['id' => 1, 'name' => 'Ford', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Strada', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Apc Wheeled Inf Carrier - Unamed (Class I)', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'VAB-NG / APC', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Truck Utility Cargo Under 1,5 Ton', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'Automobile (4x4)', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'name' => 'Buses (12 Passengers and Less)', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'name' => 'Maintenance', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 9, 'name' => 'APC Wheeled INF Carrier Unarmour (Class II)', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'name' => 'Truck Utility Cargo Under (1,5 Ton)', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'name' => 'Truck Water', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'name' => 'Ambulance', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 13, 'name' => 'Jeep (4x4)', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 14, 'name' => 'Truck Utility/Cargo (Under 1,5 Ton)', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 15, 'name' => 'Truck Utility/Cargo Under (1,5 - 2,4 Ton)', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 16, 'name' => 'Recovery', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 17, 'name' => 'Medium Cargo Single Axle', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 18, 'name' => 'Water Trailer (2.000 to 7000 Liters)', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 19, 'name' => 'Serviceing Trailer', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 20, 'name' => 'Jeep Military 4x4 Ford Everest (Tahun 2011)', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 21, 'name' => 'Jeep Military 4x4 Toyota Fortuner (Tahun 2018)', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 22, 'name' => 'Renault Trafic (Tahun 2005)', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 23, 'name' => 'Refrigerator (Container 1)', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 24, 'name' => 'Refrigerator (Container 2)', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 25, 'name' => 'Isuzu ELF', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 26, 'name' => 'Mitsubishi 100', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 27, 'name' => 'Isuzu FTR33KE2', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 28, 'name' => 'Isuzu NPS', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 29, 'name' => 'Mitsubishi Strada Triton', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 30, 'name' => 'Semi Trailer', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 31, 'name' => 'Generator 42,5 KVA', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 32, 'name' => 'Generator 13 KVA', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 33, 'name' => 'Freezer Kontainer MP 09', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 34, 'name' => 'Kontainer MP 02', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 35, 'name' => 'Kontainer MP 03', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 36, 'name' => 'Kontainer MP 04', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 37, 'name' => 'Kontainer MP 05', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 38, 'name' => 'Kontainer MP 06', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 39, 'name' => 'Kontainer MP 07', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 40, 'name' => 'Kontainer MP 08', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 41, 'name' => 'Kontainer MP 10', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 42, 'name' => 'Other Containers', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 43, 'name' => 'APC AMB', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 44, 'name' => 'VAB-NG/APC CO', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 45, 'name' => 'APC Wheeled INF Carrier Unarmour (Class I)', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 46, 'name' => 'Reconnaissance Vehicles - Wheeled Up To 25 MM', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 47, 'name' => 'Ambulance 4x4 (Military Pattern)', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 48, 'name' => 'Automobile 4x4', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 49, 'name' => 'Buses (13 - 24 Passengers)', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 50, 'name' => 'Truck Water 5-10 KL (5000 L)', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 51, 'name' => 'Truck Water (8000 L)', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 52, 'name' => 'Truck Tanker 5-10 KL', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 53, 'name' => 'HMLTV', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 54, 'name' => 'Jeep Military Radio', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 55, 'name' => 'Truck Maintenance Light', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 56, 'name' => 'Unimog', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 57, 'name' => 'LIAZ', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 58, 'name' => 'Truck Recovery 6x8', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 59, 'name' => 'Escavator', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 60, 'name' => 'Fire Truck', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 61, 'name' => 'Forklift Light 1,5 Ton', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 62, 'name' => 'Forklift Medium 1,5 Ton', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 63, 'name' => 'Run Flat Tire Mobile Machine', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 64, 'name' => 'Fuel Trailer / Semi Trailer', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
