<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller

{
    public function index()
    {
        $users = User::all();
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        $users = User::all();
        return view('admin.user.create', compact('users'));
    }

    public function show($id){
        $users = User::findOrFail($id);
        return view('admin.user.show', compact('users'));
    }

        public function edit($id)
    {
        $users = User::findOrFail($id);
        return view('admin.user.edit', compact('users'));
    }   


    public function update(Request $request, $id)
    {
        $users = User::findOrFail($id);
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email,' . $users->idUser . ',idUser',
            'role' => 'required',
            'nim' => 'nullable|unique:users,nim,' . $users->idUser . ',idUser',
            'password' => 'nullable|confirmed',
        ],[
            'nama.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.unique' => 'Email sudah terdaftar',
            'role.required' => 'Role harus diisi',
            'nim.required' => 'Nim harus diisi',
            'nim.unique' => 'Nim sudah terdaftar',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);
        $users = User::findOrFail($id);
        $input = $request->all();
        if ($request->filled('password')) {
            $input['password'] = bcrypt($request->password);
        } else {
            unset($input['password']);
        }
        $users->update($input);
        return redirect()->route('admin.user.index')->with('success', 'User Berhasil Diperbarui');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => 'required',
            'nim' => 'nullable|unique:users,nim',
            'password' => 'required|confirmed',
        ],[
            'nama.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.unique' => 'Email sudah terdaftar',
            'role.required' => 'Role harus diisi',
            'nim.required' => 'Nim harus diisi',
            'nim.unique' => 'Nim sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);
        
        $users = User::create($request->all());
        return redirect()->route('admin.user.index')->with('success', 'User Berhasil Ditambahkan');
    }


    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('admin.user.index');
    }
}
