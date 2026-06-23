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
        Schema::create('sheep_features', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sheep_id')
                  ->constrained()
                  ->cascadeOnDelete()
                  ->unique();

            $table->decimal('weight_birth', 6, 2)->nullable();
            $table->decimal('weight_weaning', 6, 2)->nullable();
            $table->decimal('weight_180d', 6, 2)->nullable();
            $table->decimal('weight_365d', 6, 2)->nullable();
            $table->decimal('ADG_0_90', 6, 4)->nullable();
            $table->decimal('ADG_90_180', 6, 4)->nullable();
            $table->decimal('health_score', 6, 4)->nullable();
            $table->decimal('EBV_Bobot', 8, 4)->nullable();
            $table->decimal('EBV_ADG', 8, 4)->nullable();
            $table->decimal('EBV_Kesehatan', 8, 4)->nullable();
            $table->timestamp('computed_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sheep_features');
    }
};
