@extends('_layouts.admin')

@section('styles')

    <link rel="stylesheet" href="{{ url('/vendor/jquery-toast-plugin/jquery.toast.min.css') }}">
    <link rel="stylesheet" href="{{ url('/css/admin/menus/edit.css') }}">

@stop

@section('sidebar')

    @include('_layouts.admin-sidebar', ['active' => 'Menus-' . $menu->name])

@stop

@section('content')

    <section class="content-header">
        <h1>
            Edit {{ $menu->name }} Menu
            <small>Menus</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <a href="#"><i class="fa fa-bars" aria-hidden="true"></i> Menus</a>
            </li>
            <li class="active">
                <a href="#">Edit</a>
            </li>
        </ol>
    </section>

    <section class="content">

        <input type="hidden" id="id" value="{{ $menu->id }}">
        <input type="hidden" id="_token" value="{{ csrf_token() }}">

        <div class="row">

            <div class="col-xs-12">

                <div class="box">
                    <div class="box-header">
                        <button class="btn btn-flat btn-default" type="button" id="undo">
                            <i class="fa fa-undo" aria-hidden="true"></i>
                            Undo
                        </button>
                    </div>
                    <div class="row box-body">
                        <div class="col-md-8">
                            <p><b>Note: </b>Click <i>add item</i> to add a new item. Drag item/s to sort.</p>
                            <ul class="menu todo-list"></ul>
                        </div>
                    </div>
                    <div class="box-footer">
                        <label>Actions: </label>
                        <br>
                        <button type="button" class="btn btn-flat btn-primary" id="save">Save</button>
                        <button class="btn btn-flat btn-primary" type="button" id="add-menu"
                            data-toggle="modal" data-target="#modal-item" data-action="Add New">Add Item</button>
                    </div>
                </div>

            </div>
        </div>

    </section>

    <div class="modal fade" id="modal-item" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="modal-item-label"></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control item-edit" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="name">URL: <span class="visible-xs">( {{ url('/') }}/...)</span></label>
                        <div class="input-group">
                            <div class="input-group-addon hidden-xs">{{ url('/') }}/</div>
                            <input type="text" class="form-control item-edit" id="url" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="modal-item-submit">Submit</button>
                </div>
            </div>
        </div>
    </div>

@stop

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-sortable/0.9.13/jquery-sortable-min.js"></script>
    <script src="{{ url('/vendor/jquery-toast-plugin/jquery.toast.min.js') }}"></script>
    <script src="{{ mix('/js/admin/menus/edit.js') }}"></script>
@stop