<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'karyawan';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'nip',
        'img_profile',
        'jabatan',
        'bio', //nullable
        'instagram', //['gallery', 'blog']
        'facebook', //['true','false']
        'tiktok',
        'struktural',
        'urutan',
        'created_by',
        'updated_by'
    ];

    protected function casts(): array
    {
        return [
            'struktural' => 'boolean'
        ];
    }
}
