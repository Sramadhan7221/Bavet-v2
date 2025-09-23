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
        Schema::create('about_content', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('desc');
            $table->text('visi');
            $table->text('misi');
            $table->string('image_hero');
            $table->string('image_visimisi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_content');
    }
};
