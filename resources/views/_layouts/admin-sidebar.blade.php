<?php

if (!isset($active)) {
    $active = [null, null];
} else {
    $active = explode('-', $active);
    if (!isset($active[1])) {
        $active[1] = null;
    }
}

$user = auth()->user();

?>
<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ ($user->picture)
                        ? url($uploads_users_url . '/' . $user->picture) : url('/img/user.png') }}"
                     class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ $user->first_name . ' ' . $user->last_name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="{{ ($active[0] == 'Dashboard') ? 'active' : '' }}">
                <a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
            </li>
            <li class="{{ ($active[0] == 'Inquiries') ? 'active' : '' }}">
                <a href="{{ url('/admin/inquiries') }}"><i class="fa fa-envelope"></i> <span>Inquiries</span></a>
            </li>
            <li class="treeview {{ ($active[0] == 'Posts') ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-thumb-tack"></i> <span>Posts</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu menu-open">
                    <li class="{{ ($active[1] == 'All Posts') ? 'active' : '' }}">
                        <a href="{{ url('/admin/posts') }}">All Posts</a>
                    </li>
                    <li class="{{ ($active[1] == 'Add New') ? 'active' : '' }}">
                        <a href="{{ url('/admin/posts/create') }}">Add New</a>
                    </li>
                    <li class="{{ ($active[1] == 'Categories') ? 'active' : '' }}">
                        <a href="{{ url('/admin/posts/categories') }}">Categories</a>
                    </li>
                    <li class="{{ ($active[1] == 'Tags') ? 'active' : '' }}">
                        <a href="{{ url('/admin/posts/tags') }}">Tags</a>
                    </li>
                </ul>
            </li>
            <li class="treeview {{ ($active[0] == 'Pages') ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-clone"></i> <span>Pages</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu menu-open">
                    <li class="{{ ($active[1] == 'All Pages') ? 'active' : '' }}">
                        <a href="{{ url('/admin/pages') }}">All Pages</a>
                    </li>
                    <li class="{{ ($active[1] == 'Add New') ? 'active' : '' }}">
                        <a href="{{ url('/admin/pages/create') }}">Add New</a>
                    </li>
                </ul>
            </li>
            @if (!$menus->isEmpty())
                <li class="treeview {{ ($active[0] == 'Menus') ? 'active' : '' }}">
                    <a href="#">
                        <i class="fa fa-bars"></i> <span>Menus</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu menu-open">
                        @foreach($menus as $menu)
                            <li class="{{ ($active[1] == $menu->name) ? 'active' : '' }}">
                                <a href="{{ url('/admin/menus/'.$menu->id.'/edit') }}">{{ $menu->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endif
            <li class="treeview {{ ($active[0] == 'Resources') ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-file"></i> <span>Resources</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu menu-open">
                    <li class="{{ ($active[1] == 'All Resources') ? 'active' : '' }}">
                        <a href="{{ url('/admin/resources') }}">All Resources</a>
                    </li>
                    <li class="{{ ($active[1] == 'Add New') ? 'active' : '' }}">
                        <a href="{{ url('/admin/resources/create') }}">Add New</a>
                    </li>
                    <li class="{{ ($active[1] == 'Categories') ? 'active' : '' }}">
                        <a href="{{ url('/admin/resources/categories') }}">Categories</a>
                    </li>
                </ul>
            </li>
            <li class="treeview {{ ($active[0] == 'Users') ? 'active' : '' }}">
                <a href="#">
                    <i class="fa fa-users"></i> <span>Users</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
                <ul class="treeview-menu menu-open">
                    <li class="{{ ($active[1] == 'All Users') ? 'active' : '' }}">
                        <a href="{{ url('/admin/users') }}">All Users</a>
                    </li>
                    <li class="{{ ($active[1] == 'Add New') ? 'active' : '' }}">
                        <a href="{{ url('/admin/users/create') }}">Add New</a>
                    </li>
                    <li class="{{ ($active[1] == 'Your Profile') ? 'active' : '' }}">
                        <a href="{{ url('/admin/profile') }}">Your Profile</a>
                    </li>
                </ul>
            </li>
        </ul>
    </section>
</aside>