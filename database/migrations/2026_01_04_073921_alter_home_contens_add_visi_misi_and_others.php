<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('home_contents', function(Blueprint $table) {
            $table->text('visi');
            $table->text('misi');
            $table->string('vm_banner')->nullable();
            $table->integer('p_hewan')->default(0);
            $table->integer('p_produk')->default(0);
            $table->integer('p_kesmavet')->default(0);
            $table->string('p_year')->nullable();
        });

        Schema::table('home_contents', function (Blueprint $table) {
            if (!Schema::hasColumn('home_contents', 'is_singleton')) {
                $table->boolean('is_singleton')->default(true)->after('id');
            }
        });

        // Hapus duplikat data (keep oldest record)
        DB::statement('
            DELETE FROM home_contents 
            WHERE id NOT IN (
                SELECT * FROM (
                    SELECT MIN(id) FROM home_contents
                ) as temp
            )
        ');

        // Set is_singleton = true untuk record yang tersisa
        DB::table('home_contents')->update(['is_singleton' => true]);

        // Tambahkan unique constraint
        Schema::table('home_contents', function (Blueprint $table) {
            $table->unique('is_singleton', 'home_contents_singleton_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('home_contents', function(Blueprint $table) {
            $table->dropColumn(['visi','misi','vm_banner','p_hewan','p_produk','p_kesmavet','p_year']);
            $table->dropUnique('home_contents_singleton_unique');
            $table->dropColumn('is_singleton');
        });
    }
};
