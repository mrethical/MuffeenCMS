<?php

namespace App\Http\Controllers\Admin;

use App\Models\PostCategory;
use App\Repositories\PostCategories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostCategoriesController extends Controller
{

    public function index()
    {
        $this->authorize('view_all', PostCategory::class);

        if(request()->ajax()) {
            return response()->json([
                'list' => PostCategories::getAllWithLimit(
                    request('limit', 100),
                    (request('page', 1) - 1) * request('limit', 100)
                ),
                'count' => PostCategories::getCount()
            ])
                ->header('Cache-Control', 'no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        }

        return view('admin.posts.categories');
    }

    public function possible_parent()
    {
        $this->authorize('view_all', PostCategory::class);

        return response()->json(PostCategories::getPossibleParent(request('id', 0)));
    }

    public function store(Request $request)
    {
        $this->authorize('create', PostCategory::class);

        $this->validate($request, [
            'name' => 'required|unique:posts_categories|max:255',
        ]);

        PostCategory::create([
            'name' => $request->name,
            'parent_id' => ($request->parent) ? $request->parent : null
        ]);

        return response()->json(['success' => 'success']);
    }

    public function update(Request $request, PostCategory $category)
    {
        $this->authorize('update', $category);

        $this->validate($request, [
            'name' => 'required|unique:posts_categories,name,'.$category->id.'|max:255',
        ]);

        $category->name = $request->name;
        $category->parent_id = ($request->parent) ? $request->parent : null;
        $category->update();

        return response()->json(['success' => 'success']);
    }

    public function destroy(PostCategory $category)
    {
        $this->authorize('delete', $category);

        $category->delete();

        return response()->json(['success' => 'success']);
    }

}
