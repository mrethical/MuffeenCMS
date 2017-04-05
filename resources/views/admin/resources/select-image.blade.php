
<?php if (!isset($with_toast)) $with_toast = true; ?>

@section('styles')
    @if($with_toast)
        <link rel="stylesheet" href="{{ url('/vendor/jquery-toast-plugin/jquery.toast.min.css') }}">
    @endif
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/image-picker/0.3.0/image-picker.min.css" />
@stop

<button id="open-image-model" data-toggle="modal" data-target="#modal-image"></button>
<div class="modal fade" id="modal-image" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add Image</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="modal-image-category" class="control-label">Filter:</label>
                    <select class="form-control" id="modal-image-category">
                        <option value="-1">All</option>
                        <option value="0">Uncategorized</option>
                        @foreach($resource_categories as $id=>$name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="modal-image-name" class="control-label">Image:</label>
                    <div class="pre-scrollable">
                        <select class="image-picker" id="modal-image-name"></select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="modal-image-submit">Choose</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    @if($with_toast)
        <script src="{{ url('/vendor/jquery-toast-plugin/jquery.toast.min.js') }}"></script>
    @endif
    <script src="https://cdnjs.cloudflare.com/ajax/libs/image-picker/0.3.0/image-picker.min.js"></script>
    <script>
        var uploads_small_url = '{{ $uploads_small_url }}/';
        var uploads_url = '{{ $uploads_url }}/';
    </script>
    <script src="{{ mix('js/admin/resources/select-image.js') }}"></script>
@stop