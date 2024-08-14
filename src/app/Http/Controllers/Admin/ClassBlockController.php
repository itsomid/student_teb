<?php

namespace App\Http\Controllers\Admin;

use App\Functions\FlashMessages\Toast;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClassBlock\CreateRequest;
use App\Models\ClassBlock;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

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

    public function store(CreateRequest $request): RedirectResponse
    {
        $input = $request->all();

        $usersIds = [];
        $usersMobileSplit = explode("\n", trim($input['users_list']));
        foreach ($usersMobileSplit as $userIdentity) {
            $userIdentity = trim($userIdentity);
            if (strlen($userIdentity) > 0) {
                $userFound = null;
                if (strlen($userIdentity)==11) {
                    $userFound = User::query()->where('mobile',$userIdentity)->first();
                }else{
                    $userFound = User::query()->find($userIdentity);
                }

                if ($userFound) {
                    $usersIds[] = $userFound->id;
                }
            }
        }
        if (empty($input['description'])) {
            $input['description']='blocked';
        }
        //save records
        foreach ($usersIds as $tmp_user_id) {
            ClassBlock::query()->create([
                'student_id' => $tmp_user_id,
                'product_id' => $input['product_id'],
                'description' => $input['description'],
                'expired_at' => $input['expired_at']
            ]);
        }

        Toast::message('بلاک کاربر با موفقیت انجام شد.')->success()->notify();
        return redirect()->route('admin.class-block.index');
    }
}
