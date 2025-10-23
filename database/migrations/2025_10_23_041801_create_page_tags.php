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
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('tag_name');
            $table->timestamps();
        });

        Schema::create('page_tags', function (Blueprint $table) {
            $table->foreignIdFor(App\Models\Pages::class, 'page_id')
                ->constrained('pages')
                ->cascadeOnDelete();

            $table->foreignIdFor(App\Models\Tags::class, 'tag_id')
                ->constrained('tags')
                ->cascadeOnDelete();

            $table->unique(['page_id', 'tag_id']);
        });

        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn('tags');
            $table->string('banner')->default("http://127.0.0.1:8000/admin/images/bavet.png");
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_tags');
        Schema::dropIfExists('tags');
        Schema::table('pages', function (Blueprint $table) {
            $table->text('tags')->nullable();
            $table->dropColumn('banner');
        });
    }
};
