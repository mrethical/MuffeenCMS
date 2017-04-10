@extends('_layouts.public', ['title', 'body_title' => $page->title])

@section('content')

    <section class="row">
        <div class="col-md-12">
            <?= $page->content ?>
        </div>
    </section>

@stop