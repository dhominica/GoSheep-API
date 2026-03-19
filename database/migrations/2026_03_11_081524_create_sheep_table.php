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
        Schema::create('sheep', function (Blueprint $table) {
            $table->id();
            $table->string('eartag')->unique();
            $table->enum('gender', ['male', 'female']);
            $table->date('birth_date');
            $table->string('eartag_color');
            $table->foreignId('breed_id')->nullable()->constrained('breeds')->nullOnDelete();
            $table->foreignId('sire_id')->nullable()->constrained('sheep')->nullOnDelete();
            $table->foreignId('dam_id')->nullable()->constrained('sheep')->nullOnDelete();
            $table->foreignId('cage_id')->constrained('cages')->cascadeOnDelete();
            $table->string('status'); // active, sold, dead
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sheep');
    }
};
