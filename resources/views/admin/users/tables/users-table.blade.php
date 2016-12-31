<div class="col-lg-12">
    <div class="table-responsive">
        <table class="table table-bordered table-responsive">
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>User Type</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->type }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @can('update', $user)
                            <a class="btn btn-default btn-xs" href="{{ url('/admin/users/' . $user->id) . '/edit' }}">Edit</a>
                        @endcan
                        @can('delete', $user)
                            <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal-user-delete" data-action="Delete" data-id="{{ $user->id  }}">Delete</button>
                        @endcan
                    </td>
                </tr>
            @endforeach
            @if (count($users) === 0)
                <tr>
                    <td colspan="4" style="height: 200px; text-align:center; vertical-align:middle;">
                        No records to show. <a href="{{ url('/admin/users/create') }}">Add New</a>
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
        <input type="hidden" id="total-record" value="{{ $count }}" />
    </div>
</div>