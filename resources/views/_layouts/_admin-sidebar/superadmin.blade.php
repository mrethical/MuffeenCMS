<?php

if (!isset($active)) {
    $active = [0, 0];
} else {
    $active = explode('-', $active);
}

?>
<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="{{ ($active[0] == '1') ? 'active' : '' }}">
                <a href="{{ url('/admin') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
            </li>
        </ul>
    </section>
</aside>