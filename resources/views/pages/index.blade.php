@extends('_layouts.public', ['title', 'body_title' => $page->title])

@section('content')

    <section class="row">
        <div class="col-md-12">
            <h1 class="hidden">{{ $page->title }}</h1>
            <?= $page->content ?>
        </div>
    </section>

@stop