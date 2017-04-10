@extends('_layouts.public', ['title' => '500 Internal Server Error', 'body_title' => '404 Internal Server Error'])

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
            <h2 class="headline text-red">500</h2>
            <div class="error-content">
                <h3><i class="fa fa-warning text-red"></i> Oops! Something went wrong.</h3>
                <p>
                    We will work on fixing that right away.
                </p>
            </div>
        </div>
    </section>

@stop