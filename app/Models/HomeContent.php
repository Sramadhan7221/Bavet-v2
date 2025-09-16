<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
        'image_hero'
    ];
}
