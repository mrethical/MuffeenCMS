<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PostsCategoryRequest;
use App\Models\Repositories\PostsCategoriesRepositoryInterface;
use App\Models\PostsCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Auth;
use Validator;

class PostsCategoryController extends Controller
{

    /**
     * @var PostsCategoriesRepositoryInterface
     */
    private $_posts_categories;

    public function __construct(PostsCategoriesRepositoryInterface $posts_categories)
    {
        $this->_posts_categories = $posts_categories;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $output = $request->input('output', 'page');
        if (Auth::user()->can('view_all', PostsCategory::class)) {
            $limit = $request->input('limit', 10);
            $offset = $request->input('offset', 0);
            $categories = $this->_posts_categories->getAllWithLimit($limit, $offset);
            $count = $this->_posts_categories->getCountAll();
            if ($output === 'page') {
                return view('admin.posts.categories.index', compact('categories', 'count'));
            } else if ($output === 'table') {
                return view('admin.posts.categories.tables.posts-categories-table', compact('categories', 'count'));
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
                    'admin.posts.categories.tables.posts-categories-table',
                    compact('users', 'count'))->setStatusCode(403);
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
     * @param  \App\Http\Requests\PostsCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostsCategoryRequest $request)
    {
        $category = new PostsCategory();
        $category->name = $request->name;
        $category->parent_id = ($request->parent) ? $request->parent : null;
        $success = $category->save();
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PostsCategory $category)
    {
        if (Auth::user()->can('update', $category)) {
            Validator::extend('possible_parent', function ($attribute, $value, $parameters, $validator) {
                $parents = $this->_posts_categories->getPossibleParent($parameters[0])->pluck('id')->toArray();
                return in_array($value, $parents);
            });
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:posts_categories,name,'. $category->id . '|max:255',
                'parent' => 'possible_parent:'.$category->id,
            ], ['possible_parent' => 'Selected parent is already a child of the category.']);
            if ($validator->fails()) {
                $errors = $validator->getMessageBag()->toArray();
                return new JsonResponse($errors, 422);
            }
            $category->name = $request->input('name');
            $category->parent_id = ($request->parent) ? $request->parent : null;
            $success = $category->update();
            return response()->json(['success' => $success]);
        } else {
            return response()->json('Sorry, you are not authorized to do this action.')->setStatusCode(403);
        }
    }

    /**
     * Remove the specified resource from storage
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $success = PostsCategory::destroy($id);
        return response()->json(['success' => $success]);
    }

    public function possible_parents($id)
    {
        $parents = $this->_posts_categories->getPossibleParent($id);
        return response()->json($parents);
    }
}
