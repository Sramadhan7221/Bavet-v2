<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FaqData extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'faq_data';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'question',
        'answer'
    ];
}
