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
            @foreach($categories as $category)
                <tr>
                    <td>{{ $category->name  }}</td>
                    <td>
                        <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal-category" data-action="Edit" data-id="{{ $category->id  }}" data-name="{{ $category->name  }}" data-parent-id="{{ $category->parent_id }}">Edit</button>
                        <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal-category-delete" data-action="Delete" data-id="{{ $category->id  }}">Delete</button>
                    </td>
                </tr>
            @endforeach
            @if (count($categories) === 0)
                <tr>
                    <td colspan="2" style="height: 200px; text-align:center; vertical-align:middle;">
                        No records to show. <a data-toggle="modal" data-target="#modal-category" data-action="Add New">Add New</a>
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
        <input type="hidden" id="total-record" value="{{ $count }}" />
    </div>
</div>