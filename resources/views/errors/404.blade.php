@extends('_layouts.public', ['title' => '404 Page Not Found', 'body_title' => '404 Page Not Found'])

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.11/css/AdminLTE.min.css">
    <style>
        body {
            height: auto;
        }
        .error-content {
            padding-top: 25px;
        }
    </style>
@append

@section('content')

    <section class="content">
        <div class="error-page">
            <h2 class="headline text-yellow"> 404</h2>
            <div class="error-content">
                <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>
                <p>
                    We could not find the page you were looking for.
                </p>
            </div>
        </div>
    </section>

@stop