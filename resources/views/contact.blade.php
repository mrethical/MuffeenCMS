@extends('_layouts.public', ['title', 'body_title' => 'Contact Us'])

@section('content')

    <section class="row">

        <div class="col-md-12">
            <h1>Contact Us</h1>
            <hr>
        </div>

        <form class="col-md-8" method="POST" action="{{ url('/contact') }}">

            {{ csrf_field() }}
            <p>Do you have any question, inquiries or suggestions? Feel free to message us below.</p>
            <br>

            @if($saved = request()->session()->get('saved', null))
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <p>Your message has been sent successfully.</p>
                </div>
            @endif
            @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissable">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <label for="name">Name:</label>
                <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input class="form-control" type="email" name="email" id="email" value="{{ old('email') }}">
            </div>
            <div class="form-group">
                <label for="subject">Subject:</label>
                <input class="form-control" type="text" name="subject" id="subject" value="{{ old('subject') }}">
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea rows="10" class="form-control" name="message" id="message">{{ old('message') }}</textarea>
            </div>
            <div class="form-group">
                <input class="btn btn-primary" type="submit" value="Submit">
            </div>

        </form>

    </section>

@stop