
<hr class="visible-sm">
<section>
    <h4>Search</h4>
    <div class="input-group">
        <input type="text" class="form-control">
        <span class="input-group-btn">
            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
        </span>
    </div>
</section>
<hr>
<section id="aside-categories" class="posts-aside">
    <h4>Categories</h4>
    <ul>
        @foreach($categories as $category)
            <li>&raquo; <a href="{{ url('/categories/' . $category->slug) }}">{{ $category->name }}</a></li>
        @endforeach
        <li>&raquo; <a href="{{ url('/categories/uncategorized') }}">Uncategorized</a></li>
    </ul>
</section>
<hr>
<section id="aside-blogs" class="posts-aside">
    <h4>Recent Articles</h4>
    <ul>
        @foreach($recent_posts as $post)
            <li>
                @if($post->resource)
                    <div class="blog-image-container col-xs-4">
                        <img src="{{ url($uploads_small_url.'/'.$post->resource->name) }}">
                    </div>
                    <div class="col-xs-8">
                @else
                    <div class="blog-image-none col-xs-12">
                @endif
                        <p class="blog-label">{{ ($post->category) ? $post->category->name : 'Uncategorized' }}</p>
                        <a href="{{ url('/posts/' . $post->slug) }}">{{ $post->title }}</a>
                        <p class="blog-label">{{ date('F d, Y', strtotime($post->created_at)) }}</p>
                    </div>
            </li>
        @endforeach
    </ul>
</section>
<hr>
<section id="aside-tags" class="posts-aside">
    <h4>Tags</h4>
    <ul>
        @foreach($tags as $tag)
            <li><a href="{{ url('/tags/'.$tag->slug) }}">{{ $tag->name }}</a></li>
        @endforeach
    </ul>
</section>

@section('styles')
    <link rel="stylesheet" href="{{ mix('/css/posts/aside.css') }}">
@append