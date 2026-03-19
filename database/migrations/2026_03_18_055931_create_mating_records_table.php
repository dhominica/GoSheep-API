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
        Schema::create('mating_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ewe_id')->constrained('sheep')->cascadeOnDelete();
            $table->foreignId('ram_id')->constrained('sheep')->cascadeOnDelete();
            $table->foreignId('recommendation_id')
            ->nullable()
            ->constrained('mating_recommendations')
            ->nullOnDelete();
            $table->date('mating_date');
            $table->date('end_date');
            $table->date('actual_result_date')->nullable();
            $table->enum('result', ['pregnant', 'failed', 'unknown'])->default('unknown');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mating_records');
    }
};
