@extends('admin')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <h1>Your Profile</h1>
            </div>
        </div>
        @if($edited)
            <div class="col-md-6">
                <div class="alert alert-success alert-dismissable" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <p>Profile was updated successfully.</p>
                </div>
            </div>
        @endif
        <div class="col-lg-12">
            <form class="form-horizontal" method="post" action="{{ url('/admin/users/' . $user->id) }}">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <div class="col-sm-3 col-md-2">
                        <label class="control-label" for="name">User Name:</label>
                    </div>
                    <div class="col-sm-9 col-md-4">
                        <input class="form-control" type="text" name="name" value="{{ (old('name')) ? old('name') : $user->name }}" required autofocus/>
                        @if($errors->has('name'))<p class="help-block">{{ $errors->first('name') }}</p>@endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <div class="col-sm-3 col-md-2">
                        <label class="control-label" for="password">Password:</label>
                    </div>
                    <div class="col-sm-9 col-md-4">
                        <input class="form-control" type="password" name="password" />
                        @if($errors->has('password'))
                            <p class="help-block">{{ $errors->first('password') }}</p>
                        @else
                            <p class="help-block">Leave this blank if you don't want to change your password.</p>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-3 col-md-2">
                        <label class="control-label" for="password">Confirm Password:</label>
                    </div>
                    <div class="col-sm-9 col-md-4">
                        <input class="form-control" type="password" name="password_confirmation" />
                    </div>
                </div>
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <div class="col-sm-3 col-md-2">
                        <label class="control-label" for="email">Email:</label>
                    </div>
                    <div class="col-sm-9 col-md-4">
                        <input class="form-control" type="email" name="email" value="{{ (old('email')) ? old('email') : $user->email }}" required />
                        @if($errors->has('email'))<p class="help-block">{{ $errors->first('email') }}</p>@endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-3 col-md-2">
                        <label class="control-label" for="type">Type:</label>
                    </div>
                    <div class="col-sm-9 col-md-4">
                        <input class="form-control" type="text" value="{{ $user->type }}" readonly />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6">
                        <input class="btn btn-default pull-right" type="submit" value="Submit" />
                    </div>
                </div>
            </form>
        </div>
    </div>

@stop