@extends('admin')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <h1>Posts</h1>
                <a href="{{ url('/admin/posts/create') }}" class="btn btn-default pull-right">Add New</a>
            </div>
        </div>
        @if ($added)
            <div class="col-lg-12">
                <div class="alert alert-success alert-dismissable" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <p>New post added. <a href="{{ url('admin/posts/'. $added . '/edit') }}">Edit</a></p>
                </div>
            </div>
        @endif
        <div id="table-container">
            @include('admin.posts.tables.posts-table')
        </div>
    </div>
    <div class="modal fade" id="modal-post-delete" tabindex="-1" role="dialog">
        <input type="hidden" id="post-token" value="{{ csrf_token() }}" />
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modal-delete-post-label">Are you sure?</h4>
                </div>
                <div class="modal-body">
                    <p>You are about to delete a post. 'Cancel' to stop, 'OK' to delete.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="modal-post-delete-submit">OK</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="pagination pull-right"></div>
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
    <script src="{{ elixir('js/admin/posts.js') }}"></script>

@stop