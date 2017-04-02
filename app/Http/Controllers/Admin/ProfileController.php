<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{

    public function edit()
    {
        $this->authorize('update', $user = auth()->user());

        return view('admin.users.profile', [
            'user' => $user,
            'edited' => request()->session()->get('edited', null)
        ]);
    }

    public function update(Request $request)
    {
        $this->authorize('update', $user = auth()->user());

        $this->validate($request, [
            'name' => 'required|unique:users,name,'.$user->id.'|max:255',
            'email' => 'required|unique:users,email,'.$user->id.'|max:255',
            'type' => 'required',
            'password' => 'required|confirmed|min:6|max:255'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->type = $request->type;
        $user->password = bcrypt($request->password);
        $user->update();

        $request->session()->flash('edited', $user->id);
        return redirect(url('/admin/profile'));
    }

}
