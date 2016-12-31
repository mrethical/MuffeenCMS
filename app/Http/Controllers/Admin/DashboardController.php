<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    /**
     * Show the form for editing the current user profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $user = Auth::user();
        if (Auth::user()->can('update', $user)) {
            $edited = request()->session()->get('edited', null);
            return view('admin.profile', compact('user', 'edited'));
        } else {
            return response()->view('errors.admin-403')->setStatusCode(403);
        }
    }
}
