<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class BreedingTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            // Delete existing records to allow clean and deterministic seeding
            DB::table('mating_recommendations')->delete();
            DB::table('mating_records')->delete();
            DB::table('mating_checks')->delete();
            DB::table('pregnancies')->delete();
            DB::table('births')->delete();
            DB::table('activity_logs')->delete();
            DB::table('cage_environment_logs')->delete();
            DB::table('sheep_features')->delete();
            DB::table('health_records')->delete();
            DB::table('weight_records')->delete();
            DB::table('sheep')->delete();

            // 1. BREEDS
            $breeds = [
                ['id' => 1, 'name' => 'Domba Garut', 'created_at' => now(), 'updated_at' => now()],
                ['id' => 2, 'name' => 'Domba Ekor Gemuk', 'created_at' => now(), 'updated_at' => now()],
                ['id' => 3, 'name' => 'Domba Ekor Tipis', 'created_at' => now(), 'updated_at' => now()],
                ['id' => 4, 'name' => 'Domba Priangan', 'created_at' => now(), 'updated_at' => now()],
            ];
            foreach ($breeds as $breed) {
                DB::table('breeds')->updateOrInsert(['id' => $breed['id']], [
                    'name' => $breed['name'],
                    'created_at' => $breed['created_at'],
                    'updated_at' => $breed['updated_at'],
                ]);
            }

            // 2. CAGES
            $cages = [
                ['id' => 1, 'name' => 'Kandang A', 'max_capacity' => 20, 'current_capacity' => 0, 'created_at' => now(), 'updated_at' => now()],
                ['id' => 2, 'name' => 'Kandang B', 'max_capacity' => 20, 'current_capacity' => 0, 'created_at' => now(), 'updated_at' => now()],
                ['id' => 3, 'name' => 'Kandang C', 'max_capacity' => 20, 'current_capacity' => 0, 'created_at' => now(), 'updated_at' => now()],
            ];
            foreach ($cages as $cage) {
                DB::table('cages')->updateOrInsert(['id' => $cage['id']], [
                    'name' => $cage['name'],
                    'max_capacity' => $cage['max_capacity'],
                    'current_capacity' => $cage['current_capacity'],
                    'created_at' => $cage['created_at'],
                    'updated_at' => $cage['updated_at'],
                ]);
            }

            // Ensure user with ID 1 exists to bypass FK constraints on recorded_by
            DB::table('users')->updateOrInsert(['id' => 1], [
                'name' => 'Admin Owner',
                'email' => 'admin@gosheep.test',
                'password' => Hash::make('password'), // password
                'role' => 'owner',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Ensure a user with role 'peternak' exists for Postman API testing
            DB::table('users')->updateOrInsert(['id' => 2], [
                'name' => 'Peternak GoSheep',
                'email' => 'peternak@gosheep.test',
                'password' => Hash::make('password'), // password
                'role' => 'peternak',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Set RNG seed for deterministic values
            mt_srand(12345);

            // Helper to generate deterministic random float
            $randomFloat = function ($min, $max) {
                return $min + mt_rand() / mt_getrandmax() * ($max - $min);
            };

            // 3. SHEEP
            // We need:
            // - 5 males GEN 0 (founders, sire_id=null, dam_id=null)
            // - 5 females GEN 0 (founders, sire_id=null, dam_id=null)
            // - 5 males GEN 1 (sire from GEN 0, dam from GEN 0)
            // - 5 females GEN 1 (sire from GEN 0, dam from GEN 0)

            $gen0Males = [
                ['eartag' => 'M001', 'gender' => 'male', 'birth_date' => '2019-01-15', 'eartag_color' => 'kuning', 'breed_id' => 1, 'cage_id' => 1],
                ['eartag' => 'M002', 'gender' => 'male', 'birth_date' => '2019-02-20', 'eartag_color' => 'merah', 'breed_id' => 2, 'cage_id' => 2],
                ['eartag' => 'M003', 'gender' => 'male', 'birth_date' => '2019-03-25', 'eartag_color' => 'biru', 'breed_id' => 3, 'cage_id' => 3],
                ['eartag' => 'M004', 'gender' => 'male', 'birth_date' => '2019-04-10', 'eartag_color' => 'hijau', 'breed_id' => 4, 'cage_id' => 1],
                ['eartag' => 'M005', 'gender' => 'male', 'birth_date' => '2019-05-05', 'eartag_color' => 'kuning', 'breed_id' => 1, 'cage_id' => 2],
            ];

            $gen0Females = [
                ['eartag' => 'F001', 'gender' => 'female', 'birth_date' => '2019-01-20', 'eartag_color' => 'merah', 'breed_id' => 2, 'cage_id' => 1],
                ['eartag' => 'F002', 'gender' => 'female', 'birth_date' => '2019-02-15', 'eartag_color' => 'biru', 'breed_id' => 3, 'cage_id' => 2],
                ['eartag' => 'F003', 'gender' => 'female', 'birth_date' => '2019-03-10', 'eartag_color' => 'hijau', 'breed_id' => 4, 'cage_id' => 3],
                ['eartag' => 'F004', 'gender' => 'female', 'birth_date' => '2019-04-05', 'eartag_color' => 'kuning', 'breed_id' => 1, 'cage_id' => 1],
                ['eartag' => 'F005', 'gender' => 'female', 'birth_date' => '2019-05-12', 'eartag_color' => 'merah', 'breed_id' => 2, 'cage_id' => 3],
            ];

            $insertedSheep = []; // eartag => id
            $sheepDataMap = []; // id => data array

            // Insert GEN 0 Males
            foreach ($gen0Males as $sheep) {
                $id = DB::table('sheep')->insertGetId([
                    'eartag' => $sheep['eartag'],
                    'gender' => $sheep['gender'],
                    'birth_date' => $sheep['birth_date'],
                    'eartag_color' => $sheep['eartag_color'],
                    'breed_id' => $sheep['breed_id'],
                    'sire_id' => null,
                    'dam_id' => null,
                    'cage_id' => $sheep['cage_id'],
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $insertedSheep[$sheep['eartag']] = $id;
                $sheepDataMap[$id] = array_merge($sheep, ['id' => $id, 'gen' => 0]);
            }

            // Insert GEN 0 Females
            foreach ($gen0Females as $sheep) {
                $id = DB::table('sheep')->insertGetId([
                    'eartag' => $sheep['eartag'],
                    'gender' => $sheep['gender'],
                    'birth_date' => $sheep['birth_date'],
                    'eartag_color' => $sheep['eartag_color'],
                    'breed_id' => $sheep['breed_id'],
                    'sire_id' => null,
                    'dam_id' => null,
                    'cage_id' => $sheep['cage_id'],
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $insertedSheep[$sheep['eartag']] = $id;
                $sheepDataMap[$id] = array_merge($sheep, ['id' => $id, 'gen' => 0]);
            }

            // Define GEN 1 Males and Females.
            // PENTING: GEN 1 harus punya sire_id & dam_id dari GEN 0 yang BERBEDA breed untuk variasi pedigree
            $gen1Males = [
                [
                    'eartag' => 'M101', 'gender' => 'male', 'birth_date' => '2021-01-10', 'eartag_color' => 'biru', 'breed_id' => 1, 'cage_id' => 3,
                    'sire_eartag' => 'M001', 'dam_eartag' => 'F001' // M001=Domba Garut(1), F001=Domba Ekor Gemuk(2)
                ],
                [
                    'eartag' => 'M102', 'gender' => 'male', 'birth_date' => '2021-02-15', 'eartag_color' => 'hijau', 'breed_id' => 2, 'cage_id' => 1,
                    'sire_eartag' => 'M002', 'dam_eartag' => 'F002' // M002=DEG(2), F002=DET(3)
                ],
                [
                    'eartag' => 'M103', 'gender' => 'male', 'birth_date' => '2021-03-20', 'eartag_color' => 'kuning', 'breed_id' => 3, 'cage_id' => 2,
                    'sire_eartag' => 'M003', 'dam_eartag' => 'F003' // M003=DET(3), F003=Domba Priangan(4)
                ],
                [
                    'eartag' => 'M104', 'gender' => 'male', 'birth_date' => '2021-04-25', 'eartag_color' => 'merah', 'breed_id' => 4, 'cage_id' => 3,
                    'sire_eartag' => 'M004', 'dam_eartag' => 'F004' // M004=Priangan(4), F004=Garut(1)
                ],
                [
                    'eartag' => 'M105', 'gender' => 'male', 'birth_date' => '2021-05-30', 'eartag_color' => 'biru', 'breed_id' => 1, 'cage_id' => 1,
                    'sire_eartag' => 'M005', 'dam_eartag' => 'F005' // M005=Garut(1), F005=DEG(2)
                ],
            ];

            $gen1Females = [
                [
                    'eartag' => 'F101', 'gender' => 'female', 'birth_date' => '2021-01-12', 'eartag_color' => 'hijau', 'breed_id' => 2, 'cage_id' => 2,
                    'sire_eartag' => 'M002', 'dam_eartag' => 'F004' // M002=DEG(2), F004=Garut(1)
                ],
                [
                    'eartag' => 'F102', 'gender' => 'female', 'birth_date' => '2021-02-18', 'eartag_color' => 'kuning', 'breed_id' => 3, 'cage_id' => 3,
                    'sire_eartag' => 'M003', 'dam_eartag' => 'F005' // M003=DET(3), F005=DEG(2)
                ],
                [
                    'eartag' => 'F103', 'gender' => 'female', 'birth_date' => '2021-03-22', 'eartag_color' => 'merah', 'breed_id' => 4, 'cage_id' => 1,
                    'sire_eartag' => 'M004', 'dam_eartag' => 'F002' // M004=Priangan(4), F002=DET(3)
                ],
                [
                    'eartag' => 'F104', 'gender' => 'female', 'birth_date' => '2021-04-28', 'eartag_color' => 'biru', 'breed_id' => 1, 'cage_id' => 2,
                    'sire_eartag' => 'M001', 'dam_eartag' => 'F003' // M001=Garut(1), F003=Priangan(4)
                ],
                [
                    'eartag' => 'F105', 'gender' => 'female', 'birth_date' => '2021-05-24', 'eartag_color' => 'hijau', 'breed_id' => 2, 'cage_id' => 3,
                    'sire_eartag' => 'M005', 'dam_eartag' => 'F003' // M005=Garut(1), F003=Priangan(4)
                ],
            ];

            // Insert GEN 1 Males
            foreach ($gen1Males as $sheep) {
                $sireId = $insertedSheep[$sheep['sire_eartag']];
                $damId = $insertedSheep[$sheep['dam_eartag']];
                $id = DB::table('sheep')->insertGetId([
                    'eartag' => $sheep['eartag'],
                    'gender' => $sheep['gender'],
                    'birth_date' => $sheep['birth_date'],
                    'eartag_color' => $sheep['eartag_color'],
                    'breed_id' => $sheep['breed_id'],
                    'sire_id' => $sireId,
                    'dam_id' => $damId,
                    'cage_id' => $sheep['cage_id'],
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $insertedSheep[$sheep['eartag']] = $id;
                $sheepDataMap[$id] = array_merge($sheep, ['id' => $id, 'gen' => 1, 'sire_id' => $sireId, 'dam_id' => $damId]);
            }

            // Insert GEN 1 Females
            foreach ($gen1Females as $sheep) {
                $sireId = $insertedSheep[$sheep['sire_eartag']];
                $damId = $insertedSheep[$sheep['dam_eartag']];
                $id = DB::table('sheep')->insertGetId([
                    'eartag' => $sheep['eartag'],
                    'gender' => $sheep['gender'],
                    'birth_date' => $sheep['birth_date'],
                    'eartag_color' => $sheep['eartag_color'],
                    'breed_id' => $sheep['breed_id'],
                    'sire_id' => $sireId,
                    'dam_id' => $damId,
                    'cage_id' => $sheep['cage_id'],
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $insertedSheep[$sheep['eartag']] = $id;
                $sheepDataMap[$id] = array_merge($sheep, ['id' => $id, 'gen' => 1, 'sire_id' => $sireId, 'dam_id' => $damId]);
            }

            // Update Cages capacity count based on populated active sheep
            foreach ([1, 2, 3] as $cageId) {
                $capacityCount = DB::table('sheep')
                    ->where('cage_id', $cageId)
                    ->where('status', 'active')
                    ->count();

                DB::table('cages')
                    ->where('id', $cageId)
                    ->update(['current_capacity' => $capacityCount]);
            }

            // 4. WEIGHT RECORDS & PREPARING FEATURES
            $featuresMap = [];

            foreach ($sheepDataMap as $id => $sheep) {
                $birthDate = Carbon::parse($sheep['birth_date']);
                $breedId = $sheep['breed_id'];
                $gender = $sheep['gender'];

                // a. Berat Lahir
                // Garut (1)   : 2.87 ± 0.5 kg
                // DEG (2)     : 2.70 ± 0.4 kg
                // DET (3)     : 2.30 ± 0.4 kg
                // Priangan (4): 2.80 ± 0.5 kg
                $weightBirth = 0.0;
                if ($breedId == 1) {
                    $weightBirth = $randomFloat(2.87 - 0.5, 2.87 + 0.5);
                } elseif ($breedId == 2) {
                    $weightBirth = $randomFloat(2.70 - 0.4, 2.70 + 0.4);
                } elseif ($breedId == 3) {
                    $weightBirth = $randomFloat(2.30 - 0.4, 2.30 + 0.4);
                } elseif ($breedId == 4) {
                    $weightBirth = $randomFloat(2.80 - 0.5, 2.80 + 0.5);
                }
                $weightBirth = round($weightBirth, 2);

                DB::table('weight_records')->insert([
                    'sheep_id' => $id,
                    'weight' => $weightBirth,
                    'recorded_by' => 1,
                    'recorded_at' => $birthDate->copy()->startOfDay(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // b. Berat Sapih (~90 hari setelah lahir)
                // Garut jantan   : 12.52 ± 2.0 kg
                // Garut betina   : 11.96 ± 2.0 kg
                // DEG jantan     : 10.11 ± 1.0 kg
                // DEG betina     :  9.20 ± 1.0 kg
                // DET jantan     :  9.65 ± 1.0 kg
                // DET betina     :  7.42 ± 0.8 kg
                // Priangan jantan: 11.50 ± 2.0 kg
                // Priangan betina: 10.80 ± 2.0 kg
                $weightWeaning = 0.0;
                if ($breedId == 1) {
                    $weightWeaning = ($gender === 'male')
                        ? $randomFloat(12.52 - 2.0, 12.52 + 2.0)
                        : $randomFloat(11.96 - 2.0, 11.96 + 2.0);
                } elseif ($breedId == 2) {
                    $weightWeaning = ($gender === 'male')
                        ? $randomFloat(10.11 - 1.0, 10.11 + 1.0)
                        : $randomFloat(9.20 - 1.0, 9.20 + 1.0);
                } elseif ($breedId == 3) {
                    $weightWeaning = ($gender === 'male')
                        ? $randomFloat(9.65 - 1.0, 9.65 + 1.0)
                        : $randomFloat(7.42 - 0.8, 7.42 + 0.8);
                } elseif ($breedId == 4) {
                    $weightWeaning = ($gender === 'male')
                        ? $randomFloat(11.50 - 2.0, 11.50 + 2.0)
                        : $randomFloat(10.80 - 2.0, 10.80 + 2.0);
                }
                $weightWeaning = round($weightWeaning, 2);

                DB::table('weight_records')->insert([
                    'sheep_id' => $id,
                    'weight' => $weightWeaning,
                    'recorded_by' => 1,
                    'recorded_at' => $birthDate->copy()->addDays(90)->startOfDay(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // c. (Opsional) Berat 180 hari untuk GEN 0
                $weight180 = null;
                if ($sheep['gen'] === 0) {
                    $weight180 = round($weightWeaning + (90 * 0.067), 2);
                    DB::table('weight_records')->insert([
                        'sheep_id' => $id,
                        'weight' => $weight180,
                        'recorded_by' => 1,
                        'recorded_at' => $birthDate->copy()->addDays(180)->startOfDay(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                $adg090 = round(($weightWeaning - $weightBirth) / 90, 4);
                $adg90180 = ($weight180 !== null) ? 0.0670 : null;

                $featuresMap[$id] = [
                    'weight_birth' => $weightBirth,
                    'weight_weaning' => $weightWeaning,
                    'weight_180d' => $weight180,
                    'ADG_0_90' => $adg090,
                    'ADG_90_180' => $adg90180,
                ];
            }

            // 5. HEALTH RECORDS
            // Select 5 random sheep to add a sick record.
            // To make this seeder deterministic, we pick indices 2, 5, 8, 12, 17 of the inserted IDs.
            $sheepIds = array_keys($sheepDataMap);
            $sickIndices = [2, 5, 8, 12, 17];
            $sickSheepIds = [];
            foreach ($sickIndices as $idx) {
                if (isset($sheepIds[$idx])) {
                    $sickSheepIds[] = $sheepIds[$idx];
                }
            }

            foreach ($sheepDataMap as $id => $sheep) {
                $birthDate = Carbon::parse($sheep['birth_date']);

                // Create the general health check at birth_date + 30 days
                DB::table('health_records')->insert([
                    'sheep_id' => $id,
                    'category' => 'health', // mapped from "umum"
                    'condition' => 'normal',
                    'severity' => 'normal',
                    'source' => 'manual',
                    'recorded_at' => $birthDate->copy()->addDays(30)->startOfDay(),
                    'recorded_by' => 1,
                    'notes' => 'Pemeriksaan rutin - kondisi baik',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $isSick = in_array($id, $sickSheepIds);
                if ($isSick) {
                    // Create the sick record at birth_date + 60 days
                    DB::table('health_records')->insert([
                        'sheep_id' => $id,
                        'category' => 'health', // mapped from "parasit"
                        'condition' => 'cacingan',
                        'severity' => 'ringan',
                        'source' => 'manual',
                        'recorded_at' => $birthDate->copy()->addDays(60)->startOfDay(),
                        'recorded_by' => 1,
                        'notes' => 'Ditemukan saat pemeriksaan rutin',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

                    // health_score: 1 - (1 / (2 * 3)) = 0.8333
                    $healthScore = round(1 - (1 / 6), 4);
                } else {
                    $healthScore = 1.0000;
                }

                $featuresMap[$id]['health_score'] = $healthScore;
            }

            // 6. SHEEP FEATURES (Manual calculation, BYPASS Observer)
            $weaningWeights = array_column($featuresMap, 'weight_weaning');
            $adgValues = array_column($featuresMap, 'ADG_0_90');
            $healthScores = array_column($featuresMap, 'health_score');

            $popMeanWeaning = array_sum($weaningWeights) / count($weaningWeights);
            $popMeanAdg = array_sum($adgValues) / count($adgValues);
            $popMeanHealth = array_sum($healthScores) / count($healthScores);

            foreach ($featuresMap as $sheepId => $features) {
                // EBVs formulas:
                // EBV_Bobot = 0.31 * (weight_weaning - pop_mean_weaning)
                // EBV_ADG = 0.28 * (ADG_0_90 - pop_mean_adg)
                // EBV_Kesehatan = 0.10 * (health_score - pop_mean_health)
                $ebvBobot = round(0.31 * ($features['weight_weaning'] - $popMeanWeaning), 4);
                $ebvAdg = round(0.28 * ($features['ADG_0_90'] - $popMeanAdg), 4);
                $ebvKesehatan = round(0.10 * ($features['health_score'] - $popMeanHealth), 4);

                DB::table('sheep_features')->insert([
                    'sheep_id' => $sheepId,
                    'weight_birth' => $features['weight_birth'],
                    'weight_weaning' => $features['weight_weaning'],
                    'weight_180d' => $features['weight_180d'],
                    'weight_365d' => null,
                    'ADG_0_90' => $features['ADG_0_90'],
                    'ADG_90_180' => $features['ADG_90_180'],
                    'health_score' => $features['health_score'],
                    'EBV_Bobot' => $ebvBobot,
                    'EBV_ADG' => $ebvAdg,
                    'EBV_Kesehatan' => $ebvKesehatan,
                    'computed_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });
    }
}
