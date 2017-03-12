<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Repositories\MenusRepositoryInterface;
use App\Services\MenuService;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    private $_menus;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MenusRepositoryInterface $menus)
    {
        $this->_menus = MenuService::getMenus($menus);
        $this->middleware('guest');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        $title = 'Reset Password | ' . config('app.name');
        $menus = $this->_menus;
        return view('auth.passwords.email', compact('title', 'menus'));
    }
}
