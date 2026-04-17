<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HealthRecordSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $healthRecords = [];

        $conditions = ['heat_stress_risk', 'pregnant', 'sick', 'injured', 'healthy', 'vaccinated'];
        $categories = ['health', 'reproduction', 'environment'];
        $severities = ['normal', 'warning', 'critical'];

        // Buat health records untuk setiap sheep (2-3 records per sheep)
        for ($sheepId = 1; $sheepId <= 20; $sheepId++) {
            // Record pertama - kesehatan umum
            $healthRecords[] = [
                'sheep_id' => $sheepId,
                'recorded_by' => 1, // Admin user ID
                'category' => 'health',
                'condition' => $conditions[array_rand($conditions)],
                'severity' => 'normal',
                'source' => 'manual',
                'notes' => 'Kondisi kesehatan umum domba baik.',
                'created_at' => '2026-01-10 08:00:00',
                'updated_at' => '2026-01-10 08:00:00',
            ];

            // Record kedua - reproduksi
            $healthRecords[] = [
                'sheep_id' => $sheepId,
                'recorded_by' => 1,
                'category' => 'reproduction',
                'condition' => $sheepId % 2 == 0 ? 'pregnant' : 'healthy',
                'severity' => $sheepId % 2 == 0 ? 'warning' : 'normal',
                'source' => 'manual',
                'notes' => $sheepId % 2 == 0 ? 'Domba dalam kondisi bunting.' : 'Domba siap untuk reproduksi.',
                'created_at' => '2026-02-20 09:30:00',
                'updated_at' => '2026-02-20 09:30:00',
            ];

            // Record ketiga - lingkungan (random)
            if ($sheepId % 3 == 0) {
                $healthRecords[] = [
                    'sheep_id' => $sheepId,
                    'recorded_by' => 1,
                    'category' => 'environment',
                    'condition' => 'heat_stress_risk',
                    'severity' => 'warning',
                    'source' => 'iot',
                    'notes' => 'Risiko heat stress terdeteksi berdasarkan sensor suhu kandang.',
                    'created_at' => '2026-03-10 14:00:00',
                    'updated_at' => '2026-03-10 14:00:00',
                ];
            }
        }

        DB::table('health_records')->insert($healthRecords);
    }
}
