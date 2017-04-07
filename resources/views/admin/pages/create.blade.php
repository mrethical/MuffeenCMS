@extends('_layouts.admin')

@section('sidebar')

    @include('_layouts.admin-sidebar', ['active' => 'Pages-Add New'])

@stop

@section('content')

    <section class="content-header">
        <h1>
            Add New Page
            <small>Pages</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <a href="{{ url('/admin/pages') }}">
                    <i class="fa fa-clone"></i> Pages
                </a>
            </li>
            <li class="active">
                <a href="#">Add New</a>
            </li>
        </ol>
    </section>

    <section class="content">

        @if (count($errors) > 0)
            <div class="alert alert-danger alert-dismissable">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-xs-12">
                @include('admin.pages.form', ['action' => url('/admin/pages/')])
            </div>
        </div>

    </section>

@stop

@section('scripts')
    <script src="{{ mix('/js/admin/slug.js') }}"></script>
@append