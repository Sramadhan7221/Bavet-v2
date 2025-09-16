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
        Schema::create('profil_content', function (Blueprint $table) {
            $table->id();
            $table->text('kata_pengantar');
            $table->string('img_pengantar');
            $table->string('about_title');
            $table->text('about_desc');
            $table->string('about_img');
            $table->text('visi');
            $table->text('misi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_content');
    }
};
