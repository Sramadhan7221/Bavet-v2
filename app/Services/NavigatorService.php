<?php

namespace App\Services;

use App\Models\Menus;
use Illuminate\Support\Collection;

class NavigatorService
{
    public static function getMenus() : Collection
    {
        return Menus::where('type','!=','external')->whereNull('parent_id')->with('children')->get();
    }
}
