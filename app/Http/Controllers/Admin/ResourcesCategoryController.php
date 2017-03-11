<?php

namespace App\Http\Controllers\Admin;

use App\Models\Repositories\ResourcesCategoriesRepositoryInterface;
use App\Models\Repositories\ResourcesRepositoryInterface;
use App\Models\Resource;
use App\Models\ResourcesCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResourcesCategoryRequest;
use Auth;

class ResourcesCategoryController extends Controller
{

    /**
     * @var ResourcesCategoriesRepositoryInterface
     */
    private $_resources_categories;

    /**
     * @var ResourcesCategoriesRepositoryInterface
     */
    private $_resources;

    public function __construct(ResourcesCategoriesRepositoryInterface $resources_categories, ResourcesRepositoryInterface $resources)
    {
        $this->_resources_categories = $resources_categories;
        $this->_resources = $resources;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $output = $request->input('output', 'page');
        if (Auth::user()->can('view_all', ResourcesCategory::class)) {
            $limit = $request->input('limit', 10);
            $offset = $request->input('offset', 0);
            $categories = $this->_resources_categories->getAllWithLimit($limit, $offset);
            $count = $this->_resources_categories->getCountAll();
            if ($output === 'page') {
                return view('admin.resources.categories.index', compact('categories', 'count'));
            } else if ($output === 'table') {
                return view('admin.resources.categories.tables.resources-categories-table', compact('categories', 'count'));
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
                    'admin.resources.categories.tables.resources-categories-table',
                    compact('users', 'count'))->setStatusCode(403);
            } else {
                return response('', 403);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $category = $this->_resources_categories->getByID($id);
        $output = $request->input('output');
        if ($output === 'resources_select_options') {
            $images_only = $request->input('images_only', false);
            if (Auth::user()->can('view_all', Resource::class)) {
                if ($id === '-1') {
                    if ($images_only) {
                        $resources = $this->_resources->getAllImages();
                    } else {
                        $resources = $this->_resources->getAll();
                    }
                } else if ($id === '0') {
                    if ($images_only) {
                        $resources = $this->_resources->getUncategorizedImages();
                    } else {
                        $resources = $this->_resources->getUncategorized();
                    }
                } else {
                    if ($images_only) {
                        $resources = $category->resources()->whereIn('ext', ['jpeg', 'jpg', 'png', 'gif'])->get();
                    } else {
                        $resources = $category->resources;
                    }
                }
                $locations = Resource::getUrlLocations();
                return view('admin.resources.selects.list', compact('resources', 'locations'));
            } else {
                $resources = [];
                return response()->view(
                    'admin.resources.selects.list',
                    compact('resources'))->setStatusCode(403);
            }
        } else {
            return response('', 204);
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
     * @param  \App\Http\Requests\ResourcesCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResourcesCategoryRequest $request)
    {
        $category = new ResourcesCategory();
        $category->name = $request->name;
        $success = $category->save();
        return response()->json(['success' => $success]);
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
     * @param  \App\Http\Requests\ResourcesCategoryRequest  $request
     * @param  \App\Models\ResourcesCategory $category
     * @return \Illuminate\Http\Response
     */
    public function update(ResourcesCategoryRequest $request, ResourcesCategory $category)
    {
        $category->name = $request->input('name');
        $success = $category->update();
        return response()->json(['success' => $success]);
    }

    /**
     * Remove the specified resource from storage
     *
     * @param  \App\Models\ResourcesCategory $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(ResourcesCategory $category)
    {
        if (Auth::user()->can('delete', $category)) {
            $success = ResourcesCategory::destroy($category->id);
            return response()->json(['success' => $success]);
        } else {
            return response()->json('Sorry, you are not authorized to do this action.')->setStatusCode(403);
        }
    }

}
