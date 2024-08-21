<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StudentSelectionComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $inputName, public ?int $defaultValue = null)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.student-selection-component');
    }
}
