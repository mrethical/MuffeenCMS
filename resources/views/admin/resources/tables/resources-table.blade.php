<div class="col-lg-12">
    <div class="table-responsive">
        <table class="table table-bordered table-responsive">
            <thead>
            <tr>
                <th>File</th>
                <th>Category</th>
                <th>Date Added</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($resources as $resource)
                <tr>
                    <td>
                        @if(in_array(strtolower($resource->ext), array('jpg', 'jpeg', 'png', 'gif')))
                            <button class="btn btn-link" data-toggle="modal" data-target="#modal-resource-preview" data-name="{{ $resource->name }}">
                                <img class="resource-image" src="{{
                                    (in_array($resource->ext, ['jpeg', 'jpg', 'png', 'gif']))
                                    ? $locations['upload_images_small'] . '/' . $resource->name :
                                     url('/img/filetypes/' . $ext . '.png')
                                }}" />
                            </button>
                        @endif
                        <a class="resource-title" href="{{ $locations['upload'] . '/' . $resource->name  }}" target="_blank">{{ $resource->title }}</a>
                    </td>
                    <td>{{ ($resource->category_id) ? $categories[$resource->category_id] : '' }}</td>
                    <td>{{ timestamp_ago($resource->created_at) }}</td>
                    <td>
                        <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal-resource"
                                data-action="Edit"
                                data-id="{{ $resource->id  }}"
                                data-name="{{ $resource->name }}"
                                data-title="{{ $resource->title }}"
                                data-category="{{ ($resource->category_id) ? $resource->category_id : 0 }}"
                                data-alt="{{ $resource->alt }}"
                                data-size="{{ format_bytes($resource->size, 'KB') }}"
                                data-type="{{ $resource->ext }}">Edit</button>
                        <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modal-resource-delete" data-action="Delete" data-id="{{ $resource->id  }}">Delete</button>
                    </td>
                </tr>
            @endforeach
            @if (count($resources) === 0)
                <tr>
                    <td colspan="5" style="height: 200px; text-align:center; vertical-align:middle;">
                        No records to show. <a href="{{ url('/admin/resources/create') }}">Add New</a>
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
        <input type="hidden" id="total-record" value="{{ $count }}" />
    </div>
</div>