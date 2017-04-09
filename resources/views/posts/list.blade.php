@extends('_layouts.public', ['title', 'body_title' => 'Blogs'])

@section('content')

    <section class="row">
        <div class="col-md-12">
            <h1>{{ $header }}</h1>
        </div>
        <div class="col-md-9">
            <section id="posts">
                <h2 class="hidden">List</h2>
                <hr>
                <ul>
                    @foreach($posts as $post)
                        <li>
                            @if($post->resource)
                                <div class="col-sm-5">
                                    <div class="blog-image-container">
                                        <img src="{{ url('/uploads/images-medium/' . $post->resource->name) }}">
                                    </div>
                                </div>
                                <div class="col-sm-7">
                            @else
                                <div class="blog-image-none col-md-12">
                            @endif
                                    <a href="{{ url('/' . $post->slug) }}">{{ $post->title }}</a>
                                    <p class="blog-date">~ {{ date('F d, Y', strtotime($post->created_at)) }}</p>
                                    <p class="blog-content">{{ substr(preg_replace("/&#?[a-z0-9]{2,8};/i", "", strip_tags($post->content)), 0, 500) }} ... </p>
                                    <hr class="blog-divider">
                                    <div class="col-xs-6">
                                        <p class="blog-info-header">Posted By: </p>
                                        <p>{{ $post->user->name }}</p>
                                    </div>
                                    <div class="col-xs-6">
                                        <p class="blog-info-header">Posted Under: </p>
                                        <p>{{ ($post->category) ? $post->category->name : 'Uncategorized' }}</p>
                                    </div>
                                </div>
                        </li>
                    @endforeach
                </ul>
            </section>
            <nav class="text-center" aria-label="Page navigation">
                <h2 class="hidden">Pagination</h2>
                <ul class="pagination">
                    @if($page<2)
                        <li class="disabled">
                            <span aria-hidden="true">&laquo;</span>
                        </li>
                    @else
                        <li>
                            <a href="{{ url($page_url.'?page='.($page-1)) }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    @endif
                    @for ($i = 1; $i <= ceil($count/10); $i++)
                        @if($page == $i)
                            <li class="active"><a href="#">{{ $i }}</a></li>
                        @else
                            <li><a href="{{ url($page_url.'?page='.$i) }}">{{ $i }}</a></li>
                        @endif
                    @endfor
                    @if($page>floor($count/10)-1)
                        <li class="disabled">
                            <span aria-hidden="true">&raquo;</span>
                        </li>
                    @else
                        <li>
                            <a href="{{ url($page_url.'?page='.($page+1)) }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
        <div class="col-md-3">
            @include('posts.aside')
        </div>
    </section>

@stop

@section('styles')
    <link rel="stylesheet" href="{{ mix("/css/posts/list.css") }}">
@append

@section('scripts')
    <script src="{{ mix("/js/posts/list.js") }}"></script>
@append