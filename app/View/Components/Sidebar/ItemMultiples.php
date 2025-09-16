<?php

namespace App\View\Components\Sidebar;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class ItemMultiples extends Component
{
    public $title;
    public $slug;
    public $items;
    /**
     * Create a new component instance.
     */
    public function __construct( string $title, string $slug, Collection $items)
    {        
        $this->title = $title;
        $this->slug = $slug;
        $this->items = $items;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar.item-multiples');
    }
}
