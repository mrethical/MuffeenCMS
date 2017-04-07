<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PostCategoryRequest;
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

    public function store(PostCategoryRequest $request)
    {
        PostCategory::create([
            'name' => $request->name,
            'parent_id' => ($request->parent) ? $request->parent : null,
            'slug' => $request->slug
        ]);

        return response()->json(['success' => 'success']);
    }

    public function update(PostCategoryRequest $request, PostCategory $category)
    {
        $category->name = $request->name;
        $category->parent_id = ($request->parent) ? $request->parent : null;
        $category->slug = $request->slug;
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
