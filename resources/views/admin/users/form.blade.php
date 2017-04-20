<?php
    if (!isset($password_required)) {
        $password_required = true;
    }
?>

<form class="box" method="post" action="{{ $action }}" enctype="multipart/form-data">
    <div class="row box-body">
        {{ (isset($method)) ? method_field($method) : '' }}
        {{ csrf_field() }}
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label" for="name">User Name:</label>
                <input class="form-control" type="text" name="name" id="name"
                       value="{{ old('name', $user->name) }}" required autofocus>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input class="form-control" type="email" name="email" id="email"
                       value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input class="form-control" type="password" name="password" id="password"
                       {{ ($password_required) ? 'required' : '' }}>
                <?= (!$password_required) ? '<p class="help-block">* Leave this blank if you don\'t want to change password.</p>' : '' ?>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password:</label>
                <input class="form-control" type="password" name="password_confirmation" id="password_confirmation"
                        {{ ($password_required) ? 'required' : '' }}>
            </div>
            <div class="form-group">
                <label for="type">Type:</label>
                <select class="form-control" name="type" id="type">
                    @if(auth()->user()->type === 'superadmin')
                        <option {{ (old('type', $user->type) === 'superadmin') ? 'selected ' : '' }}
                                value="superadmin">superadmin</option>
                    @endif
                    <option {{ (old('type', $user->type) === 'admin') ? 'selected ' : '' }}
                            value="admin">admin</option>
                    <option {{ (old('type', $user->type) === 'member') ? 'selected ' : '' }}
                            value="member">member</option>
                </select>
            </div>
        </div>
        <div class="row col-md-6">
            <div class="col-xs-12">
                <div class="form-group">
                    <label class="control-label" for="first_name">First Name:</label>
                    <input class="form-control" type="text" name="first_name" id="first_name"
                           value="{{ old('first_name', $user->first_name) }}" required>
                </div>
                <div class="form-group">
                    <label class="control-label" for="middle_name">Middle Name:</label>
                    <input class="form-control" type="text" name="middle_name" id="middle_name"
                           value="{{ old('middle_name', $user->middle_name) }}" >
                </div>
                <div class="form-group">
                    <label class="control-label" for="last_name">Last Name:</label>
                    <input class="form-control" type="text" name="last_name" id="last_name"
                           value="{{ old('last_name', $user->last_name) }}" required>
                </div>
            </div>
            <div class="col-xs-12">
                <label class="control-label" for="picture">Profile Picture:</label>
            </div>
            <div class="col-xs-4">
                <img src="{{ ($user->picture) ? url($uploads_users_url . '/' . $user->picture) : url('/img/user.png') }}"
                     class="img img-responsive">
            </div>
            <div class="col-xs-8">
                <div class="form-group">
                    <label class="control-label" for="picture">Change Picture:</label>
                    <input type="file" name="picture" accept="image/*">
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <input type="submit" class="btn btn-flat btn-primary" value="Submit">
    </div>
</form>