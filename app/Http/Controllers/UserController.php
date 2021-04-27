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
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
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
                $users = User::orderBy('id', 'DESC')->paginate();
            }
        } else {
            $users = User::orderBy('id', 'DESC')->paginate();
        }
        return view('users.index', compact('users', 'msg'))
                        ->with('i', ($request->input('page', 1) - 1) * 5);
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
            'roles' => 'required'
        ]);
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $extension = $file->getClientOriginalExtension();
            $allowed = array('jpg', 'png', 'jpeg', 'gif');
            if (in_array(strtolower($extension), $allowed)) {
                $filename = $request['email'] . "." . $extension;
                $request->file('profile_picture')->storeAs('public', $filename);
            } else {
                $filename = "user.jpg";
                $msg = "No se guardó la foto, formato inválido.";
            }
        } else {
            $filename = "user.jpg";
        }
        $input = $request->all();
        $input['profile_picture'] = $filename;
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
                        ->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id) {
        $msg = '';
        if (!empty($request['email'])) {
            $user = User::where('email', $request['email'])->first();
            if (!$user) {
                $msg = "El usuario no existe";
            }
        } else {
            $user = User::find($id);
        }
        return view('users.show', compact('user', 'msg'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $user = User::find($id);
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
    public function update(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
        ]);

        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $extension = $file->getClientOriginalExtension();
            $allowed = array('jpg', 'png', 'jpeg', 'gif');
            if (in_array(strtolower($extension), $allowed)) {
                $filename = $request['email'] . "." . $extension;
                if ($request['old_profile_picture'] != "user.jpg") {
                    $request->file('profile_picture')->storeAs('public', $filename);
                }
            } else {
                $filename = $request['old_profile_picture'];
                $msg = "No se guardó la foto, formato inválido.";
            }
        } else {
            $filename = $request['old_profile_picture'];
        }
        $input = $request->all();
        $input['profile_picture'] = $filename;
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }
        $user = User::find($id);
        $user->update($input);
        if (isset($input['roles'])) {
            DB::table('model_has_roles')->where('model_id', $id)->delete();
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
    public function destroy($id) {
        $profile_picture = User::find($id)->profile_picture;
        if ($profile_picture != "user.jpg") {
            unlink(storage_path('app/public/' . $profile_picture));
        }
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success', 'User deleted successfully');
    }

}
