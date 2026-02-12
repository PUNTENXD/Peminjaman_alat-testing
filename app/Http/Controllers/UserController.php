<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id_user','desc')->get();
        return view('User.index', compact('users'));
    }

    public function create()
    {
        return view('User.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'password' => 'required',
            'role' => 'required|in:admin,petugas,peminjam'
        ]);

        User::create([
            'username' => $request->username,
            'password' => $request->password, // PLAINTEXT
            'role' => $request->role,
        ]);

        return redirect('/user')->with('success','User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('User.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'required|unique:users,username,'.$user->id_user.',id_user',
            'role' => 'required|in:admin,petugas,peminjam'
        ]);

        $user->username = $request->username;
        $user->role = $request->role;

        if ($request->password) {
            $user->password = $request->password;
        }

        $user->save();

    return redirect()->back()->with('success', 'User berhasil diperbarui');

    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'admin') {
            return back()->withErrors('Admin tidak boleh dihapus');
        }

        $user->delete();
        return back()->with('success','User dihapus');
    }
}
