@extends('admin')

@section('content')

    <div class="row adjust-top">
        <div class="col-lg-12">
            <div class="alert alert-danger" role="alert">
                <p>Sorry, you are not authorized to view this section. <a href="{{ url('/admin') }}">Back to Dashboard</a></p>
            </div>
        </div>
    </div>

@stop