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
        $adminId = DB::table('users')->where('email', 'admin@gosheep.test')->value('id');

        // Buat weight records untuk setiap sheep (3 records per sheep)
        for ($sheepId = 1; $sheepId <= 20; $sheepId++) {
            // Record pertama
            $recordedAt = '2026-01-15 10:00:00';
            $weightRecords[] = [
                'sheep_id' => $sheepId,
                'weight' => rand(20, 35) + (rand(0, 99) / 100),
                'recorded_by' => $adminId,
                'recorded_at' => $recordedAt,
                'created_at' => $recordedAt,
                'updated_at' => $recordedAt,
            ];

            // Record kedua
            $recordedAt = '2026-02-15 10:00:00';
            $weightRecords[] = [
                'sheep_id' => $sheepId,
                'weight' => rand(22, 38) + (rand(0, 99) / 100),
                'recorded_by' => $adminId,
                'recorded_at' => $recordedAt,
                'created_at' => $recordedAt,
                'updated_at' => $recordedAt,
            ];

            // Record ketiga
            $recordedAt = '2026-03-15 10:00:00';
            $weightRecords[] = [
                'sheep_id' => $sheepId,
                'weight' => rand(24, 40) + (rand(0, 99) / 100),
                'recorded_by' => $adminId,
                'recorded_at' => $recordedAt,
                'created_at' => $recordedAt,
                'updated_at' => $recordedAt,
            ];
        }

        DB::table('weight_records')->insert($weightRecords);
    }
}
