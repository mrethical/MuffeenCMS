@extends('_layouts.admin')

@section('sidebar')

    @include('_layouts.admin-sidebar', ['active' => 'Users-All Users'])

@stop

@section('content')

    <section class="content-header">
        <h1>
            Edit User
            <small>Users</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <a href="{{ url('/admin/users') }}">
                    <i class="fa fa-users"></i> Users
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
                <p>User was updated successfully. <a href="{{ url('/admin/users') }}">Back to List</a></p>
            </div>
        @endif

        <div class="row">

            <div class="col-xs-12">
                @include('admin.users.form', [
                    'action' => url('/admin/users/'.$user->id),
                    'method' => 'PATCH'
                 ])
            </div>
        </div>

    </section>

@stop