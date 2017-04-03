@extends('_layouts.admin')

@section('styles')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css" />
    <link rel="stylesheet" href="{{ url('/vendor/jquery-toast-plugin/jquery.toast.min.css') }}">
    <link rel="stylesheet" href="{{ mix('css/admin/resources/create.css') }}">

@stop

@section('sidebar')

    @include('_layouts.admin-sidebar', ['active' => 'Resources-Add New'])

@stop

@section('content')

    <section class="content-header">
        <h1>
            Add New
            <small>Resources</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <a href="{{ url('/admin/resources') }}">
                    <i class="fa fa-file"></i> Resources
                </a>
            </li>
            <li class="active">
                <a href="#">Add New</a>
            </li>
        </ol>
    </section>

    <section id="content-body" class="content">

        @if (count($errors) > 0)
            <div class="alert alert-danger alert-dismissable">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(request()->session()->get('added', null))
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                File has been uploaded successfully.
            </div>
        @endif

        <div class="row">

            <div class="col-xs-12">
                <div class="box">

                    <div class="box-body">

                        <p>Select files to upload. (Max upload: 5 MB)</p>

                        <div class="row">
                            <div class="col-md-6">
                                <form action="{{ url('admin/resources') }}" method="post"
                                      enctype="multipart/form-data">
                                    {{ $field = csrf_field() }}
                                    <div class="form-group">
                                        <label>Category:</label>
                                        <select class="form-control" name="category">
                                            <option value="0">Uncategorized</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group single-upload" style="display: none">
                                        <label>File:</label>
                                        <input type="file" name="file"/>
                                        <input type="hidden" name="send" value="Yes" />
                                    </div>
                                    <div class="form-group single-upload" style="display: none">
                                        <input class="btn btn-default" name="submit" type="submit" value="Submit" />
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 multiple-upload">
                                <form action="{{ url('admin/resources') }}" method="post" enctype="multipart/form-data"
                                      class="dropzone" id="resource-dropzone">
                                    {{ $field }}
                                    <input type="hidden" name="action" value="resource_upload" />
                                    <input type="hidden" name="category" value="" />
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <label>Actions:</label>
                        <br>
                        <button type="button" id="upload-type-1" data-type="multiple"
                            class="btn btn-primary btn-flat upload-type">Single/Native Uploader</button>
                        <a class="btn btn-primary btn-flat" href="{{ url('admin/resources') }}">Back to Resources</a>

                    </div>

                </div>
            </div>

        </div>

    </section>

@stop

@section('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js"></script>
    <script src="{{ url('/vendor/jquery-toast-plugin/jquery.toast.min.js') }}"></script>
    <script src="{{ mix('js/admin/resources/create.js') }}"></script>

@stop