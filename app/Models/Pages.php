<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'pages';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'slug',
        'content', //nullable
        'tags', //nullable
        'type', //['gallery', 'blog']
        'is_active', //['true','false']
        'created_by',
        'updated_by'
    ];
}
