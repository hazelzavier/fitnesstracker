<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('clothing_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('outfit_id')->constrained()->onDelete('cascade'); // Verwijzing naar de outfit
            $table->foreignId('clothing_id')->constrained()->onDelete('cascade'); // Verwijzing naar het kledingstuk
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('clothing_details');
    }
};
