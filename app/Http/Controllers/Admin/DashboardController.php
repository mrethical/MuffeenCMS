<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $posts_count = \App\Repositories\Posts::getCount();
        $pages_count = \App\Repositories\Pages::getCount();
        $inquiries_count = \App\Repositories\Inquiries::getCount();
        $users_count = \App\Repositories\Users::getCount();

        $posts = \App\Repositories\Posts::getLatestOnLastThirtyDaysWithLimit(8);
        $pages = \App\Repositories\Pages::getLatestOnLastThirtyDaysWithLimit(8);
        $users = \App\Repositories\Users::getLatestOnLastThirtyDaysWithLimit(8);

        return view('admin.dashboard', compact(
            'posts_count', 'pages_count', 'inquiries_count', 'users_count',
            'posts', 'pages', 'users'
        ));
    }
}
