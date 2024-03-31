<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'username' => 'john_doe',
            'password' => Hash::make('password123'),
            'active' => true,
            'person_id' => 1, // Ajusta el ID según el registro en la tabla 'persons' que quieras asociar
            'subscription_id' => 1, // Ajusta el ID según el registro en la tabla 'subscriptions' que quieras asociar
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
