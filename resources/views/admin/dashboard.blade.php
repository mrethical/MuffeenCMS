@extends('_layouts.admin')

@section('sidebar')

    @include('_layouts._admin-sidebar.superadmin', ['active' => '1'])

@stop

@section('content')

    <section class="content-header">
        <h1>Dashboard</h1>
        <ol class="breadcrumb">
            <li class="active"><i class="fa fa-dashboard"></i> Dashboard</li>
        </ol>
    </section>

    <section class="content">



    </section>

@stop