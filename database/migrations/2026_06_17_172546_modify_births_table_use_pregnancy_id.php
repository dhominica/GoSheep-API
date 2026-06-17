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
        // Truncate existing data since schema changes are breaking
        DB::table('births')->truncate();

        Schema::table('births', function (Blueprint $table) {
            // Drop old columns
            $table->dropForeign(['dam_id']);
            $table->dropForeign(['sire_id']);
            $table->dropColumn(['dam_id', 'sire_id', 'birth_date', 'notes']);

            // Add new columns
            $table->foreignId('pregnancy_id')
                  ->unique()
                  ->constrained('pregnancies')
                  ->cascadeOnDelete();
            $table->text('birth_notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('births', function (Blueprint $table) {
            $table->dropForeign(['pregnancy_id']);
            $table->dropUnique(['pregnancy_id']);
            $table->dropColumn(['pregnancy_id', 'birth_notes']);

            $table->foreignId('dam_id')->constrained('sheep')->cascadeOnDelete();
            $table->foreignId('sire_id')->nullable()->constrained('sheep')->nullOnDelete();
            $table->date('birth_date');
            $table->text('notes')->nullable();
        });
    }
};
