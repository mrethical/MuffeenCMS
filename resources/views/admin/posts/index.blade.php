@extends('_layouts.admin')

@section('styles')

    <link rel="stylesheet" href="{{ url('/vendor/jquery-toast-plugin/jquery.toast.min.css') }}">

@stop

@section('sidebar')

    @include('_layouts.admin-sidebar', ['active' => 'Posts-All Posts'])

@stop

@section('content')

    <section class="content-header">
        <h1>
            All Posts
            <small>Posts</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <a href="#">
                    <i class="fa fa-thumb-tack"></i> Posts
                </a>
            </li>
            <li class="active">
                <a href="#">All Posts</a>
            </li>
        </ol>
    </section>

    <section id="content-body" class="content">

        @if ($added = request()->session()->get('added', null))
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <p>New post added. <a href="{{ url('admin/posts/'. $added . '/edit') }}">Edit Post</a></p>
            </div>
        @endif

        <div class="row">

            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Category</th>
                                <th>Date Published</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody id="table-body">
                            <tr class="empty-table-row">
                                <td colspan="5">
                                    No records to show. <a href="{{ url('/admin/posts/create') }}">Add New</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer">
                        <label>Actions:</label>
                        <br>
                        <a href="{{ url('/admin/posts/create') }}" class="btn btn-flat btn-primary">Add New</a>
                        <div id="pagination" class="pull-right"></div>
                    </div>
                    <div class="overlay">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                </div>
            </div>

        </div>

    </section>

    <div class="modal fade" id="modal-delete" tabindex="-1" role="dialog">
        <input type="hidden" id="user-token" value="{{ csrf_token() }}" />
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modal-delete-label">Are you sure?</h4>
                </div>
                <div class="modal-body">
                    <p>You are about to delete a posts. 'Cancel' to stop, 'OK' to delete.</p>
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
    <script src="{{ mix('js/admin/posts/index.js') }}"></script>

@stop