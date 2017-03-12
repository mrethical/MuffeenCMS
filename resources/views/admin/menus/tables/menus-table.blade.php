<div class="col-lg-12">
    <div class="table-responsive">
        <table class="table table-bordered table-responsive">
            <thead>
            <tr>
                <th>Name</th>
                <th>Post</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($menus as $menu)
                <tr>
                    <td>{{ $menu->name  }}</td>
                    <td>{{ ($post = $menu->post) ? $post->title : '' }}</td>
                    <td>
                        <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal-menu" data-action="Edit" data-id="{{ $menu->id }}" data-name="{{ $menu->name }}" data-post-id="{{ $menu->post_id }}" data-parent-id="{{ $menu->parent_id }}">Edit</button>
                        <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal-menu-delete" data-action="Delete" data-id="{{ $menu->id }}">Delete</button>
                    </td>
                </tr>
            @endforeach
            @if (count($menus) === 0)
                <tr>
                    <td colspan="3" style="height: 200px; text-align:center; vertical-align:middle;">
                        No records to show. <a data-toggle="modal" data-target="#modal-menu" data-action="Add New">Add New</a>
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
        <input type="hidden" id="total-record" value="{{ $count }}" />
    </div>
</div>