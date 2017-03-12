<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Models\PostsCategory;
use App\Models\PostsTag;
use App\Models\Repositories\PostsCategoriesRepositoryInterface;
use App\Models\Repositories\PostsRepositoryInterface;
use App\Models\Repositories\ResourcesRepositoryInterface;
use App\Models\Repositories\ResourcesCategoriesRepositoryInterface;
use App\Models\Resource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class PostController extends Controller
{

    /**
     * @var PostsRepositoryInterface
     */
    private $_posts;

    /**
     * @var PostsCategoriesRepositoryInterface
     */
    private $_posts_categories;

    /**
     * @var ResourceRepositoryInterface
     */
    private $_resources;

    /**
     * @var ResourcesCategoriesRepositoryInterface
     */
    private $_resources_categories;

    private $_uploads_locations = [];

    public function __construct(
        PostsRepositoryInterface $post,
        PostsCategoriesRepositoryInterface $posts_categories,
        ResourcesRepositoryInterface $resources,
        ResourcesCategoriesRepositoryInterface $resources_categories
    ) {
        $this->_posts = $post;
        $this->_posts_categories = $posts_categories;
        $this->_resources = $resources;
        $this->_resources_categories = $resources_categories;
        $this->_uploads_locations = Resource::getUploadLocations();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $output = $request->input('output', 'page');
        if ($output == 'page') {
            if ($request->ajax()) {
                $output = 'pair';
            }
        }
        if (Auth::user()->can('view_all', Post::class)) {
            if ($output != 'pair') {
                $limit = $request->input('limit', 10);
                $offset = $request->input('offset', 0);
                $posts = $this->_posts->getAllWithLimit($limit, $offset);
                $count = $this->_posts->getCountAll();
                $categories = $this->_posts_categories->getPairAll();
                if ($output === 'page') {
                    $added = request()->session()->get('added', null);
                    return view('admin.posts.index', compact('posts', 'categories', 'count', 'added'));
                } else if ($output === 'table') {
                    return view('admin.posts.tables.posts-table', compact('posts', 'categories', 'count'));
                } else {
                    return response('', 204);
                }
            } else {
                return response()->json($this->_posts->getPairAll());
            }
        } else {
            if ($output === 'page') {
                return response()->view('errors.admin-403')->setStatusCode(403);
            } else if ($output === 'table') {
                $posts = [];
                $categories = [];
                $count = [];
                return response()->view(
                    'admin.posts.tables.posts-table',
                    compact('posts', 'categories', 'count'))->setStatusCode(403);
            } else if ($output === 'pair') {
                return response()->json([], 403);
            } else {
                return response('', 403);
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->can('create', Post::class)) {
            $categories = $this->_posts_categories->getAll();
            $resources = $this->_resources->getAllImages();
            $resources_categories = $this->_resources_categories->getPairAll();
            $locations = Resource::getUrlLocations();
            return view('admin.posts.create', compact('categories', 'resources', 'resources_categories', 'locations'));
        } else {
            return response()->view('errors.admin-403')->setStatusCode(403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->can('create', Post::class)) {
            $validation = [
                'title' => 'required|max:255|unique:posts',
                'content' => 'required',
            ];
            if ($request->category) $validation['category_id'] = 'exists:posts_categories,id';
            if ($request->image) $validation['resource_id'] = 'exists:resources,id';
            $this->validate($request, $validation);
            $post = new Post();
            $post->title = $request->title;
            $post->category_id = ($request->category) ? $request->category : null;
            $post->resource_id = ($request->image) ? $request->image : null;
            $post->content = $request->input('content');
            $post->author = $user->id;
            $post->slug = str_slug($request->title);
            $success = $post->save();
            if ($request->tags) {
                foreach ($request->tags as $tag_name)
                {
                    $tag = PostsTag::firstOrCreate(['name' => $tag_name]);
                    $post->tags()->save($tag);
                }
            }
            if ($success) {
                $request->session()->flash('added', $post->id);
                return redirect('/admin/posts');
            } else {
                return response()->view('errors.admin-500')->setStatusCode(500);
            }
        } else {
            return response()->view('errors.admin-403')->setStatusCode(403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if (Auth::user()->can('update', $post)) {
            $categories = $this->_posts_categories->getAll();
            $resources = $this->_resources->getAllImages();
            $resources_categories = $this->_resources_categories->getPairAll();
            $locations = Resource::getUrlLocations();
            $tags = $post->tags;
            $edited = request()->session()->get('edited', null);
            return view('admin.posts.edit', compact('post', 'tags', 'categories', 'resources', 'resources_categories', 'locations', 'edited'));
        } else {
            return response()->view('errors.admin-403')->setStatusCode(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $user = Auth::user();
        if ($user->can('update', $post)) {
            $validation = [
                'title' => 'required|max:255|unique:posts,title,' . $post->id,
                'content' => 'required',
            ];
            if ($request->category) $validation['category_id'] = 'exists:posts_categories,id';
            if ($request->image) $validation['resource_id'] = 'exists:resources,id';
            $this->validate($request, $validation);
            $post->title = $request->title;
            $post->category_id = ($request->category) ? $request->category : null;
            $post->resource_id = ($request->image) ? $request->image : null;
            $post->content = $request->input('content');
            $post->slug = str_slug($request->title);
            $success = $post->update();
            $post->tags()->detach();
            if ($request->tags) {
                foreach ($request->tags as $tag_name) {
                    $tag = PostsTag::firstOrCreate(['name' => $tag_name]);
                    $post->tags()->save($tag);
                }
            }
            if ($success) {
                $request->session()->flash('edited', $post->id);
                return redirect('/admin/posts/' . $post->id . '/edit');
            } else {
                return response()->view('errors.admin-500')->setStatusCode(500);
            }
        } else {
            return response()->view('errors.admin-403')->setStatusCode(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if (Auth::user()->can('delete', $post)) {
            $success = $post->delete();
            return response()->json(['success' => $success]);
        } else {
            return response()->json('Sorry, you are not authorized to do this action.')->setStatusCode(403);
        }
    }

}
