@extends('admin')

@section('content')

    <div class="row adjust-top">
        <div class="col-lg-12">
            <div class="alert alert-danger" role="alert">
                <p>Sorry, an error has occured. Please try again. <a href="{{ url()->previous() }}">Back to Previous Page</a></p>
            </div>
        </div>
    </div>

@stop