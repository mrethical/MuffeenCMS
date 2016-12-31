@extends('admin')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <h1>Edit Post</h1>
                <a href="{{ url('/admin/posts') }}" class="btn btn-default pull-right">Back to List</a>
            </div>
        </div>
    </div>
    @if($edited)
    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-success alert-dismissable" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <p>Post was updated successfully. <a href="{{ url('/admin/posts') }}">Back to List</a></p>
            </div>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <form class="form-horizontal" method="post" action="{{ url('admin/posts/' . $post->id) }}">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                    <div class="col-sm-2 col-md-2 col-lg-1">
                        <label class="control-label" for="post-title">Title:</label>
                    </div>
                    <div class="col-sm-10 col-md-4 col-lg-5">
                        <input class="form-control" type="text" id="post-title" name="title" value="{{ (old('title')) ? old('title') : $post->title }}" />
                        @if($errors->has('title'))<p class="help-block">{{ $errors->first('title') }}</p>@endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('category') ? 'has-error' : '' }}">
                    <div class="col-sm-2 col-md-2 col-lg-1">
                        <label class="control-label" for="post-category">Category:</label>
                    </div>
                    <div class="col-sm-10 col-md-4 col-lg-5">
                        <select class="form-control" id="post-category" name="category" >
                            <option value>Uncategorized</option>
                            @foreach( $categories as $category )
                                <option value="{{ $category->id }}" {{ (((old('category')) ? old('category') : $post->category_id) === $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('category'))<p class="help-block">{{ $errors->first('category') }}</p>@endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                    <div class="col-sm-2 col-md-2 col-lg-1">
                        <label class="control-label" for="post-image">Image:</label>
                    </div>
                    <div class="col-sm-10 col-md-4 col-lg-5">
                        <div class="input-group">
                            <input class="form-control" type="text" id="post-image-name" readonly <?php
                                foreach($resources as $resource) {
                                    if(((old('image')) ? intval(old('image')) : intval($post->resource_id)) === $resource->id) {
                                        echo "value=\"" . $locations['upload'] . "/" . $resource->name . "\"";
                                    }
                                }
                                ?> >
                            <input type="hidden" id="post-image" name="image" value="{{ (old('image')) ? intval(old('image')) : $post->resource_id }}">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" id="add-image"><i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        @if($errors->has('image'))<p class="help-block">{{ $errors->first('image') }}</p>@endif
                    </div>
                </div>
                <div class="form-group {{ $errors->has('content') ? 'has-error' : '' }}">
                    <div class="col-sm-2 col-lg-1">
                        <label class="control-label" for="post-content">Content:</label>
                    </div>
                    <div class="col-sm-10 col-lg-11">
                        <textarea readonly class="form-control tinymce" id="post-content" name="content">{{ (old('content')) ? old('content') : $post->content }}</textarea>
                        @if($errors->has('content'))<p class="help-block">{{ $errors->first('content') }}</p>@endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2 col-lg-1">
                        <label class="control-label" for="post-tags[]">Tags:</label>
                    </div>
                    <div class="col-sm-10 col-lg-11">
                        <div id="tags-container">
                            <div id="input-tags-container">
                                @if(old('tags'))
                                    @foreach(old('tags') as $index=>$tag)
                                    <input type="hidden" class="post-tag" name="tags[]" id="post-tag-{{ $index }}" value="{{ $tag }}" />
                                    @endforeach
                                @else
                                    @foreach($tags as $index=>$tag)
                                        <input type="hidden" class="post-tag" name="tags[]" id="post-tag-{{ $index }}" value="{{ $tag->name }}" />
                                    @endforeach
                                @endif
                            </div>
                            <div id="div-tags-container"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-12 ">
                        <input class="btn btn-default pull-right" type="submit" value="Submit" />
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal fade" id="modal-image-add" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Image</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label for="categories-filter" class="col-sm-2 control-label">Filter:</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="categories-filter">
                                    <option value="-1">All</option>
                                    <option value="0">Uncategorized</option>
                                    @foreach($resources_categories as $id=>$name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="res-image" class="col-sm-2 control-label">Image:</label>
                            <div class="col-sm-10">
                                <div class="pre-scrollable">
                                    <select multiple="multiple" class="image-picker" id="res-image">
                                        @include('admin.resources.selects.list')
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="modal-image-submit">Choose</button>
                </div>
            </div>
        </div>
    </div>

@stop

@section('styles')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/image-picker/0.3.0/image-picker.min.css" integrity="sha256-9gsBfIc7vU7vWNMFSpwqOAdc7Q2E/k7NOS9V1G/cD8E=" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ elixir('css/admin/post-create.css') }}">

@stop

@section('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeahead.js/0.11.1/typeahead.jquery.min.js" integrity="sha256-nORlj0J8ZjvGz+6rtHb2Jcc0QDASsDUNOwUkfcwoW8A=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/image-picker/0.3.0/image-picker.min.js" integrity="sha256-raAg+MqNg4ng8kTy8iZn+74zZOL9hEJag0fLMCX31DE=" crossorigin="anonymous"></script>
    <script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
    <script src="{{ elixir('js/jquery-ajax.js') }}"></script>
    <script src="{{ elixir('js/init-tinymce.js') }}"></script>
    <script src="{{ elixir('js/admin/post-create.js') }}"></script>

@stop