<?php

namespace App\Http\Controllers;

use App\Helpers\LogActivity;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('permission:role.view')->only('index');
        $this->middleware('permission:role.create')->only('store');
        $this->middleware('permission:role.edit')->only('update');
        $this->middleware('permission:role.delete')->only('destroy');
    }
    public function index()
    {
        $roles = Role::all();
        $permissions = [
            'role','user','product'
        ];
        return view('admin.role', compact('roles','permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['name' => ['required']]);
        $role = Role::create(['name' => $request->name,'guard_name'=>'web']);
        // delete all permission
        $keys = $request->keys();
        unset($keys[0], $keys[1]);
        foreach ($keys as $key) {
            $roleName = explode('-', $key);
            $role->givePermissionTo($roleName[1] . '.' . $roleName[2]);
        }
        LogActivity::addToLog("Add Role " . $request->name);
        return redirect(route('admin.role.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {

        $request->validate(['name'=>'required']);
        $user = auth()->user();
        $role->update(['name'=>$request->name]);

        // $user->syncPermissions($user->getAllPermissions());
        
        // set permission
        $role->syncPermissions([]);
        $keys = $request->keys();
        unset($keys[0],$keys[1],$keys[2]);
        foreach($keys as $key){
            $roleName= explode('-',$key);

            $role->givePermissionTo($roleName[1].'.'.$roleName[2]);
        }
        LogActivity::addToLog("Add Role " . $request->name);
        return redirect(route('admin.role.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        Role::destroy($role->id);
        LogActivity::addToLog('Delete role ' . $role->name);
        return redirect(route('admin.role.index'));
    }
}
