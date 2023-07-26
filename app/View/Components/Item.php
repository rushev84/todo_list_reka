<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Item extends Component
{
    public $item;
    public $userTags;

    public function __construct($item, $userTags)
    {
        $this->item = $item;
        $this->userTags = $userTags;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.item');
    }
}
