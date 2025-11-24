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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content')->nullable();
            $table->text('tags')->nullable();
            $table->enum('type', ['gallery', 'blog'])->index();
            $table->enum('is_active',['true','false'])->default('true')->index();
            $table->foreignId('created_by')->constrained(
                table: 'users', indexName: 'pages_create_user_id'
            );
            $table->foreignId('updated_by')->nullable()->constrained(
                table: 'users', indexName: 'pages_update_user_id'
            );
            $table->timestamps();
        });

        Schema::create('page_assets', function(Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('page_id')
                ->nullable()
                ->constrained(
                    table: 'pages', 
                    indexName: 'page_assets_page_id'
                )
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('url');
            $table->enum('type', ['cover', 'content'])->default('content');
            $table->timestamps();
        });

        Schema::create('menu_list', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('type', ['static', 'module', 'external', 'parent'])->nullable();
            // relasi ke tabel pages kalau type=static
            $table->unsignedBigInteger('page_id')->nullable();
            // module name (news, event, gallery, dll.)
            $table->string('module')->nullable();
            // kalau type=external
            $table->string('external_url')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->integer('order_seq')->default(0);
            $table->enum('is_active',['true','false'])->default('true')->index();
            $table->timestamps();
            
            $table->foreignId('created_by')->constrained(
                table: 'users', indexName: 'menu_list_create_user_id'
            );
            $table->foreignId('updated_by')->nullable()->constrained(
                table: 'users', indexName: 'menu_list_update_user_id'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_assets');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('menu_list');
    }
};
