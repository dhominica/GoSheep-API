<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
   {
       Schema::create('mating_recommendations', function (Blueprint $table) {
           $table->id();
           $table->foreignId('ewe_id')->constrained('sheep')->cascadeOnDelete();
           $table->foreignId('ram_id')->constrained('sheep')->cascadeOnDelete();
           $table->decimal('inbreeding_coefficient', 5, 4);
           $table->json('ewe_ebv');
           $table->json('ram_ebv');
           $table->json('expected_ebv_offspring');
           $table->json('ahp_weights');
           $table->decimal('genetic_score', 8, 4);
           $table->decimal('health_score', 8, 4);
           $table->decimal('growth_score', 8, 4);
           $table->decimal('final_score', 8, 4);
           $table->boolean('is_valid')->default(true);
           $table->timestamps();
       });
   }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mating_recommendations');
    }
};
