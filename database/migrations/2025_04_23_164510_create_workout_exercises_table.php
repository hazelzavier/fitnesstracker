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
        Schema::create('workout_exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workout_id')->constrained()->onDelete('cascade');
            $table->foreignId('exercise_id')->constrained()->onDelete('restrict');
            $table->float('weight')->nullable();
            $table->integer('repetitions')->nullable();
            $table->integer('sets')->nullable();
            $table->timestamps();

            $table->unique(['workout_id', 'exercise_id']); // Zorgt ervoor dat een oefening niet meerdere keren in dezelfde workout voorkomt
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workout_exercises');
    }
};