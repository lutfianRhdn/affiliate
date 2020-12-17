<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Gate;
use App\Models\Role;
use Spatie\Permission\Models\Permission;
use Vinkla\Hashids\Facades\Hashids;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $router;
    protected $routes;

    public function __construct(Router $router)
    {
        $this->router = $router;
        $this->routes = $router->getRoutes();
        $this->middleware('permission:role.view')->only('index');
        $this->middleware('permission:role.create')->only('store');
        $this->middleware('permission:role.edit')->only('update');
        $this->middleware('permission:role.delete')->only('destroy');
    }
    public function index()
    {
        $roles= filterData('\App\Models\Role')->whereNotIn('name',['super-admin','admin','reseller','super-admin-company', 'super-admin']);
        foreach($roles as $key=>$role){
            if (strpos($role->name,'super-admin-')!== false) {
                unset($roles[$key]);
            }
        }
        $roleNames = getRoleName($this->routes);
        // dd($roleNames);
        if (!auth()->user()->hasRole('super-admin')) {
            unset($roleNames[1][0]);
        }
        return view('admin.role', compact('roles','roleNames'));
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
        $this->validate($request, ['name' => ['required','unique:roles']]);
        $roleModel = new Role;
        $role= $roleModel->createRole($request->all());
        // delete all permission
        dd($request);
        
        $keys = $request->keys();
        unset($keys[0], $keys[1]);
        if (auth()->user()->hasRole('super-admin')) {
            unset($keys[2]);
        }
        foreach ($keys as $key) {
            $roleName = explode('-', $key);
            $role->givePermissionTo($roleName[1] . '.' . $roleName[2]);
        }
        addToLog("Add Role " . $request->name);
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
        addToLog("Add Role " . $request->name);
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
        addToLog('Delete role ' . $role->name);
        return redirect(route('admin.role.index'));
    }
    // custom
    public function searchByCompany($company)
    {
        $companies = Company::where('name',$company)->get()->first();
        $roles= $companies->roles;
        $roleNames = getRoleName($this->routes);
        return view('admin.role', compact('roles','roleNames'));
    }
}
