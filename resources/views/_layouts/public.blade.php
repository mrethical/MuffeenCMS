<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $title }}</title>
    <meta name="description" content="A very, very simple CMS framework built on top of Laravel.">
    <meta name="author" content="Jefferson Magboo">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/united/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ mix('/css/style.css') }}">
    @yield('styles')
</head>
<body>

@if(isset($body_title))
<h1 class="hidden">{{ $body_title }}</h1>
@endif

<header>

    <nav class="navbar navbar-default navbar-static-top">
        <h2 class="hidden">Main Navigation</h2>
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name') }}</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    @foreach($menus as $menu)
                        @if($submenus = $menu->menus->all())
                            <li class="dropdown">
                                <a href="{{ ($menu->url != '#') ? url('/'.$menu->url) : '#' }}"
                                   class="dropdown-toggle" data-toggle="dropdown" role="button"
                                   aria-haspopup="true" aria-expanded="false">
                                        {{ $menu->name }}
                                        <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    @foreach($submenus as $submenu)
                                        <li>
                                            <a href="{{ ($submenu->url != '#') ? url('/'.$submenu->url) : '#' }}">
                                                {{ $submenu->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <li>
                                <a href="{{ ($menu->url != '#') ? url('/'.$menu->url) : '#' }}">
                                    {{ $menu->name }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>

</header>

<main>
    <div class="container">
        @yield('content')
        <hr>
    </div>
</main>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <p>Copyright © MuffeenCMS 2017</p>
            </div>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
@yield('scripts')

</body>
</html>
