<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ImageButton extends Component
{

    public $itemId;
    public $type;
    /**
     * Create a new component instance.
     */
    public function __construct($itemId, $type)
    {
        $this->itemId = $itemId;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.image-button');
    }
}
