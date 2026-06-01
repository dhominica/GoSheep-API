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
        Schema::create('health_records', function (Blueprint $table) {
            $table->id();

            $table->foreignId('sheep_id')->constrained('sheep')->cascadeOnDelete();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('recorded_at')->useCurrent();

            $table->enum('category', ['health', 'environment', 'nutrition', 'maintenance']); // health, environment, nutrition, maintenance
            $table->string('condition'); // heat_stress_risk, sick, etc
            $table->enum('severity', ['normal', 'ringan', 'sedang', 'berat']); // normal, ringan, sedang, berat

            $table->string('source'); // manual, iot

            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_records');
    }
};
