<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PostsTagRequest;
use App\Models\Repositories\PostsTagsRepositoryInterface;
use App\Models\PostsTag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class PostsTagController extends Controller
{

    /**
     * @var PostsTagsRepositoryInterface
     */
    private $_posts_tags;

    public function __construct(PostsTagsRepositoryInterface $posts_tags)
    {
        $this->_posts_tags = $posts_tags;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $output = $request->input('output', 'page');
        if (Auth::user()->can('view_all', PostsTag::class)) {
            if ($output === 'search') {
                $column = $request->input('column', 'name');
                $keyword = $request->input('keyword', '');
                $tags = $this->_posts_tags->searchByColumn($column, $keyword);
            } else {
                $limit = $request->input('limit', 10);
                $offset = $request->input('offset', 0);
                $tags = $this->_posts_tags->getAllWithLimit($limit, $offset);
                $count = $this->_posts_tags->getCountAll();
            }
            if ($output === 'page') {
                return view('admin.posts.tags.index', compact('tags', 'count'));
            } else if ($output === 'table') {
                return view('admin.posts.tags.tables.posts-tags-table', compact('tags', 'count'));
            } else if ($output === 'search') {
                $list = array();
                foreach ($tags as $tag) {
                    $list[] = $tag->name;
                }
                return response()->json($list);
            } else {
                return response('', 204);
            }
        } else {
            if ($output === 'page') {
                return response()->view('errors.admin-403')->setStatusCode(403);
            } else if ($output === 'table') {
                $users = [];
                $count = [];
                return response()->view(
                    'admin.posts.tags.tables.posts-tags-table',
                    compact('users', 'count'))->setStatusCode(403);
            } else if ($output === 'search') {
                response()->json([]);
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PostsTagRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostsTagRequest $request)
    {
        $tag = new PostsTag();
        $tag->name = $request->input('name');
        $success = $tag->save();
        return response()->json(['success' => $success]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PostsTagRequest  $request
     * @param  \App\Models\PostsTag $tag
     * @return \Illuminate\Http\Response
     */
    public function update(PostsTagRequest $request, PostsTag $tag)
    {
        $tag->name = $request->input('name');
        $success = $tag->update();
        return response()->json(['success' => $success]);
    }

    /**
     * Remove the specified resource from storage
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $success = PostsTag::destroy($id);
        return response()->json(['success' => $success]);
    }
}
