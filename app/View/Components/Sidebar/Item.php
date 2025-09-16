<?php

namespace App\View\Components\Sidebar;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Item extends Component
{
    public $title;
    public $type;
    public $url;
    /**
     * Create a new component instance.
     */
    public function __construct(string $title, string $url, string $type)
    {
        $this->title = $title;
        $this->type = $type;
        $this->url = $url;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar.item');
    }
}
