<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarouselBanner extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'carousel_banners';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'img_path',
        'status',
        'urutan'
    ];
}
