
<form class="box" method="post" action="{{ $action }}">
    <div class="box-body">
        {{ (isset($method)) ? method_field($method) : '' }}
        {{ csrf_field() }}
        <div class="row">
            <div class="form-group col-md-6">
                <label class="control-label" for="title">Title:</label>
                <input class="form-control" type="text" name="title" id="title"
                       value="{{ old('title', $page->title) }}" required autofocus>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <label class="control-label" for="content">Content:</label>
                <textarea class="tinymce form-control" id="content" name="content" readonly>
                    {{ (old('content')) ? old('content') : $page->content }}
                </textarea>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label class="control-label" for="slug">Slug URL: </label> <span>({{ url('/pages')  }}/)</span>
                <input class="form-control slug" type="text" name="slug" id="slug" data-related="#title"
                       value="{{ old('slug', $page->slug) }}" required>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <input type="submit" class="btn btn-flat btn-primary" value="Submit">
    </div>

    @include('admin.resources.select-image')

</form>

@section('styles')
    <link rel="stylesheet" href="{{ url('/vendor/jquery-toast-plugin/jquery.toast.min.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/admin/tinymce-custom.css') }}">
@append

@section('scripts')
    <script src="{{ url('/vendor/jquery-toast-plugin/jquery.toast.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/tinymce.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.jquery.min.js"></script>
    <script src="{{ mix('/js/admin/init-tinymce.js') }}"></script>
    <script src="{{ mix('/js/admin/pages/form.js') }}"></script>
@append