<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RolesRequest;
use App\Models\Roles;
use App\Http\Controllers\Controller;

class RolesController extends Controller
{
    function index(){
        $roles = Roles::get();
        return view('admin.roles',compact('roles'));
    }

    function store(RolesRequest  $request){
        Roles::create($request->all());

        flash()->success(__('Role created successfully'));

        return redirect()->back();
    }

    function update(RolesRequest $request, $id){
        $role = Roles::findOrFail($id);
        $role->fill($request->all())->save();

        flash()->success(__('Role updated successfully'));

        return redirect()->back();
    }
}
