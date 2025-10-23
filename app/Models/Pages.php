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
        'type', //['gallery', 'blog']
        'is_active', //['true','false']
        'created_by',
        'updated_by'
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime'
        ];
    }

    public function penulis()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tags::class,        // model tujuan
            'page_tags',        // nama tabel pivot
            'page_id',          // foreign key untuk model ini (Pages)
            'tag_id'            // foreign key untuk model lain (Tags)
        );
    }
}
