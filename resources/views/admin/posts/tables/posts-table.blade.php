<div class="col-lg-12">
    <div class="table-responsive">
        <table class="table table-bordered table-responsive">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td>{{ ($post->category_id) ? $categories[$post->category_id] : '' }}</td>
                    <td>{{ timestamp_ago($post->created_at) }}</td>
                    <td>
                        <a href="" class="btn btn-default btn-xs">View</a>
                        <a href="{{ url('/admin/posts/' . $post->id . '/edit') }}" class="btn btn-default btn-xs">Edit</a>
                        <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal-post-delete" data-action="Delete" data-id="{{ $post->id }}">Delete</button>
                    </td>
                </tr>
                @endforeach
                @if (count($posts) === 0)
                <tr>
                    <td colspan="4" style="height: 200px; text-align:center; vertical-align:middle;">
                        No records to show. <a href="{{ url('/admin/posts/create') }}">Add New</a>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
        <input type="hidden" id="total-record" value="{{ $count }}" />
    </div>
</div>