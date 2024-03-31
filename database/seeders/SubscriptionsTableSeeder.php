<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subscriptions')->insert([
            'name' => 'Basic',
            'validate' => 30, // Número de días de validez
            'price' => 9.99,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
