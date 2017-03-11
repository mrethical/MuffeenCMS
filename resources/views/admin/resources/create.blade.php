@extends('admin')

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="page-header">
                <h1>Add Resources</h1>
                <button type="button" id="upload-type-1" data-type="multiple" class="btn btn-primary upload-type pull-right">Single/Native Uploader</button>
            </div>
        </div>
        @if($errors->messages())
            <div class="col-lg-12">
                <div class="alert alert-danger alert-dismissable" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    @foreach($errors->messages() as $errs)
                        @foreach($errs as $err)
                            <p>{{ $err }}</p>
                        @endforeach
                    @endforeach
                </div>
            </div>
        @endif
        @if($added)
            <div class="col-lg-12">
                <div class="alert alert-success alert-dismissable" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    File has been uploaded successfully.
                </div>
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-lg-12">
            <p class="help-block">Select files to upload. (Max upload: 5 MB)</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <form action="{{ url('admin/resources') }}" method="post" enctype="multipart/form-data">
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
                    <a class="btn btn-default" href="{{ url('admin/resources') }}">Back to Resources</a>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 multiple-upload">
            <form action="{{ url('admin/resources') }}" method="post" enctype="multipart/form-data" class="dropzone" id="resource-dropzone">
                {{ $field }}
                <input type="hidden" name="action" value="resource_upload" />
                <input type="hidden" name="category" value="" />
            </form>
            <div class="margin-top-one">
                <a class="btn btn-default" href="{{ url('admin/resources') }}">Back to Resources</a>
            </div>
        </div>
    </div>

@stop

@section('styles')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.css" integrity="sha256-e47xOkXs1JXFbjjpoRr1/LhVcqSzRmGmPqsrUQeVs+g=" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ elixir('css/admin/resource-create.css') }}">

@stop

@section('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.3.0/min/dropzone.min.js" integrity="sha256-p2l8VeL3iL1J0NxcXbEVtoyYSC+VbEbre5KHbzq1fq8=" crossorigin="anonymous"></script>
    <script src="{{ elixir('js/admin/resource-create.js') }}"></script>

@stop