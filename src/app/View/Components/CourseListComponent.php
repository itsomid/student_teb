<?php

namespace App\View\Components;

use App\Models\Course;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CourseListComponent extends Component
{
    public $selected= [];

    /**
     * Create a new component instance.
     */
    public function __construct(public string $name, public $multiple, $selected)
    {
        $this->selected =  json_decode($selected);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $courses = Course::query()->with('product')->select('id','product_id')->get();
        return view('components.course-list-component', compact('courses'));
    }
}
