@extends('_layouts.admin')

@section('styles')

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

@stop

@section('sidebar')

    @include('_layouts.admin-sidebar', ['active' => 'Dashboard'])

@stop

@section('content')

    <section class="content-header">
        <h1>Dashboard</h1>
        <ol class="breadcrumb">
            <li class="active">
                <a href="#">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
        </ol>
    </section>

    <section class="content">

        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="ion ion-pin"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Posts</span>
                        <span class="info-box-number">{{ $posts_count }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="ion ion-ios-browsers-outline"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Pages</span>
                        <span class="info-box-number">{{ $pages_count }}</span>
                    </div>
                </div>
            </div>
            <div class="clearfix visible-sm-block"></div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="ion ion-ios-email-outline"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Inquiries</span>
                        <span class="info-box-number">{{ $inquiries_count }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="ion ion-ios-people-outline"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Active Users</span>
                        <span class="info-box-number">{{ $users_count }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Recently Added Posts</h3>
                    </div>
                    <div class="box-body">
                        <ul class="products-list product-list-in-box">
                            @foreach($posts as $post)
                                <li class="item">
                                    @if($post->resource)
                                        <div class="product-img">
                                            <img src="{{ url($uploads_small_url . '/' . $post->resource->name) }}" alt="Post Image">
                                        </div>
                                    @endif
                                    <div class="product-info">
                                        <a href="javascript:void(0)" class="product-title">
                                            {{ $post->title }}
                                        </a>
                                        <span class="product-description">
                                            <span><i class="fa fa-calendar"></i>
                                                {{ date('F d, Y', strtotime($post->created_at))}}
                                            </span>
                                            <span><i class="fa fa-user"></i> {{ $post->user ->name }}</span>
                                        </span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="box-footer text-center">
                        <a href="{{ url('/admin/posts') }}" class="uppercase">View All Posts</a>
                    </div>
                </div>
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Recently Added Pages</h3>
                    </div>
                    <div class="box-body">
                        <ul class="products-list product-list-in-box">
                            @foreach($pages as $page)
                                <li class="item">
                                    <div class="col-md-12">
                                        <a href="javascript:void(0)" class="product-title">
                                            {{ $page->title }}
                                        </a>
                                        <span class="product-description">
                                            <span><i class="fa fa-calendar"></i>
                                                {{ date('F d, Y', strtotime($post->created_at))}}
                                            </span>
                                        </span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="box-footer text-center">
                        <a href="{{ url('/admin/pages') }}" class="uppercase">View All Pages</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h3 class="box-title">Latest Members</h3>
                    </div>
                    <div class="box-body no-padding">
                        <ul class="users-list clearfix">
                            @foreach($users as $user)
                            <li>
                                <img src="{{ ($user->picture)
                                        ? url($uploads_users_url . '/' . $user->picture) : url('/img/user.png') }}"
                                     alt="User Image">
                                <a class="users-list-name" href="javascript:void(0)">
                                    {{ $user->first_name . ' ' . $user->last_name }}
                                </a>
                                <span class="users-list-date">
                                    <?php
                                        $date = date('d M', strtotime($user->created_at));
                                        $date_now = date('d M');
                                        echo ($date === $date_now) ? 'Today' : $date;
                                    ?>
                                </span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="box-footer text-center">
                        <a href="{{ url('/admin/users') }}" class="uppercase">View All Users</a>
                    </div>
                </div>
            </div>
        </div>

    </section>

@stop