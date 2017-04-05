<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\PostTag;
use App\Repositories\Posts;
use App\Repositories\PostCategories;
use App\Repositories\Resources;
use App\Services\Uploads;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostsController extends Controller
{

    public function index()
    {
        $this->authorize('view_all', Post::class);

        if(request()->ajax()) {
            return response()->json([
                'list' => Posts::getAllWithLimit(
                    request('limit', 100),
                    (request('page', 1) - 1) * request('limit', 100)
                ),
                'count' => Posts::getCount()
            ])
                ->header('Cache-Control', ' no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        }

        return view('admin.posts.index');
    }

    public function create()
    {
        $this->authorize('create', Post::class);

        $post = new Post;
        $categories = PostCategories::getAllByName();
        $resources = Resources::getAllImageByName();
        $locations = Uploads::getUploadUrls();
        return view(
            'admin.posts.create',
            compact('post', 'categories', 'resources', 'locations')
        );
    }

    public function store(Request $request)
    {
        $this->authorize('create', Post::class);

        $this->validate($request, [
            'title' => 'required|unique:posts|max:255',
            'content' => 'required'
        ]);

        $post = Post::create([
            'title' => $request->title,
            'category_id' => $request->category,
            'resource_id' => $request->image,
            'resource_attributes' => json_encode([
                'x' => $request->input('image-x'),
                'y' =>$request->input('image-y'),
                'width' =>$request->input('image-width'),
                'height' =>$request->input('image-height')
            ]),
            'content' => $request->input('content'),
            'slug' => str_slug($request->title),
            'author' => auth()->user()->id
        ]);

        if ($request->tags) {
            foreach ($request->tags as $tag_name)
            {
                $tag = PostTag::firstOrCreate(['name' => $tag_name]);
                $post->tags()->save($tag);
            }
        }

        $request->session()->flash('added', $post->id);
        return redirect(url('/admin/posts'));
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        $categories = PostCategories::getAllByName();
        $resources = Resources::getAllImageByName();
        $locations = Uploads::getUploadUrls();
        $image = json_decode($post->resource_attributes, true);
        return view(
            'admin.posts.edit',
            compact('post', 'categories', 'resources', 'locations', 'image')
        );
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $this->validate($request, [
            'title' => 'required|unique:posts,title,'.$post->id.'|max:255',
            'content' => 'required'
        ]);

        $post->title = $request->title;
        $post->category_id = $request->category;
        $post->resource_id = $request->image;
        $post->resource_attributes = json_encode([
            'x' => $request->input('image-x'),
            'y' =>$request->input('image-y'),
            'width' =>$request->input('image-width'),
            'height' =>$request->input('image-height')
        ]);
        $post->content = $request->input('content');
        $post->slug = str_slug($request->title);
        $post->update();

        $post->tags()->detach();
        if ($request->tags) {
            foreach ($request->tags as $tag_name)
            {
                $tag = PostTag::firstOrCreate(['name' => $tag_name]);
                $post->tags()->save($tag);
            }
        }

        $request->session()->flash('edited', $post->id);
        return redirect(url('/admin/posts/'.$post->id.'/edit'));
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return response()->json(['success' => 'success']);
    }

}
