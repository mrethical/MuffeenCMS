<?php

namespace App\Http\Controllers\Admin;

use App\Models\Repositories\UsersRepositoryInterface;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;

class UserController extends Controller
{

    /**
     * @var ResourcesCategoriesRepositoryInterface
     */
    private $_users;

    public function __construct(UsersRepositoryInterface $users)
    {
        $this->_users = $users;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $output = $request->input('output', 'page');
        if (Auth::user()->can('view_all', User::class)) {
            $limit = $request->input('limit', 5);
            $offset = $request->input('offset', 0);
            $users = $this->_users->getAllWithLimit($limit, $offset);
            $count = $this->_users->getCountAll();
            if ($output === 'page') {
                $added = $request->session()->get('added', null);
                return view('admin.users.index', compact('users', 'count', 'added'));
            } else if ($output === 'table') {
                return view('admin.users.tables.users-table', compact('users', 'count'));
            } else {
                return response('', 204);
            }
        } else {
            if ($output === 'page') {
                return response()->view('errors.admin-403')->setStatusCode(403);
            } else if ($output === 'table') {
                $users = [];
                $count = [];
                return response()->view('admin.users.tables.users-table', compact('users', 'count'))->setStatusCode(403);
            } else {
                return response('', 403);
            }
        }
    }

    private function _getUserTypes()
    {
        $types = ['admin', 'member'];
        if (Auth::user()->type === 'superadmin') $types[] = 'superadmin';
        return $types;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usertypes = $this->_getUserTypes();
        if (Auth::user()->can('create', User::class)) {
            return view('admin.users.create', compact('usertypes'));
        } else {
            return response()->view('errors.admin-403')->setStatusCode(403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->can('create', User::class)) {
            $this->validate($request, [
                'name' => 'required|max:255|unique:users',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6|confirmed',
                'type' => 'required',
            ]);
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->type = $request->type;
            $success = $user->save();
            if ($success) {
                $request->session()->flash('added', $user->id);
                return redirect('/admin/users');
            } else {
                return response()->view('errors.admin-500')->setStatusCode(500);
            }
        } else {
            return response()->view('errors.admin-403')->setStatusCode(403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        $usertypes = $this->_getUserTypes();
        if (Auth::user()->can('update', $user)) {
            $edited = request()->session()->get('edited', null);
            return view('admin.users.edit', compact('usertypes', 'user', 'edited'));
        } else {
            return response()->view('errors.admin-403')->setStatusCode(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if (Auth::user()->can('update', $user)) {
            $validation = [
                'name' => 'required|max:255|unique:users,name,' . $user->id,
                'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            ];
            if ($request->password) $validation['password'] = 'required|min:6|confirmed';
            if ($request->type) $validation['type'] = 'required';
            $this->validate($request, $validation);
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->password) $user->password = bcrypt($request->password);
            if ($request->type) $user->type = $request->type;
            $success = $user->update();
            if ($success) {
                $request->session()->flash('edited', $user->id);
                return redirect(url()->previous());
            } else {
                return response()->view('errors.admin-500')->setStatusCode(500);
            }
        } else {
            return response()->view('errors.admin-403')->setStatusCode(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (Auth::user()->can('delete', $user)) {
            $success = $user->delete();
            return response()->json(['success' => $success]);
        } else {
            return response()->json('Sorry, you are not authorized to do this action.')->setStatusCode(403);
        }
    }

}
