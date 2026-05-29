<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CageSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cages')->insert([
            [
                'name' => 'Kandang A',
                'current_capacity' => 8,
                'max_capacity' => 15,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kandang B',
                'current_capacity' => 6,
                'max_capacity' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kandang C',
                'current_capacity' => 6,
                'max_capacity' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
