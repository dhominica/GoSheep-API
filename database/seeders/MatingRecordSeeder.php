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
            for ($i = 0; $i < 40; $i++) {
                $eweId = $ewes[array_rand($ewes)];
                $ramId = $rams[array_rand($rams)];

                while ($eweId === $ramId) {
                    $ramId = $rams[array_rand($rams)];
                }

                $daysAgo = rand(5, 120);
                $matingDate = date('Y-m-d', strtotime("-{$daysAgo} days"));
                $endDate = date('Y-m-d', strtotime($matingDate . " + 21 days"));

                $rand = rand(1, 100);
                if ($rand <= 50) {
                    $result = 'pregnant';
                } elseif ($rand <= 80) {
                    $result = 'failed';
                } else {
                    $result = 'unknown';
                }

                $matingRecords[] = [
                    'ewe_id' => $eweId,
                    'ram_id' => $ramId,
                    'recommendation_id' => null,
                    'mating_date' => $matingDate,
                    'end_date' => $endDate,
                    'result' => $result,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('mating_records')->insert($matingRecords);
        }
    }
}
