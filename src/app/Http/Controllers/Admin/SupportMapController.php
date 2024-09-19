<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\SupportMap;
use Illuminate\Http\Request;

class SupportMapController extends Controller
{
    public function index()
    {
        $maps            = SupportMap::query()->withCount('admins')->get();
        return view('dashboard.support_map.index')->with([
            'maps' => $maps,
        ]);
    }

    public function store()
    {
        $this->validate(request(), [
            'title' => ['required', 'string', 'max:50'],
        ]);

        $support_map= SupportMap::query()->create([
           'title' => request('title'),
        ]);

        return redirect()->route('admin.support_map.edit', ['support_map' => $support_map->id]);
    }

    public function edit(SupportMap $support_map)
    {
        $onsite_supports = Admin::query()->role('sales_onsite')->get();

        $selectedGrades= SupportMap::query()
            ->select('grades')
            ->where('id', '<>', $support_map->id)
            ->get()
            ->pluck('grades')
            ->flatten()
            ->unique()
            ->toArray();

        $selectedAdmins= SupportMap::query()
                ->select('id')
                ->where('id', '<>', $support_map->id)
                ->with('admins')
                ->get()
                ->pluck('admins')
                ->flatten()
                ->pluck('id')
                ->toArray();


        return view('dashboard.support_map.edit')->with([
            'support_map'     => $support_map,
            'onsite_supports' => $onsite_supports,
            'selectedGrades' => $selectedGrades,
            'selectedAdmins' => $selectedAdmins,
        ]);
    }

    public function update(SupportMap $support_map)
    {
        $this->validate(request(), [
            'title'   => ['required', 'string', 'max:50'],
            'grades'  => ['required', 'array'],
            'admins'  => ['required', 'array'],
        ]);

        $support_map->update([
            'title'  =>  request('title'),
            'grades' =>  request('grades'),
        ]);

        $support_map->admins()->sync(request()->admins);

        return redirect()->route('admin.support_map.index');
    }
}
