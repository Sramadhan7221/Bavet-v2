<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactData extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'contacts';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id_contact',
        'detail',
        'location'
    ];

    protected $casts = [
        'detail' => 'array'
    ];
}
