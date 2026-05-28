<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MatingCheckSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua mating records
        $matingRecords = DB::table('mating_records')->get();

        $matingChecks = [];

        foreach ($matingRecords as $record) {
            // Jika result adalah unknown, buat 1 check
            // Jika result adalah pregnant atau failed, buat 2-3 checks
            $numChecks = $record->result === 'unknown' ? 1 : rand(2, 3);

            for ($i = 1; $i <= $numChecks; $i++) {
                // Check date dimulai dari mating_date + 7 hari, kemudian interval ~7 hari
                $checkDays = 7 + (($i - 1) * 7) + rand(0, 3);
                $checkDate = date('Y-m-d', strtotime($record->mating_date . " + {$checkDays} days"));

                // Jika check date lebih dari end_date, gunakan end_date
                if ($checkDate > $record->end_date) {
                    $checkDate = $record->end_date;
                }

                // Generate notes sesuai hasil
                $notes = $this->generateNotes($record->result, $i, $numChecks);

                $matingChecks[] = [
                    'mating_record_id' => $record->id,
                    'check_date' => $checkDate,
                    'notes' => $notes,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        if (!empty($matingChecks)) {
            DB::table('mating_checks')->insert($matingChecks);
        }
    }

    private function generateNotes(string $result, int $checkNum, int $totalChecks): string
    {
        $notes = [
            'pregnant' => [
                1 => 'Pemeriksaan pertama - domba menunjukkan tanda-tanda awal kehamilan',
                2 => 'Pemeriksaan lanjutan - palpasi menunjukkan perkembangan janin positif',
                3 => 'Pemeriksaan akhir - kondisi ibu hamil sangat baik',
            ],
            'failed' => [
                1 => 'Pemeriksaan pertama - belum ada tanda kehamilan',
                2 => 'Pemeriksaan lanjutan - hasil negatif, domba tidak bunting',
                3 => 'Pemeriksaan akhir - dikonfirmasi gagal, perlu kawin ulang',
            ],
            'unknown' => [
                1 => 'Pemeriksaan - hasil belum dapat dipastikan, diperlukan follow-up',
            ],
        ];

        return $notes[$result][$checkNum] ?? 'Catatan pemeriksaan kawin';
    }
}
