<?php

namespace App\Http\Controllers\Admin;

use App\Models\ResourceCategory;
use App\Repositories\ResourceCategories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResourceCategoriesController extends Controller
{

    public function index()
    {
        $this->authorize('view_all', ResourceCategory::class);

        if(request()->ajax()) {
            if (request('ordered')) {
                return response()->json(ResourceCategories::getAllByName());
            }
            return response()->json([
                'list' => ResourceCategories::getAllWithLimit(
                    request('limit', 100),
                    (request('page', 1) - 1) * request('limit', 100)
                ),
                'count' => ResourceCategories::getCount()
            ])
                ->header('Cache-Control', 'no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        }

        return view('admin.resources.categories');
    }
    
    public function store(Request $request)
    {
        $this->authorize('create', ResourceCategory::class);

        $this->validate($request, [
            'name' => 'required|unique:resources_categories|max:255',
        ]);

        ResourceCategory::create([
            'name' => $request->name
        ]);

        return response()->json(['success' => 'success']);
    }

    public function update(Request $request, ResourceCategory $category)
    {
        $this->authorize('update', $category);

        $this->validate($request, [
            'name' => 'required|unique:resources_categories,name,'.$category->id.'|max:255',
        ]);

        $category->name = $request->name;
        $category->update();

        return response()->json(['success' => 'success']);
    }

    public function destroy(ResourceCategory $category)
    {
        $this->authorize('delete', $category);
        $category->delete();

        return response()->json(['success' => 'success']);
    }
    
}
