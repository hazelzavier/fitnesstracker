<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClothingImageHistoryTable extends Migration
{
    public function up()
    {
        Schema::create('clothing_image_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clothing_id')->constrained()->onDelete('cascade');  // Associate it with the clothing item
            $table->string('file_path');  // Path to the previous image
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clothing_image_history');
    }
}
