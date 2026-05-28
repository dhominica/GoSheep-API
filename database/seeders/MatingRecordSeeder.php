<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MatingRecordSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ewes = DB::table('sheep')
            ->where('gender', 'female')
            ->where('status', 'active')
            ->pluck('id')
            ->toArray();

        $rams = DB::table('sheep')
            ->where('gender', 'male')
            ->where('status', 'active')
            ->pluck('id')
            ->toArray();

        $results = ['pregnant', 'failed', 'unknown'];
        $matingRecords = [];

        if (!empty($ewes) && !empty($rams)) {
            for ($i = 0; $i < 10; $i++) {
                $eweId = $ewes[array_rand($ewes)];
                $ramId = $rams[array_rand($rams)];

                while ($eweId === $ramId) {
                    $ramId = $rams[array_rand($rams)];
                }

                $matingDate = date('Y-m-d', strtotime("-" . (30 - $i) . " days"));
                $endDate = date('Y-m-d', strtotime($matingDate . " + 21 days"));
                $result = $results[array_rand($results)];

                $actualResultDate = null;
                if ($result !== 'unknown') {
                    $actualResultDate = date('Y-m-d', strtotime($matingDate . " + " . rand(14, 28) . " days"));
                }

                $matingRecords[] = [
                    'ewe_id' => $eweId,
                    'ram_id' => $ramId,
                    'recommendation_id' => null,
                    'mating_date' => $matingDate,
                    'end_date' => $endDate,
                    'actual_result_date' => $actualResultDate,
                    'result' => $result,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('mating_records')->insert($matingRecords);
        }
    }
}
