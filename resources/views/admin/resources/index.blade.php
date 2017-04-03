@extends('_layouts.admin')

@section('styles')

    <link rel="stylesheet" href="{{ url('/vendor/jquery-toast-plugin/jquery.toast.min.css') }}">
    <link rel="stylesheet" href="{{ mix('css/admin/resources/index.css') }}">

@stop

@section('sidebar')

    @include('_layouts.admin-sidebar', ['active' => 'Resources-All Resources'])

@stop

@section('content')

    <section class="content-header">
        <h1>
            All Resources
            <small>Resources</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <a href="#">
                    <i class="fa fa-file"></i> Resources
                </a>
            </li>
            <li class="active">
                <a href="#">All Resources</a>
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
                                <th>File</th>
                                <th>Category</th>
                                <th>Date Added</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody id="table-body">
                            <tr class="empty-table-row">
                                <td colspan="4">
                                    No records to show. <a href="{{ url('/admin/resources/create') }}">Add New</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer">
                        <label>Actions:</label>
                        <br>
                        <a href="{{ url('/admin/resources/create') }}" class="btn btn-flat btn-primary">Add New</a>
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

    <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modal-resource-label">Edit Image</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <img src="" class="img-responsive" id="src">
                        </div>
                        <div class="col-md-6 col-lg-8">
                            <p>Name: <span id="name"></span></p>
                            <p>File Type: <span id="type"></span></p>
                            <p>Size: <span id="size"></span></p>
                        </div>
                    </div>
                    <form id="modal-edit-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="title" name="title">
                        </div>
                        <div class="form-group">
                            <label for="res-category" class="control-label">Category:</label>
                            <select class="form-control" id="category" name="category">
                                <option value="0">Uncategorized</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="res-alt" class="control-label">Alt: *</label>
                            <input type="text" class="form-control" id="alt" name="alt">
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

    <div class="modal fade" id="modal-delete" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modal-delete-label">Are you sure?</h4>
                </div>
                <div class="modal-body">
                    <p>You are about to delete a resource. 'Cancel' to stop, 'OK' to delete.</p>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="{{ mix('vendor/jquery-simplePagination/jquery-simplePagination.js') }}"></script>
    <script>
        var uploads_small_url = '{{ \App\Services\Uploads::getUploadUrls()['upload_images_small'] }}/';
        var uploads_url = '{{ \App\Services\Uploads::getUploadUrls()['upload'] }}/';
        var filetypes_url = '{{ url('/img/filetypes/') }}/'
    </script>
    <script src="{{ mix('js/admin/resources/index.js') }}"></script>

@stop