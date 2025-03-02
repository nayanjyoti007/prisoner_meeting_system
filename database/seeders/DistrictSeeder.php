<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = [
            ['dist_name' => 'Kamrup'],
            ['dist_name' => 'Sonitpur'],
            ['dist_name' => 'Cachar'],
            ['dist_name' => 'Dibrugarh'],
            ['dist_name' => 'Jorhat'],
            ['dist_name' => 'Nagaon'],
            ['dist_name' => 'Nalbari'],
            ['dist_name' => 'Barpeta'],
            ['dist_name' => 'Kokrajhar'],
            ['dist_name' => 'Dhubri'],
            ['dist_name' => 'Goalpara'],
            ['dist_name' => 'Darrang'],
            ['dist_name' => 'Hailakandi'],
            ['dist_name' => 'Karimganj'],
            ['dist_name' => 'Lakhimpur'],
            ['dist_name' => 'Sivasagar'],
            ['dist_name' => 'Golaghat'],
            ['dist_name' => 'Majuli'],
            ['dist_name' => 'Abhayapuri'],
            ['dist_name' => 'Diphu'],
            ['dist_name' => 'Hamren'],
            ['dist_name' => 'Biswanath'],
            ['dist_name' => 'Dhemaji'],
            ['dist_name' => 'Morigaon'],
            ['dist_name' => 'Charaideo'],
            ['dist_name' => 'Tinsukia'],
            ['dist_name' => 'Sadiya'],
            ['dist_name' => 'Udalguri'],
            ['dist_name' => 'Hojai'],
            ['dist_name' => 'Baksa'],
            ['dist_name' => 'Dima Hasao'],
        ];

        DB::table('district_masters')->insert($districts);
    }
}
