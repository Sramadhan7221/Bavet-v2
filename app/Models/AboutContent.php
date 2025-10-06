<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutContent extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'about_content';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'desc',
        'visi',
        'misi',
        'image_hero',
        'image_visimisi',
        'sejarah',
        'tugas_fungsi'
    ];
}
