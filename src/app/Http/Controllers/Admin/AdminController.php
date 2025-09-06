<?php

namespace App\Http\Controllers\Admin;

use App\Functions\FlashMessages\Toast;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::query()
            ->orderBy('id')
            ->search(request()->input('key'))
            ->filterBy(request()->all())
            ->paginate(100);

        return view('dashboard.admin.index')
            ->with('admins', $admins);
    }

    public function create()
    {
        $supervisors = Admin::adminAndSupervisor()->get();
        $roles = Role::query()->get();

        return view('dashboard.admin.create')->with([
            'supervisors' => $supervisors,
            'roles' => $roles
        ]);
    }

    public function store(Request $request)
    {

        $data = $this->validate($request, [
            'first_name' => ['required', 'max:30'],
            'last_name' => ['required', 'max:30'],
            'supervisor_id' => 'nullable',
            'mobile' => ['required', 'regex:/(09)[0-9]{9}/', 'digits:11', 'unique:admins,mobile'],
            'password' => ['required', 'min:6'],
            'roles' => ['required', 'array'],
            'email' => ['nullable', 'email', 'unique:admins,email'],
            'instagram' => 'nullable',
            'telegram' => 'nullable',
            'whatsapp' => 'nullable'
        ]);

        $user = Admin::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'mobile' => $data['mobile'],
            'email' => $data['email'],
            'supervisor_id' => $data['supervisor_id'],
            'password' => Hash::make($data['password']),
            'gender' => $request->gender,
            'instagram' => $data['instagram'],
            'telegram' => $data['telegram'],
            'whatsapp' => $data['whatsapp'],
        ]);

        //attach user roles
        $user->roles()->sync($request->roles);
        Toast::message('کاربر با موفقیت ایجاد شد.')->success()->notify();
        return redirect()->route('admin.admin.index');
    }

    public function edit(Admin $admin)
    {

        $supervisors = Admin::adminAndSupervisor()->get();
        $teachers = '';
        if ($admin->hasRole('teacher_assistant')) {
            $teachers = Admin::role('teacher')->get();
        }



        return view('dashboard.admin.edit')->with([
            'admin' => $admin,
            'supervisors' => $supervisors,
            'teachers' => $teachers,
        ]);
    }

    public function update(Admin $admin, Request $request)
    {
        $this->validate($request, [
            'first_name' => ['required', 'max:30'],
            'last_name' => ['max:30'],
            'supervisor_id' => ['required', 'numeric'],
            'teacher_id' => ['numeric'],
            'email' => ['nullable', 'email', Rule::unique('admins', 'email')->ignore($admin->id)],
        ]);


        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'supervisor_id' => $request->supervisor_id,
            'teacher_id' => $request->teacher_id,
            'gender' => $request->gender,
            'email' => $request->email,
            'instagram' => $request->instagram,
            'telegram' => $request->telegram,
            'whatsapp' => $request->whatsapp,
        ];

        $admin->update($data);
        Toast::message('کاربر با موفقیت ویرایش شد.')->success()->notify();
        return redirect()->route('admin.admin.index');
    }
    public function passwordEdit(Admin $admin)
    {
        return view('dashboard.admin.edit-password')
            ->with('admin', $admin);
    }

    public function passwordUpdate(Request $request, Admin $admin)
    {
        $this->validate($request, [
            'password' => ['required', 'confirmed', 'min:6']
        ]);

        $admin->password = Hash::make($request->password);
        $admin->save();
        Toast::message('رمز عبور با موفقیت ویرایش شد.')->success()->notify();
        return redirect()->route('admin.admin.index');
    }
    
    public function toggle(Admin $admin)
    {
        $admin->is_active = !$admin->is_active;
        $admin->save();

        return redirect()->back();
    }

    public function login_as_admin($admin)
    {
        $user = auth()->user();
        $admin = Admin::query()->findOrFail($admin);

        session()->put('super_admin', $user->id);

        auth()->login($admin);

        return redirect("/admin");
    }

    public function back_to_admin_panel()
    {
        if (session()->has('super_admin')) {
            $admin_id = session()->get('super_admin');
            session()->forget('super_admin');

            auth()->login(Admin::find($admin_id));
            return redirect("/admin");
        } else {
            return abort(404);
        }
    }
}
