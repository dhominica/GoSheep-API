<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Sheep;
use App\Models\MatingRecord;
use App\Models\MatingRecommendation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class MatingRecordStoreTest extends TestCase
{
    use RefreshDatabase;

    private User $peternak;
    private Sheep $ewe;
    private Sheep $ram;

    protected function setUp(): void
    {
        parent::setUp();

        $this->peternak = User::factory()->create([
            'role' => 'peternak',
            'status' => 'active',
        ]);

        $this->ewe = Sheep::create([
            'eartag' => 'EWE001',
            'gender' => 'female',
            'status' => 'active',
            'eartag_color' => 'kuning',
            'birth_date' => now()->subYears(2),
        ]);

        $this->ram = Sheep::create([
            'eartag' => 'RAM001',
            'gender' => 'male',
            'status' => 'active',
            'eartag_color' => 'kuning',
            'birth_date' => now()->subYears(2),
        ]);
    }

    public function test_guest_cannot_create_mating_record(): void
    {
        $response = $this->postJson('/api/mating-records', [
            'ewe_id' => $this->ewe->id,
            'ram_id' => $this->ram->id,
            'mating_date' => now()->format('Y-m-d'),
            'end_date' => now()->addDays(35)->format('Y-m-d'),
        ]);

        $response->assertStatus(401);
    }

    public function test_user_with_incorrect_role_cannot_create_mating_record(): void
    {
        $user = User::factory()->create([
            'role' => 'other_role',
            'status' => 'active',
        ]);

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/mating-records', [
            'ewe_id' => $this->ewe->id,
            'ram_id' => $this->ram->id,
            'mating_date' => now()->format('Y-m-d'),
            'end_date' => now()->addDays(35)->format('Y-m-d'),
        ]);

        $response->assertStatus(403);
    }

    public function test_peternak_can_create_mating_record_successfully(): void
    {
        Sanctum::actingAs($this->peternak);

        $response = $this->postJson('/api/mating-records', [
            'ewe_id' => $this->ewe->id,
            'ram_id' => $this->ram->id,
            'mating_date' => now()->format('Y-m-d'),
            'end_date' => now()->addDays(35)->format('Y-m-d'),
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Perkawinan domba berhasil dicatat',
            ]);

        $this->assertDatabaseHas('mating_records', [
            'ewe_id' => $this->ewe->id,
            'ram_id' => $this->ram->id,
            'result' => 'unknown',
        ]);
    }

    public function test_mating_record_requires_valid_date_range(): void
    {
        Sanctum::actingAs($this->peternak);

        // end_date before mating_date
        $response = $this->postJson('/api/mating-records', [
            'ewe_id' => $this->ewe->id,
            'ram_id' => $this->ram->id,
            'mating_date' => now()->format('Y-m-d'),
            'end_date' => now()->subDay()->format('Y-m-d'),
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['end_date']);
    }

    public function test_cannot_mate_if_ewe_is_not_female(): void
    {
        Sanctum::actingAs($this->peternak);

        $anotherRam = Sheep::create([
            'eartag' => 'RAM002',
            'gender' => 'male',
            'status' => 'active',
            'eartag_color' => 'kuning',
            'birth_date' => now()->subYears(2),
        ]);

        $response = $this->postJson('/api/mating-records', [
            'ewe_id' => $anotherRam->id, // Passing male for ewe
            'ram_id' => $this->ram->id,
            'mating_date' => now()->format('Y-m-d'),
            'end_date' => now()->addDays(35)->format('Y-m-d'),
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['ewe_id']);
    }
}
