<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
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
        'title',
        'slug',
        'type',
        'page_id',
        'module',
        'external_url',
        'parent_id',
        'order_seq',
        'is_active',
        'created_by',
        'updated_by'
    ];

    public function parent()
    {
        return $this->belongsTo(Menus::class, 'parent_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(Menus::class, 'parent_id');
    }
}
