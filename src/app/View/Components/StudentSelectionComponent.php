<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StudentSelectionComponent extends Component
{
    public string $name;
    public bool $multiple=false;
    public $selected;

    /**
     * Create a new component instance.
     */
    public function __construct( $name, $multiple,$selected)
    {
        $this->name = $name;
        $this->multiple = $multiple;
        $this->selected = $selected;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.student-selection-component');
    }
}

