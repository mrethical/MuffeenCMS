
<form class="box" method="post" action="{{ $action }}">
    <div class="box-body" id="post  -container">
        {{ (isset($method)) ? method_field($method) : '' }}
        {{ csrf_field() }}
        <div class="row">
            <div class="form-group col-md-6">
                <label class="control-label" for="title">Title:</label>
                <input class="form-control" type="text" name="title" id="title"
                       value="{{ old('title', $post->title) }}" required autofocus>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label class="control-label" for="category">Category:</label>
                <select class="form-control" id="category" name="category" >
                    <option value="">Uncategorized</option>
                    @foreach( $categories as $category )
                        <option value="{{ $category->id }}"
                                {{ (old('category', $post->$category_id) === $category->id) ? 'selected' : '' }}
                        >{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-6">
                <label class="control-label" for="image">Image:</label>
                <div class="input-group">
                    <input class="form-control image-name-target" type="text" id="image-name" readonly
                    @if(isset($resources))
                        @foreach($resources as $resource)
                            @if(((old('image')) ? intval(old('image')) : intval($post->resource_id)) === $resource->id)
                                {{ "value=\"" . $locations['upload'] . "/" . $resource->name . "\"" }}
                                    @endif
                                @endforeach
                            @endif
                    >
                    <input type="hidden" id="image" name="image" class="image-target"
                           value="{{ (old('image')) ? intval(old('image')) : $post->resource_id }}">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button" data-toggle="modal" data-target="#modal-image"
                                data-input="#image" data-input-name="#image-name">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-md-12">
                <label class="control-label" for="content">Content:</label>
                <textarea class="tinymce form-control" id="content" name="content" readonly>
                    {{ (old('content')) ? old('content') : $post->content }}
                </textarea>
            </div>
            <div class="form-group col-md-12">
                <label class="control-label" for="tags[]">Tags:</label>
                <div id="tags-container">
                    <div id="input-tags-container">
                        @if(old('tags'))
                            @foreach(old('tags') as $index=>$tag)
                                <input type="hidden" class="tag" name="tags[]" id="tag-{{ $index }}" value="{{ $tag }}" />
                            @endforeach
                        @else
                            @if(isset($tags))
                                @foreach($tags as $index=>$tag)
                                    <input type="hidden" class="tag" name="tags[]" id="tag-{{ $index }}" value="{{ $tag->name }}" />
                                @endforeach
                            @endif
                        @endif
                    </div>
                    <div id="div-tags-container"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <input type="submit" class="btn btn-flat btn-primary" value="Submit">
    </div>

</form>

@include('admin.resources.select-image')

@section('styles')
    <link rel="stylesheet" href="{{ mix('/css/admin/tinymce-custom.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/admin/posts/form-tags.css') }}">
@append

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.6/tinymce.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.jquery.min.js"></script>
    <script src="{{ mix('/js/admin/init-tinymce.js') }}"></script>
    <script src="{{ mix('/js/admin/posts/form-tags.js') }}"></script>
@append