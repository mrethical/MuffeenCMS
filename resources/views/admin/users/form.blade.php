<form class="box" method="post" action="{{ $action }}">
    <div class="row box-body">
        {{ (isset($method)) ? method_field($method) : '' }}
        {{ csrf_field() }}
        <div class="form-group col-md-6">
            <label class="control-label" for="name">User Name:</label>
            <input class="form-control" type="text" name="name" id="name"
                   value="{{ old('name', $user->name) }}" required autofocus>
        </div>
        <div class="form-group col-md-6">
            <label for="password">Password:</label>
            <input class="form-control" type="password" name="password" id="password"
                   required>
        </div>
        <div class="form-group col-md-6">
            <label for="email">Email:</label>
            <input class="form-control" type="email" name="email" id="email"
                   value="{{ old('email', $user->email) }}" required>
        </div>
        <div class="form-group col-md-6">
            <label for="password_confirmation">Confirm Password:</label>
            <input class="form-control" type="password" name="password_confirmation" id="password_confirmation"
                   required>
        </div>
        <div class="form-group col-md-6">
            <label for="type">Type:</label>
            <select class="form-control" name="type" id="type">
                <option {{ (old('type', $user->type) === 'admin') ? 'selected ' : '' }}
                        value="admin">admin</option>
                <option {{ (old('type', $user->type) === 'member') ? 'selected ' : '' }}
                        value="member">member</option>
            </select>
        </div>
    </div>
    <div class="box-footer">
        <input type="submit" class="btn btn-flat btn-primary" value="Submit">
    </div>
</form>