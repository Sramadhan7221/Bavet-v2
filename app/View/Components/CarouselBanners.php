<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CarouselBanners extends Component
{
    public $bannerList;
    /**
     * Create a new component instance.
     */
    public function __construct($carousels)
    {
        $this->bannerList = $carousels;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.carousel-banners');
    }
}
