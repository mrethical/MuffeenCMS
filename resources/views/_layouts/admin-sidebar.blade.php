<?php

if (!isset($active)) {
    $active = [null, null];
} else {
    $active = explode('-', $active);
    if (!isset($active[1])) {
        $active[1] = null;
    }
}

?>
<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="{{ ($active[0] == 'Dashboard') ? 'active' : '' }}">
                <a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
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