<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Repositories\MenusRepositoryInterface;
use App\Services\MenuService;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    private $_menus;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MenusRepositoryInterface $menus)
    {
        $this->_menus = MenuService::getMenus($menus);
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        $title = 'Login | ' . config('app.name');
        $menus = $this->_menus;
        return view('auth.login', compact('title', 'menus'));
    }

    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/login');
    }
}
