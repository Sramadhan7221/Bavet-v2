<?php

namespace Database\Seeders;

use App\Models\Pages;
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
            'tags' => 'Tentang kami', //nullable
            'type' => 'blog', //['gallery', 'blog']
            'is_active' => 'true', //['true','false']
            'created_by' => User::first()->id
        ];

        Pages::create($aboutContent);
    }
}
