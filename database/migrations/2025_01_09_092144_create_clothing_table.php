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
        Schema::create('clothing', function (Blueprint $table) {
            $table->id();
            $table->string('file_path'); // Pad naar het bestand
            $table->string('name'); // Naam van het kledingstuk
            $table->string('color'); // Kleur van het kledingstuk
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Foreign key voor de categorie
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key voor de gebruiker
            $table->timestamps(); // Standaard Laravel timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
{
    Schema::table('clothing', function (Blueprint $table) {
        $table->dropColumn('file_path');  // Drop the file_path column if rolled back
    });
}
};
