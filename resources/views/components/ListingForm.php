<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ListingForm extends Component
{
    public $categories;
    public $breeds;
    public $route;

    /**
     * Create a new component instance.
     */
    public function __construct($categories, $breeds, $route)
    {
        $this->categories = $categories;
        $this->breeds = $breeds;
        $this->route = $route;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.listing-form');
    }
}
