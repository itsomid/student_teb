<?php

namespace App\View\Components;

use App\Models\Admin;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TeacherSelectionComponent extends Component
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
        $teachers = Admin::query()->role('teacher')->select('id', 'first_name', 'last_name')->get();
        return view('components.teacher-selection-component', compact('teachers'));
    }
}
