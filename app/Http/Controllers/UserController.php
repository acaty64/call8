<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('app.user.index')
                ->with('data', $users);
    }

    public function create()
    {
        return view('app.user.create');
    }

    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'given_name' => $request->given_name,
            'email' => $request->email,
            'password' => $request->password,
            'code' => $request->code
        ]);

        return redirect(route('user.create'));
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('app.user.edit')
                ->with('item', $user);
    }

    public function update(Request $request)
    {
        $user = User::findOrFail($request->id);
        $user->name = $request->name;
        $user->given_name = $request->given_name;
        $user->code = $request->code;
        $user->email = $request->email;
        $user->save();
        return redirect(route('users.index'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return redirect('app.user.index');

    }
}
