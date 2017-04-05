<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Repositories\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{

    public function index()
    {
        $this->authorize('view_all', User::class);

        if(request()->ajax()) {
            return response()->json([
                'list' => Users::getAllPermittedWithLimit(
                    request('limit', 100),
                    (request('page', 1) - 1) * request('limit', 100)
                ),
                'count' => Users::getCountPermitted()
            ])
                ->header('Cache-Control', ' no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        }

        return view('admin.users.index');
    }

    public function create()
    {
        $this->authorize('create', User::class);


        return view('admin.users.create', [
            'user' => new User
        ]);
    }


    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $this->validate($request, [
            'name' => 'required|unique:users|max:255',
            'email' => 'required|email|unique:users|max:255',
            'type' => 'required',
            'password' => 'required|confirmed|min:6|max:255'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'type' => $request->type,
            'password' => bcrypt($request->password)
        ]);

        $request->session()->flash('added', $user->id);
        return redirect(url('/admin/users'));
    }


    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return view('admin.users.edit', compact('user'));
    }


    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $this->validate($request, [
            'name' => 'required|unique:users,name,'.$user->id.'|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id.'|max:255',
            'type' => 'required',
            'password' => 'required|confirmed|min:6|max:255'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->type = $request->type;
        $user->password = bcrypt($request->password);
        $user->update();

        $request->session()->flash('edited', $user->id);
        return redirect(url('/admin/users/'.$user->id.'/edit'));
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $success = $user->delete();
        return response()->json(['success' => $success]);
    }

}
