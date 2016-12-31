<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="{{ url('/admin') }}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>
            <li>
                <a href="#"><i class="fa fa-thumb-tack fa-fw"></i> Posts<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ url('/admin/posts') }}">All Posts</a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/posts/create') }}">Add New</a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/posts/categories') }}">Categories</a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/posts/tags') }}">Tags</a>
                    </li>
                </ul>
            </li>
            <li>
                <a><i class="fa fa-file fa-fw"></i> Resources<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ url('/admin/resources') }}">All Resources</a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/resources/create') }}">Add New</a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/resources/categories') }}">Categories</a>
                    </li>
                </ul>
            </li>
            <li>
                <a><i class="fa fa-user fa-fw"></i> Users<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ url('/admin/users') }}">All Users</a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/users/create') }}">Add New</a>
                    </li>
                    <li>
                        <a href="{{ url('/admin/profile') }}">Your Profile</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>