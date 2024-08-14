<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassBlock;
use Illuminate\Contracts\View\View;

class ClassBlockController extends Controller
{
    public function index(): View
    {
        $classBlocks = ClassBlock::query()
            ->with('product', 'student')
            ->filterBy(request()->only('product', 'student'))
            ->get();

        return view('dashboard.class_block.index', compact('classBlocks'));
    }

    public function create(): View
    {
        return view('dashboard.class_block.create');
    }
}
