<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'tags';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'tag_name'
    ];

    public function pages()
    {
        return $this->belongsToMany(
            Pages::class,       // model tujuan
            'page_tags',        // nama tabel pivot
            'tag_id',           // foreign key untuk model ini (Tags)
            'page_id'           // foreign key untuk model lain (Pages)
        );
    }
}
