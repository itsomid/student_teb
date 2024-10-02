<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class StudentSelectionComponent extends Component
{
    public string $name;
    public bool $multiple=false;
    public string|int $selected;
    public ?string $selectedLabel = null;

    /**
     * Create a new component instance.
     */
    public function __construct(string $name, bool $multiple, string|int $selected, ?string $selectedLabel = null)
    {
        $this->name = $name;
        $this->multiple = $multiple;
        $this->selected = $selected;
        $this->selectedLabel = $selectedLabel;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.student-selection-component');
    }
}

