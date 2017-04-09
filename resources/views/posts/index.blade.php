@extends('_layouts.public', ['title', 'body_title' => 'Blog Post'])

@section('content')

    <section class="row">
        <div class="col-md-12">
            <h1>{{ $post->title }}</h1>
            <div>
                <span><i class="fa fa-calendar"></i> {{ date('F d, Y', strtotime($post->created_at))}}</span>
                <span><i class="fa fa-user"></i> {{ $post->user ->name }}</span>
            </div>
        </div>
        <div class="col-md-9">
            <hr>
            <article>
                <h2 class="hidden">Article</h2>
                @if($post->resource)
                    <div id="article-img-container" style=" display: none;">
                        <img id="article-img" style="max-width: 100%;" src="{{ url($uploads_url.'/'. $post->resource->name) }}">
                    </div>
                    <div id="article-img-preview" style="overflow: hidden; margin-bottom: 30px;"></div>
                @endif
                <?= $post->content ?>
            </article>
        </div>
        <div class="col-md-3">
            @include('posts.aside')
        </div>
    </section>

@stop

@section('styles')
    <link rel="stylesheet" href="{{ mix('/css/posts/index.css') }}">
@append

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropper/3.0.0-beta/cropper.min.js"></script>
    <script type="text/javascript">
        <?php $attr = json_decode($post->resource_attributes); ?>
        let data = {
            x: {{ $attr->x }},
            y: {{ $attr->y }},
            width: {{ $attr->width }},
            height: {{ $attr->height }}
        };
    </script>
    <script src="{{ mix('/js/posts/index.js') }}"></script>
@append