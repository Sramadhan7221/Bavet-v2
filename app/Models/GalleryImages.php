<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImages extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'gallery_images';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'galery_id',
        'url'
    ];
}
