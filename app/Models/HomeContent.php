<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class HomeContent extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'home_contents';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'subtitle',
        'yt_link',
        'image_hero',
        'visi',
        'misi',
        'vm_banner',
        'p_hewan',
        'p_produk',
        'p_kesmavet',
        'p_year'
    ];

    protected $attributes = [
        'is_singleton' => true,
        'title' => '',
        'yt_link' => '',
        'image_hero' => '',
        'visi' => '',
        'misi' => '',
        'p_year' => ''
    ];

    protected $casts = [
        'is_singleton' => 'boolean',
    ];

    /**
     * Get the singleton instance
     * Thread-safe dengan firstOrCreate
     */
    public static function getInstance()
    {
        return static::firstOrCreate(
            ['is_singleton' => true],
            [
                'title' => '',
                'yt_link' => '',
                'image_hero' => '',
                'visi' => '',
                'misi' => '',
                'p_year' => date('Y')
            ] // default values
        );
    }
}
