<?php

namespace App\Http\Controllers\Admin;

use App\Models\PostTag;
use App\Repositories\PostTags;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostTagsController extends Controller
{

    public function index()
    {
        $this->authorize('view_all', PostTag::class);

        if(request()->ajax()) {
            if (request('ordered')) {
                return response()->json(PostTags::getAllByName());
            }
            if (request('search')) {
                $column = request('column', 'name');
                $keyword = request('keyword', '');
                return response()->json(PostTags::searchByColumn($column, $keyword));
            }
            return response()->json([
                'list' => PostTags::getAllWithLimit(
                    request('limit', 100),
                    (request('page', 1) - 1) * request('limit', 100)
                ),
                'count' => PostTags::getCount()
            ])
                ->header('Cache-Control', 'no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        }

        return view('admin.posts.tags');
    }

    public function store(Request $request)
    {
        $this->authorize('create', PostTag::class);

        $this->validate($request, [
            'name' => 'required|unique:posts_tags|max:255',
            'slug' => 'required'
        ]);

        PostTag::create([
            'name' => $request->name,
            'slug' => $request->slug
        ]);

        return response()->json(['success' => 'success'], 201);
    }

    public function update(Request $request, PostTag $tag)
    {
        $this->authorize('update', $tag);

        $this->validate($request, [
            'name' => 'required|unique:posts_tags,name,'.$tag->id.'|max:255',
            'slug' => 'required'
        ]);

        $tag->name = $request->name;
        $tag->slug = $request->slug;
        $tag->update();

        return response()->json(['success' => 'success']);
    }

    public function destroy(PostTag $tag)
    {
        $this->authorize('delete', $tag);
        $tag->delete();

        return response()->json(['success' => 'success']);
    }

}
