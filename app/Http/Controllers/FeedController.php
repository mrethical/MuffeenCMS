<?php

namespace App\Http\Controllers;

class FeedController extends Controller
{
    public function index()
    {
        $feed = \App::make("feed");

        $posts = \App\Repositories\Posts::getMostRecent(10);
        $uploads_small_url = \App\Services\Uploads::getUploadUrls()['upload_images_small'];

        $feed->title = config('app.name') . ' Blog';
        $feed->description = 'Recent blogs from ' . config('app.name');
        $feed->logo = '';
        $feed->link = url('/feed');
        $feed->setDateFormat('datetime');
        if (count($posts)) {
            $feed->pubdate = $posts[0]->created_at;
        }
        $feed->lang = 'en';
        $feed->setShortening(true);
        $feed->setTextLimit(100);

        foreach ($posts as $post)
        {
            $feed->add(
                $post->title,
                $post->author,
                url('/posts/'.$post->slug),
                $post->created_at,
                ($post->resource) ?
                    '<p><img src="'.url($uploads_small_url.'/'.$post->resource->name).'"></p>' :
                    '',
                    // $post->description,
                $post->content
            );
        }

        return $feed->render('rss');
    }
}
