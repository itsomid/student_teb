<?php

namespace App\Http\Controllers\Admin;

use App\Functions\FlashMessages\Toast;
use App\Http\Controllers\Controller;
use App\Models\CCServer;
use Illuminate\Http\Request;

class CcServerController extends Controller
{
    public function index()
    {
        $cc_servers = CCServer::all();
        return view('dashboard.cc_server.index', compact('cc_servers'));
    }

    public function create()
    {
        return view('dashboard.cc_server.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
        ]);

        Toast::message('تغییرات با موفقیت اعمال شد')->success()->notify();
        CCServer::create($request->all());

        return redirect()->route('admin.cc_servers.index');
    }


    public function edit(CCServer $cc_server)
    {
        return view('dashboard.cc_server.edit', compact('cc_server'));
    }

    public function update(Request $request, CCServer $cc_server)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|url|max:255',
        ]);

        $cc_server->update($request->all());

        Toast::message('تغییرات با موفقیت اعمال شد')->success()->notify();
        return redirect()->route('admin.cc_servers.index');
    }

    public function destroy(CCServer $cc_server)
    {
        $cc_server->delete();

        Toast::message('حذف سرور با موفقیت انجام شد.')->success()->notify();
        return redirect()->route('admin.cc_servers.index');
    }
}
