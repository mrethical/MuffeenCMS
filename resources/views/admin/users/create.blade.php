@extends('_layouts.admin')

@section('sidebar')

    @include('_layouts.admin-sidebar', ['active' => 'Users-Add New'])

@stop

@section('content')

    <section class="content-header">
        <h1>
            Add New User
            <small>Users</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <a href="{{ url('/admin/users') }}">
                    <i class="fa fa-users"></i> Users
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
                @include('admin.users.form', ['action' => url('/admin/users/')])
            </div>
        </div>

    </section>

@stop