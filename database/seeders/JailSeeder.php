<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $jails = [
            // Central Jails
            ['name' => 'Guwahati, Central Jail', 'district_id' => 1, 'type' => 'Central', 'total_rooms' => rand(5, 10)],
            ['name' => 'Tezpur, Central Jail', 'district_id' => 2, 'type' => 'Central', 'total_rooms' => rand(5, 10)],
            ['name' => 'Silchar, Central Jail', 'district_id' => 3, 'type' => 'Central', 'total_rooms' => rand(5, 10)],
            ['name' => 'Dibrugarh, Central Jail', 'district_id' => 4, 'type' => 'Central', 'total_rooms' => rand(5, 10)],
            ['name' => 'Jorhat, Central Jail', 'district_id' => 5, 'type' => 'Central', 'total_rooms' => rand(5, 10)],
            ['name' => 'Nagaon, Central Jail', 'district_id' => 6, 'type' => 'Central', 'total_rooms' => rand(5, 10)],

            // District Jails
            ['name' => 'Nalbari, District Jail', 'district_id' => 7, 'type' => 'District', 'total_rooms' => rand(3, 6)],
            ['name' => 'Barpeta, District Jail', 'district_id' => 8, 'type' => 'District', 'total_rooms' => rand(3, 6)],
            ['name' => 'Kokrajhar, District Jail', 'district_id' => 9, 'type' => 'District', 'total_rooms' => rand(3, 6)],
            ['name' => 'Dhubri, District Jail', 'district_id' => 10, 'type' => 'District', 'total_rooms' => rand(3, 6)],
            ['name' => 'Goalpara, District Jail', 'district_id' => 11, 'type' => 'District', 'total_rooms' => rand(3, 6)],
            ['name' => 'Mangaldoi, District Jail', 'district_id' => 12, 'type' => 'District', 'total_rooms' => rand(3, 6)],
            ['name' => 'Hailakandi, District Jail', 'district_id' => 13, 'type' => 'District', 'total_rooms' => rand(3, 6)],
            ['name' => 'Karimganj, District Jail', 'district_id' => 14, 'type' => 'District', 'total_rooms' => rand(3, 6)],
            ['name' => 'North Lakhimpur, District Jail', 'district_id' => 15, 'type' => 'District', 'total_rooms' => rand(3, 6)],
            ['name' => 'Sivasagar, District Jail', 'district_id' => 16, 'type' => 'District', 'total_rooms' => rand(3, 6)],
            ['name' => 'Golaghat, District Jail', 'district_id' => 17, 'type' => 'District', 'total_rooms' => rand(3, 6)],
            ['name' => 'Majuli, District Jail', 'district_id' => 18, 'type' => 'District', 'total_rooms' => rand(3, 6)],
            ['name' => 'Abhayapuri, District Jail', 'district_id' => 19, 'type' => 'District', 'total_rooms' => rand(3, 6)],
            ['name' => 'Diphu, District Jail', 'district_id' => 20, 'type' => 'District', 'total_rooms' => rand(3, 6)],
            ['name' => 'Hamren, District Jail', 'district_id' => 21, 'type' => 'District', 'total_rooms' => rand(3, 6)],
            ['name' => 'Biswanath Chariali, District Jail', 'district_id' => 22, 'type' => 'District', 'total_rooms' => rand(3, 6)],
            ['name' => 'Dhemaji, District Jail', 'district_id' => 23, 'type' => 'District', 'total_rooms' => rand(3, 6)],
            ['name' => 'Morigaon, District Jail', 'district_id' => 24, 'type' => 'District', 'total_rooms' => rand(3, 6)],
            ['name' => 'Sonari, District Jail', 'district_id' => 25, 'type' => 'District', 'total_rooms' => rand(3, 6)],
            ['name' => 'Tinsukia, District Jail', 'district_id' => 26, 'type' => 'District', 'total_rooms' => rand(3, 6)],
            ['name' => 'Sadiya, District Jail', 'district_id' => 27, 'type' => 'District', 'total_rooms' => rand(3, 6)],
            ['name' => 'Udalguri, District Jail', 'district_id' => 28, 'type' => 'District', 'total_rooms' => rand(3, 6)],

            // Special Jail
            ['name' => 'Nagaon, Special Jail', 'district_id' => 29, 'type' => 'Special', 'total_rooms' => rand(2, 5)],

            // Open Air Jail
            ['name' => 'Jorhat, Open Air Jail', 'district_id' => 30, 'type' => 'Open Air', 'total_rooms' => rand(2, 5)],

            // Sub Jail
            ['name' => 'Haflong, Sub Jail', 'district_id' => 31, 'type' => 'Sub-Jail', 'total_rooms' => rand(2, 5)],
        ];

        DB::table('jails')->insert($jails);
    }
}
