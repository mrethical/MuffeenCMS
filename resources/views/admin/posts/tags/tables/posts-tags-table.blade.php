<div class="col-lg-12">
    <div class="table-responsive">
        <table class="table table-bordered table-responsive">
            <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tags as $tag)
                <tr>
                    <td>{{ $tag->name }}</td>
                    <td>
                        <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal-tag" data-action="Edit" data-id="{{ $tag->id  }}" data-name="{{ $tag->name }}">Edit</button>
                        <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal-tag-delete" data-action="Delete" data-id="{{ $tag->id  }}">Delete</button>
                    </td>
                </tr>
            @endforeach
            @if (count($tags) === 0)
                <tr>
                    <td colspan="2" style="height: 200px; text-align:center; vertical-align:middle;">
                        No records to show. <a data-toggle="modal" data-target="#modal-tag" data-action="Add New">Add New</a>
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
        <input type="hidden" id="total-record" value="{{ $count }}" />
    </div>
</div>