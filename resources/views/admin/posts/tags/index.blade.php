@extends('admin')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <h1>Posts Tags</h1>
                <button class="btn btn-default pull-right" data-toggle="modal" data-target="#modal-tag" data-action="Add New">Add New</button>
            </div>
        </div>
        <div class="col-lg-12">
            <div id="table-container">
                @include('admin.posts.tags.tables.posts-tags-table', ['tags'])
            </div>
        </div>
        <div class="col-lg-12">
            <div class="pagination pull-right"></div>
        </div>
    </div>
    <div class="modal fade" id="modal-tag" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modal-tag-label"></h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div id="modal-tag-form-name" class="form-group">
                            <input type="hidden" id="tag-post-token" value="{{ csrf_token() }}" />
                            <label for="tag-name" class="control-label">Name:</label>
                            <input type="hidden" class="form-control" id="tag-id" />
                            <input type="text" class="form-control" id="tag-name" />
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="modal-tag-submit">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-tag-delete" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modal-delete-tag-label">Are you sure?</h4>
                </div>
                <div class="modal-body">
                    <p>You are about to delete a tag. 'Cancel' to stop, 'OK' to delete.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="modal-tag-delete-submit">OK</button>
                </div>
            </div>
        </div>
    </div>

@stop

@section('styles')

    <link rel="stylesheet" href="{{ elixir('vendor/simple-pagination/simplePagination.css') }}">
    <link rel="stylesheet" href="{{ elixir('css/simplePagination-flat.css') }}">

@stop

@section('scripts')

    <script src="{{ elixir('js/jquery-ajax.js') }}"></script>
    <script src="{{ elixir('vendor/simple-pagination/jquery.simplePagination.js') }}"></script>
    <script src="{{ elixir('js/admin/posts-tags.js') }}"></script>

@stop