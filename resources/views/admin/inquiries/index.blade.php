@extends('_layouts.admin')

@section('styles')

    <link rel="stylesheet" href="{{ url('/vendor/jquery-toast-plugin/jquery.toast.min.css') }}">
    <link rel="stylesheet" href="{{ mix('/css/admin/inquiries/index.css') }}">

@stop

@section('sidebar')

    @include('_layouts.admin-sidebar', ['active' => 'Inquiries'])

@stop

@section('content')

    <section class="content-header">
        <h1>
            All Inquiries
            <small>Inquiries</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <a href="#">
                    <i class="fa fa-envelope"></i> Inquiries
                </a>
            </li>
            <li class="active">
                <a href="#">All Inquiries</a>
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
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody id="table-body">
                            <tr class="empty-table-row">
                                <td colspan="5">No records to show.</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="overlay">
                        <i class="fa fa-refresh fa-spin"></i>
                    </div>
                </div>
            </div>

        </div>

    </section>

    <div class="modal fade" id="modal-inquiry" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Subject: <span id="subject"></span></h4>
                </div>
                <div class="modal-body">
                    <p><span class="inquiry-label">Name: </span><span id="name"></span></p>
                    <p><span class="inquiry-label">Email: </span><span id="email"></span></p>
                    <p><span class="inquiry-label">Message: </span><span id="message"></span></p>
                    <p><span class="inquiry-label">Date: </span><span id="date"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-delete" tabindex="-1" role="dialog">
        <input type="hidden" id="user-token" value="{{ csrf_token() }}" />
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modal-delete-label">Are you sure?</h4>
                </div>
                <div class="modal-body">
                    <p>You are about to delete a inquiry. 'Cancel' to stop, 'OK' to delete.</p>
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
    <script src="{{ mix('js/admin/inquiries/index.js') }}"></script>

@stop