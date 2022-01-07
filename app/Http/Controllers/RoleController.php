<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    protected $role;

    public function __construct(Role $role)
    {
        $this->middleware('permission:roles.index')->only('index','show');
        $this->middleware('permission:roles.create')->only('create','store');
        $this->middleware('permission:roles.edit')->only('edit','update');
        $this->middleware('permission:roles.destroy')->only('destroy');
        $this->role = $role;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = $request->name;

        $roles = $this->role
            ->where('roles.name','ILIKE', "$name%")
            ->orderBy('id','desc')
            ->paginate(20)
            ->withQueryString();
        
        return view('role.index',compact('roles','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permisos = Permission::all();
        return view('role.create',compact('permisos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = ['name'=>'required','permisos'=>'required|array|min:1'];
        $request->validate($rules);
        $rol = $this->role->create(['name'=>$request->name]);
        $rol->syncPermissions($request->permisos);
        
        return redirect('/roles')->with('status','El rol ha sido creado con éxito');
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
        $permisos = Permission::all();
        return view('role.edit',compact('role','permisos'));
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
        $rules = ['name'=>'required','permisos'=>'required|array|min:1'];
        $request->validate($rules);

        $role->update(['name'=>$request->name]);
        $role->syncPermissions($request->permisos);

        return back()->with('status','El rol ha sido editado con éxito.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect('roles')->with('status','El rol ha sido eliminado con éxito.');
    }
}
