<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    protected $user;
    public function __construct(User $user)
    {
        $this->middleware('permission:users.index')->only('index','show');
        $this->middleware('permission:users.create')->only('create','store');
        $this->middleware('permission:users.edit')->only('edit','update');
        $this->middleware('permission:users.destroy')->only('destroy');
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dni = $request->dniDelUsuario;
        $email = $request->emailDelUsuario;
        $state = $request->disabled;

        $users = $this->user
            ->isDisabled($state)
            ->email($email)
            ->dni($dni)
            ->orderBy('id','desc')
            ->paginate(20)
            ->withQueryString();

        return view('user.index',compact('users','request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->user()->hasRole(1)) {
            $roles = Role::all();
        } elseif($request->user()->hasRole(2)){
            $roles = Role::all()->except([1,2]);
        } else{
            $roles = Role::all()->except([1,2,3]);
        }
        return view('user.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->role);
        $date = array(
            'active' => 'true'
        );
        $user = $this->user->create($date + $request->all());
        $user->assignRole($request->role);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
