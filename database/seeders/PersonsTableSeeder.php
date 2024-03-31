<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('persons')->insert([
            'name' => 'John',
            'lastname' => 'Doe',
            'sex' => 'male',
            'birthday' => '1990-01-01',
            'address' => '123 Main St',
            'city' => 'Cityville',
            'country' => 'Countryland',
            'email' => 'john.doe@email.com',
            'phone' => '67985250',
            'avatar' => 'path/to/avatar.jpg',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
