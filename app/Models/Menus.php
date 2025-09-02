<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menus extends Model
{
    use SoftDeletes;
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'menu_list';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'sequence',
        'created_by',
        'updated_by',
        'deleted_by'
    ];
}
