<?php

namespace Database\Seeders;

use App\Models\Pages;
use App\Models\PageTags;
use App\Models\Tags;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $aboutContent = [
            'title' => 'Tentang Balai Kesehatan Hewan dan Kesehatan Masyarakat Veteriner Jabar',
            'slug' => 'about',
            'type' => 'blog', // ['gallery', 'blog']
            'is_active' => 'true', // ['true','false']
            'created_by' => User::first()->id
        ];

        $tag = Tags::updateOrCreate(['tag_name' => 'Tentang kami']);
        $page = Pages::updateOrCreate(['slug' => 'about'], $aboutContent);

        // tambahkan relasi tanpa duplikasi
        $page->tags()->syncWithoutDetaching([$tag->id]);
    }
}
