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
        Schema::create('clothing', function (Blueprint $table) {
            $table->id();
            $table->string('file_path'); // Pad naar afbeelding
            $table->string('name'); // Naam van kledingstuk
            $table->string('color')->nullable(); // Kleur van kledingstuk
            $table->foreignId('category_id')->constrained('categories'); // Koppeling met categorie
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Koppeling met gebruiker
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clothing');
    }
};
