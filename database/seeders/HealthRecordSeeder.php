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
        $adminId = DB::table('users')->where('email', 'admin@gosheep.test')->value('id');

        // Exclude heat stress conditions from the random conditions for general health records
        $conditions = ['pregnant', 'sick', 'injured', 'healthy', 'vaccinated'];

        // Sheep that have heat stress risk or critical conditions in the model
        $heatStressSheep = [
            3 => 'heat_stress_risk',
            4 => 'heat_stress_risk',
            9 => 'heat_stress_critical',
            10 => 'heat_stress_critical',
            15 => 'heat_stress_risk',
            16 => 'heat_stress_risk',
            19 => 'heat_stress_critical',
            20 => 'heat_stress_critical',
        ];

        // Buat health records untuk setiap sheep (2-3 records per sheep)
        for ($sheepId = 1; $sheepId <= 20; $sheepId++) {
            // Record pertama - kesehatan umum (selalu bukan heat stress untuk konsistensi)
            $recordedAt = '2026-01-10 08:00:00';
            $generalCondition = in_array($sheepId, array_keys($heatStressSheep)) ? 'healthy' : $conditions[array_rand($conditions)];

            $healthRecords[] = [
                'sheep_id' => $sheepId,
                'recorded_by' => $adminId,
                'recorded_at' => $recordedAt,
                'category' => 'health',
                'condition' => $generalCondition,
                'severity' => 'normal',
                'source' => 'manual',
                'notes' => 'Kondisi kesehatan umum domba baik.',
                'created_at' => $recordedAt,
                'updated_at' => $recordedAt,
            ];

            // Record kedua - nutrisi
            $recordedAt = '2026-02-20 09:30:00';
            $healthRecords[] = [
                'sheep_id' => $sheepId,
                'recorded_by' => $adminId,
                'recorded_at' => $recordedAt,
                'category' => 'nutrition',
                'condition' => $sheepId % 2 == 0
                    ? 'low_appetite'
                    : 'normal_feed_intake',
                'severity' => $sheepId % 2 == 0
                    ? 'sedang'
                    : 'normal',
                'source' => 'manual',
                'notes' => $sheepId % 2 == 0
                    ? 'Nafsu makan menurun dalam 2 hari terakhir.'
                    : 'Konsumsi pakan normal.',
                'created_at' => $recordedAt,
                'updated_at' => $recordedAt,
            ];

            // Record khusus untuk sheep dengan heat stress - tambahkan record heat stress
            if (isset($heatStressSheep[$sheepId])) {
                $recordedAt = '2026-03-10 14:00:00';
                $healthRecords[] = [
                    'sheep_id' => $sheepId,
                    'recorded_by' => $adminId,
                    'recorded_at' => $recordedAt,
                    'category' => 'environment',
                    'condition' => $heatStressSheep[$sheepId],
                    'severity' => $heatStressSheep[$sheepId] === 'heat_stress_critical' ? 'berat' : 'ringan',
                    'source' => 'iot',
                    'notes' => $heatStressSheep[$sheepId] === 'heat_stress_critical'
                        ? 'Heat stress kritis terdeteksi berdasarkan sensor suhu kandang.'
                        : 'Risiko heat stress terdeteksi berdasarkan sensor suhu kandang.',
                    'created_at' => $recordedAt,
                    'updated_at' => $recordedAt,
                ];
            } elseif ($sheepId % 3 == 0) {
                // Record ketiga - lingkungan (untuk sheep lainnya)
                $recordedAt = '2026-03-10 14:00:00';
                $healthRecords[] = [
                    'sheep_id' => $sheepId,
                    'recorded_by' => $adminId,
                    'recorded_at' => $recordedAt,
                    'category' => 'environment',
                    'condition' => 'normal_environment',
                    'severity' => 'normal',
                    'source' => 'iot',
                    'notes' => 'Kondisi lingkungan kandang normal.',
                    'created_at' => $recordedAt,
                    'updated_at' => $recordedAt,
                ];
            }
        }

        DB::table('health_records')->insert($healthRecords);
    }
}
