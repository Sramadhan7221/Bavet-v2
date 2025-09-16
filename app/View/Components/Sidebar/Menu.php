<?php

namespace App\View\Components\Sidebar;

use App\Services\NavigatorService;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Menu extends Component
{
    public $menus;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->menus = NavigatorService::getMenus();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar.menu');
    }
}
