<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\UserHistorySupport;
use Illuminate\Contracts\View\View;

class UserSupportController extends Controller
{
    public function index(): View
    {
        $userSupports= UserHistorySupport::query()->with('student', 'supporter')->filterBy(request()->only(['student_name']))->paginate(50);

        return view('dashboard.user_support.index')
            ->with(['userSupports' => $userSupports]);
    }
}
