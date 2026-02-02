<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CategoryTree extends Component
{
    /**
     * The categories to display.
     *
     * @var mixed
     */
    public $categories;
    /**
     * The selected categories.
     *
     * @var array
     */
    public $selected;
    /**
     * The current level in the tree.
     *
     * @var int
     */
    public $level;
    /**
     * Create a new component instance.
     * @param mixed $categories
     * @param array $selected
     * @param int $level
     */
      public function __construct(
        $categories, 
        $selected = [], 
        $level = 0
        ) {
        $this->categories = $categories;
        $this->selected = $selected;
        $this->level = $level;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.category-tree');
    }
}
