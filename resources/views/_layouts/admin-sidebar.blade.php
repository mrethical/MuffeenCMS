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
                        <a href="{{ url('/admin /profile') }}">Your Profile</a>
                    </li>
                </ul>
            </li>
        </ul>
    </section>
</aside>