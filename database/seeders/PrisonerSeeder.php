<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PrisonerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prisoners = [
            ['name' => 'Rajesh Sharma', 'crime' => 'Theft'],
            ['name' => 'Amit Patel', 'crime' => 'Fraud'],
            ['name' => 'Vikas Gupta', 'crime' => 'Murder'],
            ['name' => 'Sunil Yadav', 'crime' => 'Drug Trafficking'],
            ['name' => 'Anil Kumar', 'crime' => 'Robbery'],
            ['name' => 'Manoj Singh', 'crime' => 'Kidnapping'],
            ['name' => 'Suraj Mehta', 'crime' => 'Cyber Crime'],
            ['name' => 'Pankaj Verma', 'crime' => 'Money Laundering'],
            ['name' => 'Ravi Chauhan', 'crime' => 'Domestic Violence'],
            ['name' => 'Neeraj Pandey', 'crime' => 'Bribery'],
        ];

        // Get random jail IDs
        $jailIds = DB::table('jails')->pluck('id')->toArray();

        foreach ($prisoners as $prisoner) {
            DB::table('prisoners')->insert([
                'jail_id' => $jailIds[array_rand($jailIds)], // Assign to random jail
                'name' => $prisoner['name'],
                'prisoner_code' => 'PRSN-' . strtoupper(Str::random(6)),
                'crime' => $prisoner['crime'],
                'status' => 'Active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
