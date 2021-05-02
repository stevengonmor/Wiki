<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use File;

class UserController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct() {
        $this->middleware('permission:Ver Usuarios', ['only' => ['index', 'show']]);
        $this->middleware('permission:Crear Usuarios', ['only' => ['create', 'store']]);
        $this->middleware('permission:Editar Usuarios', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Eliminar Usuarios', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $msg = '';
        if (!empty($request['email'])) {
            $users = User::where('email', $request['email'])->paginate();
            if (!$users[0]) {
                $msg = "El usuario no existe";
                $users = User::all()->sortByDesc("id");
            }
        } else {
            $users = User::all()->sortByDesc("id");
        }
        return view('users.index', compact('users', 'msg'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $roles = Role::pluck('name', 'name')->all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
            'profile_picture' => 'image',
        ]);
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $extension = $file->getClientOriginalExtension();
            $filename = "tbd";
        } else {
            $filename = "user.jpg";
        }
        $input = $request->all();
        $input['profile_picture'] = $filename;
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        if ($filename == "tbd") {
            $input['profile_picture'] = "User" . $user->id . "." . $extension;
            $request->file('profile_picture')->storeAs('public', $input['profile_picture']);
            $user->update(array('profile_picture' => $input['profile_picture']));
        }
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index', 'msg')
                        ->with('success', 'Se creó el usuario.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, User $user) {
        $msg = '';
        if (!empty($request['email'])) {
            $user = User::where('email', $request['email'])->first();
            if (!$user) {
                $msg = "El usuario no existe";
            }
        }
        return view('users.show', compact('user', 'msg'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user) {
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        return view('users.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user) {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'same:confirm-password',
            'profile_picture' => 'image',
        ]);
        $input = $request->all();
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $extension = $file->getClientOriginalExtension();
            $filename = "User" . $user->id . "." . $extension;
            $request->file('profile_picture')->storeAs('public', $filename);
            $input['profile_picture'] = $filename;
        }
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }
        $user->update($input);
        if (isset($input['roles'])) {
            DB::table('model_has_roles')->where('model_id', $user->id)->delete();
            $user->assignRole($request->input('roles'));
        }
        return redirect()->route('users.show', $user->id)
                        ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user) {
        $profile_picture = $user->profile_picture;
        if ($profile_picture != "user.jpg") {
            unlink(storage_path('app/public/' . $profile_picture));
        }
        $user->delete();
        return redirect()->route('users.index')
                        ->with('success', 'Se borró el usuario.');
    }

}
