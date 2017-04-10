@extends('_layouts.public', ['title', 'body_title' => 'Recent Blogs'])

@section('header')

    <section class="header-intro">
        <div class="dark-mask"></div>
        <div class="header-image">
            <div class="headline">
                <div>
                    <div class="container">
                        <h1 class="title">A CMS based on Laravel Framework</h1>
                        <h2 class="subtitle">A Perfect starting template for any kind of project</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

@stop

@section('content')

    <hr>

    <section class="row">
        <div class="col-md-6">
            <h1 class="text-center">Welcome to MuffeenCMS</h1>
        </div>
        <div class="col-md-6">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deserunt doloribus ipsam molestiae molestias neque perferendis quos ratione sunt, ut. Aliquid asperiores assumenda at consequuntur cum fuga, nostrum porro reiciendis similique!</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci, animi deserunt dolore dolorum eius expedita impedit iusto labore minima molestiae neque officia placeat, possimus quam quod, sequi temporibus vel veniam.</p>
        </div>
    </section>

    <hr>

    <section class="row">
        <div class="col-md-12">
            <h1>Recent Blogs</h1>
        </div>
        <div class="col-md-9">
            <section id="posts">
                <h2 class="hidden">List</h2>
                <hr>
                <ul>
                    @foreach($posts as $post)
                        <li>
                            @if($post->resource)
                                <div class="col-sm-5">
                                    <div class="blog-image-container">
                                        <img src="{{ url('/uploads/images-medium/' . $post->resource->name) }}">
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    @else
                                        <div class="blog-image-none col-md-12">
                                            @endif
                                            <a href="{{ url('/posts/' . $post->slug) }}">{{ $post->title }}</a>
                                            <p class="blog-date">~ {{ date('F d, Y', strtotime($post->created_at)) }}</p>
                                            <p class="blog-content">{{ substr(preg_replace("/&#?[a-z0-9]{2,8};/i", "", strip_tags($post->content)), 0, 500) }} ... </p>
                                            <hr class="blog-divider">
                                            <div class="col-xs-6">
                                                <p class="blog-info-header">Posted By: </p>
                                                <p>{{ $post->user->name }}</p>
                                            </div>
                                            <div class="col-xs-6">
                                                <p class="blog-info-header">Posted Under: </p>
                                                <p>{{ ($post->category) ? $post->category->name : 'Uncategorized' }}</p>
                                            </div>
                                        </div>
                        </li>
                    @endforeach
                </ul>
            </section>
        </div>
        <div class="col-md-3">
            @include('posts.aside')
        </div>
    </section>

@stop

@section('styles')
    <link rel="stylesheet" href="{{ mix("/css/home.css") }}">
    <link rel="stylesheet" href="{{ mix("/css/posts/list.css") }}">
@append

@section('scripts')
    <script src="{{ mix("/js/posts/list.js") }}"></script>
    <script>
        $(window).scroll(function () {
            if ($(window).scrollTop() >= 500) {
                $('.navbar').css('background-color', '#e95420');
                $('.navbar').css('border-color', '#d34615');
            } else {
                $('.navbar').css('background-color', 'transparent');
                $('.navbar').css('border-color', 'none');
            };
        });
    </script>
@append