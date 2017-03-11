<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function home()
    {
        $title = config('app.name');
        return view('pages.home', compact('title'));
    }
    public function about()
    {
        $title = 'About | ' . config('app.name');
        return view('pages.about', compact('title'));
    }
    public function contact()
    {
        $title = 'Contact | ' . config('app.name');
        return view('pages.contact', compact('title'));
    }
}
