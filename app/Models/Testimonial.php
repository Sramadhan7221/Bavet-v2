<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'testimonials';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'profil',
        'institusi',
        'review'
    ];
}
