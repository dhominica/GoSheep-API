<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WeightRecordSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $weightRecords = [];

        // Buat weight records untuk setiap sheep (3 records per sheep)
        for ($sheepId = 1; $sheepId <= 20; $sheepId++) {
            // Record pertama
            $weightRecords[] = [
                'sheep_id' => $sheepId,
                'weight' => rand(20, 35) + (rand(0, 99) / 100),
                'recorded_by' => 'Admin',
                'created_at' => '2026-01-15 10:00:00',
                'updated_at' => '2026-01-15 10:00:00',
            ];

            // Record kedua
            $weightRecords[] = [
                'sheep_id' => $sheepId,
                'weight' => rand(22, 38) + (rand(0, 99) / 100),
                'recorded_by' => 'Admin',
                'created_at' => '2026-02-15 10:00:00',
                'updated_at' => '2026-02-15 10:00:00',
            ];

            // Record ketiga
            $weightRecords[] = [
                'sheep_id' => $sheepId,
                'weight' => rand(24, 40) + (rand(0, 99) / 100),
                'recorded_by' => 'Admin',
                'created_at' => '2026-03-15 10:00:00',
                'updated_at' => '2026-03-15 10:00:00',
            ];
        }

        DB::table('weight_records')->insert($weightRecords);
    }
}
