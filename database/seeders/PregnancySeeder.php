<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PregnancySeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all mating records with pregnant result
        $pregnantMatingRecords = DB::table('mating_records')
            ->where('result', 'pregnant')
            ->get();

        $pregnancies = [];

        // Sheep gestation period is approximately 147 days (145-150 days)
        $gestationDays = 147;

        foreach ($pregnantMatingRecords as $record) {
            $startDate = $record->mating_date;
            $expectedBirthDate = date('Y-m-d', strtotime($startDate . " + {$gestationDays} days"));

            // Randomly decide if pregnancy has ended (birthed or miscarried)
            $rand = rand(1, 100);
            $status = 'ongoing';
            $endDate = null;

            if ($rand <= 60) {
                // 60% chance: ongoing pregnancy
                $status = 'ongoing';
            } elseif ($rand <= 85) {
                // 25% chance: already birthed
                $status = 'birthed';
                $daysAfterExpected = rand(0, 7);
                $endDate = date('Y-m-d', strtotime($expectedBirthDate . " + {$daysAfterExpected} days"));
            } else {
                // 15% chance: miscarried
                $status = 'miscarried';
                $daysBeforeExpected = rand(20, 70);
                $endDate = date('Y-m-d', strtotime($expectedBirthDate . " - {$daysBeforeExpected} days"));
            }

            $pregnancies[] = [
                'mating_record_id' => $record->id,
                'ewe_id' => $record->ewe_id,
                'start_date' => $startDate,
                'expected_birth_date' => $expectedBirthDate,
                'end_date' => $endDate,
                'status' => $status,
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($pregnancies)) {
            DB::table('pregnancies')->insert($pregnancies);
        }
    }
}
