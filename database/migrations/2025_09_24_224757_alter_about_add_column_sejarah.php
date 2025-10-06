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
        Schema::table('about_content', function(Blueprint $table) {
            $table->text('sejarah');
            $table->text('tugas_fungsi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('about_content', function(Blueprint $table) {
            $table->dropColumn(['sejarah', 'tugas_fungsi']);
        });
    }
};
