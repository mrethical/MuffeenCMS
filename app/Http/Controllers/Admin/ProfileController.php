<?php

namespace App\Http\Controllers\Admin;

use App\Services\Uploads;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{

    public function edit()
    {
        $this->authorize('update', $user = auth()->user());

        $password_required = false;

        return view('admin.users.profile', compact('user', 'password_required'));
    }

    public function update(Request $request)
    {
        $this->authorize('update', $user = auth()->user());

        $validate_args = [
            'name' => 'required|unique:users,name,'.$user->id.'|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id.'|max:255',
            'type' => 'required',
            'first_name' => 'required|max:255',
            'middle_name' => 'max:255',
            'last_name' => 'required|max:255'
        ];

        if ($request->password) {
            $validate_args['password'] = 'confirmed|min:6|max:255';
        }

        $this->validate($request, $validate_args);

        if ($request->picture) {
            $uploads = new Uploads;
            $picture = $uploads->saveUser($request->picture, $user->picture);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->type = $request->type;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->last_name = $request->last_name;
        if (isset($picture)) {
            $user->picture = $picture;
        }
        $user->update();

        $request->session()->flash('edited', $user->id);
        return redirect(url('/admin/profile'));
    }

}
