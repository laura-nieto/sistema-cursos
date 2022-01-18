<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Academy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
            ->yourAcademy()
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
        $academias = Academy::userAcademy()->get();
        //ROLES
        if ($request->user()->hasRole(1)) {
            $roles = Role::all();
        } elseif($request->user()->hasRole(2)){
            $roles = Role::all()->except([1,2]);
        } else{
            $roles = Role::all()->except([1,2,3,5]);
        }
        return view('user.create',compact('roles','academias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $date = array(
            'active' => 'true',
            'password' => Hash::make($request->password),
        );
        $user = $this->user->create($date + $request->except(['password']));
        $user->assignRole($request->role);
        return redirect()->route('usuarios.index')->with('status','El usuario fue creado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        $user = User::findOrFail($user_id);
        return view('user.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$user_id)
    {
        $user = User::findOrFail($user_id);
        $academias = Academy::userAcademy()->get();
        //ROLES
        if ($request->user()->hasRole(1)) {
            $roles = Role::all();
        } elseif($request->user()->hasRole(2)){
            $roles = Role::all()->except([1,2]);
        } else{
            $roles = Role::all()->except([1,2,3]);
        }

        return view('user.edit',compact('user','roles','academias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $user_id)
    {
        $user = $this->user::findOrFail($user_id);
        $date = array(
            'active' => 'true',
            'password' => $request->password === $user->password ? $user->password : Hash::make($request->password),
        );
        $user->update($date + $request->except(['password']));

        return redirect()->route('usuarios.index')->with('status','El usuario fue modificado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id)
    {   
        $user = User::findOrFail($user_id);
        $user->active = false;
        $user->save();
        return redirect()->route('usuarios.index')->with('status','El usuario ha sido eliminado');
    }
}
