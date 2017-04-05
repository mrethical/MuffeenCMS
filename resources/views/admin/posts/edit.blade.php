@extends('_layouts.admin')

@section('sidebar')

    @include('_layouts.admin-sidebar', ['active' => 'Posts-All Posts'])

@stop

@section('content')

    <section class="content-header">
        <h1>
            Edit Post
            <small>Posts</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <a href="{{ url('/admin/posts') }}">
                    <i class="fa fa-thumb-tack"></i> Posts
                </a>
            </li>
            <li class="active">
                <a href="#">Edit</a>
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

        @if($edited = request()->session()->get('edited', null))
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <p>Post was updated successfully. <a href="{{ url('/admin/posts') }}">Back to List</a></p>
            </div>
        @endif

        <div class="row">

            <div class="col-xs-12">
                @include('admin.posts.form', [
                    'action' => url('/admin/posts/'.$post->id),
                    'method' => 'PATCH'
                 ])
            </div>
        </div>

    </section>

@stop