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
        Schema::create('pregnancies', function (Blueprint $table) {
            $table->id();

            $table->foreignId('mating_record_id')
                ->constrained('mating_records')
                ->cascadeOnDelete();

            $table->foreignId('ewe_id')
                ->constrained('sheep')
                ->cascadeOnDelete();

            $table->date('start_date');

            $table->date('expected_birth_date');

            $table->date('end_date')
                ->nullable();

            $table->enum('status', [
                'ongoing',
                'birthed',
                'miscarried',
            ])->default('ongoing');

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pregnancies');
    }
};
