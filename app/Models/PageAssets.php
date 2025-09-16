<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class PageAssets extends Model
{
    use HasUuids;

    protected $table = 'page_assets';
    protected $guarded = 'id';
    protected $primayKey = 'id';
    protected $keyType = 'string';
    protected $fillable = [
        'page_id',
        'url',
        'type'
    ];
}
