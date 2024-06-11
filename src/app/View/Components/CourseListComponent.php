<?php

namespace App\View\Components;

use App\Models\Course;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CourseListComponent extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public string $inputName)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $courses = Course::query()->with('product:name')->select('product_id')->get();
        return view('components.course-list-component', compact('courses'));
    }
}
