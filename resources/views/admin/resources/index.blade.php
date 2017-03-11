@extends('admin')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <h1>Resources</h1>
                <a href="{{ url('/admin/resources/create') }}" class="btn btn-default pull-right">Add New</a>
            </div>
        </div>
        <div class="col-lg-12">
            <div id="table-container">
                @include('admin.resources.tables.resources-table')
            </div>
        </div>
        <div class="col-lg-12">
            <div class="pagination pull-right"></div>
        </div>
    </div>
    <div class="modal fade" id="modal-resource" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modal-resource-label">Edit Image</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <img src="" class="img-responsive res-info-src"/>
                        </div>
                        <div class="col-md-6 col-lg-8">
                            <p class="res-info-name">Name: <span></span></p>
                            <p class="res-info-type">File Type: <span></span></p>
                            <p class="res-info-size">Size: <span></span></p>
                        </div>
                    </div>
                    <form class="margin-top-one">
                        <div id="modal-resource-form-title" class="form-group">
                            <input type="hidden" id="res-resource-token" value="{{ csrf_token() }}" />
                            <label for="res-title" class="control-label">Title:</label>
                            <input type="hidden" class="form-control" id="res-id" />
                            <input type="text" class="form-control" id="res-title" />
                        </div>
                        <div class="form-group">
                            <label for="res-category" class="control-label">Category:</label>
                            <select class="form-control" id="res-category">
                                <option value="0">Uncategorized</option>
                                @foreach($categories as $index=>$category)
                                    <option value="{{ $index }}">{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="res-alt" class="control-label">Alt: *</label>
                            <input type="text" class="form-control" id="res-alt" />
                            <p class="help-block">*Alt text for the image, e.g. “The Mountain Peak”</p>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="modal-resource-submit">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-resource-delete" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modal-delete-resource-label">Are you sure?</h4>
                </div>
                <div class="modal-body">
                    <p>You are about to delete a resource. 'Cancel' to stop, 'OK' to delete.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="modal-resource-delete-submit">OK</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-resource-preview" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <img class="img-responsive" style="width: 100%;">
                </div>
            </div>
        </div>
    </div>

@stop

@section('styles')

    <link rel="stylesheet" href="{{ elixir('vendor/simple-pagination/simplePagination.css') }}">
    <link rel="stylesheet" href="{{ elixir('css/simplePagination-flat.css') }}">
    <link rel="stylesheet" href="{{ elixir('css/admin/resources.css') }}">

@stop

@section('scripts')


    <script src="{{ elixir('js/jquery-ajax.js') }}"></script>
    <script src="{{ elixir('vendor/simple-pagination/jquery.simplePagination.js') }}"></script>
    <script src="{{ elixir('js/admin/resources.js') }}"></script>

@stop