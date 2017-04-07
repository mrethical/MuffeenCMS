@extends('_layouts.admin')

@section('sidebar')

    @include('_layouts.admin-sidebar', ['active' => 'Pages-All Pages'])

@stop

@section('content')

    <section class="content-header">
        <h1>
            Edit Page
            <small>Pages</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <a href="{{ url('/admin/pages') }}">
                    <i class="fa fa-clone"></i> Pages
                </a>
            </li>
            <li class="active">
                <a href="#">Edit</a>
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

        @if($edited = request()->session()->get('edited', null))
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <p>Page was updated successfully. <a href="{{ url('/admin/pages') }}">Back to List</a></p>
            </div>
        @endif

        <div class="row">

            <div class="col-xs-12">
                @include('admin.pages.form', [
                    'action' => url('/admin/pages/'.$page->id),
                    'method' => 'PATCH'
                 ])
            </div>
        </div>

    </section>

@stop