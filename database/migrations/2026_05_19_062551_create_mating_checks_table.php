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
        Schema::create('mating_checks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mating_record_id')->constrained('mating_records')->onDelete('cascade');
            $table->date('check_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mating_checks');
    }
};
