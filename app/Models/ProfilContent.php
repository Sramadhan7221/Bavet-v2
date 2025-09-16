<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilContent extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'profil_content';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'kata_pengantar',
        'img_pengantar',
        'about_title',
        'about_desc',
        'about_img',
        'visi',
        'misi'
    ];
}
