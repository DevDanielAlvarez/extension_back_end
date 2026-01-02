<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegistrationSequenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('registration_sequences')->insert([
            'letter' => 'A',
            'current_number' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
