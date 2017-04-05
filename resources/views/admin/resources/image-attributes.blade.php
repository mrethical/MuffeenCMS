
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.min.css" />
@append

<?php (!isset($image)) { $image = ['x' => '', 'y' => '', 'width' => '', 'height' => '']}?>

<input type="hidden" name="image-x" id="image-x" value="{{ old('image-x', $image['x']) }}">
<input type="hidden" name="image-y" id="image-y" value="{{ old('image-y', $image['y']) }}">
<input type="hidden" name="image-width" id="image-width" value="{{ old('image-width', $image['width']) }}">
<input type="hidden" name="image-height" id="image-height" value="{{ old('image-height', $image['height']) }}">

<div class="modal fade" id="modal-image-attributes" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="box modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Resize Image</h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="modal-image-attributes-submit">Save</button>
            </div>
            <div class="overlay">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.min.js"></script>
@append

