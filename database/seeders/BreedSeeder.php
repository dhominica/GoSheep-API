<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BreedSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('breeds')->insert([
            [
                'name' => 'Garut',
                'description' => 'Breed domba lokal dari Garut yang terkenal dengan kualitas dagingnya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Merino',
                'description' => 'Breed domba premium dengan bulu berkualitas tinggi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Dorper',
                'description' => 'Breed domba impor dengan pertumbuhan cepat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
