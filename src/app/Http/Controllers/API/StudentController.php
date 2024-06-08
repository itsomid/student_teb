<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;


class StudentController extends Controller
{

    public function note(User $student)
    {
        return $student->sales_description;
    }
    public function updateNote(Request $request, User $student)
    {
        $request->validate([
            'description' => ['nullable']
        ]);
        $student->update([
            'sales_description' => $request->sales_description
        ]);

        return $student;
    }

}
