<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration // Of 'class AddNotesToWorkoutsTable extends Migration' afhankelijk van je Laravel versie
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('workouts', function (Blueprint $table) {
            // Voeg een 'notes' kolom toe, type TEXT voor langere notities, nullable want optioneel
            $table->text('notes')->nullable()->after('date'); // Plaats na de 'date' kolom
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('workouts', function (Blueprint $table) {
            $table->dropColumn('notes');
        });
    }
};
