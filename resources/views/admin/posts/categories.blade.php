@extends('_layouts.admin')

@section('styles')

    <link rel="stylesheet" href="{{ url('/vendor/jquery-toast-plugin/jquery.toast.min.css') }}">

@stop

@section('sidebar')

    @include('_layouts.admin-sidebar', ['active' => 'Posts-Categories'])

@stop

@section('content')

    <section class="content-header">
        <h1>
            Categories
            <small>Posts</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <a href="{{ url('/admin/posts') }}">
                    <i class="fa fa-thumb-tack"></i> Posts
                </a>
            </li>
            <li class="active">
                <a href="#">Categories</a>
            </li>
        </ol>
    </section>

    <section id="content-body" class="content">

        <div class="row">

            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Parent</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody id="table-body">
                            <tr class="empty-table-row">
                                <td colspan="3">
                                    No records to show.
                                    <a data-toggle="modal" data-target="#modal-category" data-action="Add New">Add New</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer">
                        <label>Actions:</label>
                        <br>
                        <a data-toggle="modal" data-target="#modal-category" data-action="Add New"
                           class="btn btn-flat btn-primary">Add New</a>
                        <div id="pagination" class="pull-right"></div>
                    </div>
                    <div class="overlay">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                </div>
            </div>

        </div>

    </section>

    <input type="hidden" id="_token" value="{{ csrf_token() }}">

    <div class="modal fade" id="modal-category" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="modal-category-label"></h4>
                </div>
                <div id="modal-category-body" class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" required>
                        </div>
                        <div class="form-group">
                            <label for="parent">Parent:</label>
                            <select class="form-control" id="parent" name="parent"></select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="modal-category-submit">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-delete" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modal-delete-label">Are you sure?</h4>
                </div>
                <div class="modal-body">
                    <p>You are about to delete a user. 'Cancel' to stop, 'OK' to delete.</p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="user-id">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="modal-delete-submit">OK</button>
                </div>
            </div>
        </div>
    </div>

@stop

@section('scripts')

    <script src="{{ url('/vendor/jquery-toast-plugin/jquery.toast.min.js') }}"></script>
    <script src="{{ mix('vendor/jquery-simplePagination/jquery-simplePagination.js') }}"></script>
    <script src="{{ mix('js/admin/posts/categories.js') }}"></script>

@stop