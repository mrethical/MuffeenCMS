@extends('_layouts.admin')

@section('sidebar')

    @include('_layouts.admin-sidebar', ['active' => 'Dashboard'])

@stop

@section('content')

    <section class="content-header">
        <h1>Dashboard</h1>
        <ol class="breadcrumb">
            <li class="active">
                <a href="#">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
            </li>
        </ol>
    </section>

    <section class="content">



    </section>

@stop