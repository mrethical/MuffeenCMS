@extends('admin')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <h1>Menus</h1>
                <button class="btn btn-default pull-right" data-toggle="modal" data-target="#modal-menu" data-action="Add New">Add New</button>
            </div>
        </div>
        <div class="col-lg-12">
            <div id="table-container">
                @include('admin.menus.tables.menus-table', ['menus'])
            </div>
        </div>
        <div class="col-lg-12">
            <div class="pagination pull-right"></div>
        </div>
    </div>
    <div class="modal fade" id="modal-menu" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modal-menu-label"></h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div id="modal-menu-form-name" class="form-group">
                            <input type="hidden" id="menu-post-token" value="{{ csrf_token() }}" />
                            <label for="menu-name" class="control-label">Name:</label>
                            <input type="hidden" class="form-control" id="menu-id" />
                            <input type="text" class="form-control" id="menu-name" />
                        </div>
                        <div id="modal-menu-form-post" class="form-group">
                            <label for="menu-post" class="control-label">Post:</label>
                            <select class="form-control" id="menu-post"></select>
                        </div>
                        <div id="modal-menu-form-menu" class="form-group">
                            <label for="menu-parent" class="control-label">Parent:</label>
                            <select class="form-control" id="menu-parent"></select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="modal-menu-submit">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-menu-delete" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modal-delete-menu-label">Are you sure?</h4>
                </div>
                <div class="modal-body">
                    <p>You are about to delete a menu. 'Cancel' to stop, 'OK' to delete.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="modal-menu-delete-submit">OK</button>
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
    <script src="{{ elixir('js/admin/menus.js') }}"></script>

@stop