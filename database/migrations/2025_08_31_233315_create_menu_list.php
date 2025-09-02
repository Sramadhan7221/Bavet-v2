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
        Schema::create('menu_list', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('sequence')->default(0);
            $table->softDeletes();
            $table->timestamps();
            
            $table->foreignId('created_by')->constrained(
                table: 'users', indexName: 'menu_list_create_user_id'
            );
            $table->foreignId('updated_by')->constrained(
                table: 'users', indexName: 'menu_list_update_user_id'
            );
            $table->foreignId('deleted_by')->constrained(
                table: 'users', indexName: 'menu_list_delete_user_id'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_list');
    }
};
