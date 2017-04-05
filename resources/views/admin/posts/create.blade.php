@extends('_layouts.admin')

@section('sidebar')

    @include('_layouts.admin-sidebar', ['active' => 'Posts-Add New'])

@stop

@section('content')

    <section class="content-header">
        <h1>
            Add New Post
            <small>Posts</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <a href="{{ url('/admin/posts') }}">
                    <i class="fa fa-thumb-tack"></i> Posts
                </a>
            </li>
            <li class="active">
                <a href="#">Add New</a>
            </li>
        </ol>
    </section>

    <section class="content">

        @if (count($errors) > 0)
            <div class="alert alert-danger alert-dismissable">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-xs-12">
                @include('admin.posts.form', ['action' => url('/admin/posts/')])
            </div>
        </div>

    </section>

@stop