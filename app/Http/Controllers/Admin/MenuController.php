<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\MenuRequest;
use App\Models\Repositories\MenusRepositoryInterface;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Auth;
use Validator;

class MenuController extends Controller
{

    /**
     * @var MenusRepositoryInterface
     */
    private $_menus;

    public function __construct(MenusRepositoryInterface $menus)
    {
        $this->_menus = $menus;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $output = $request->input('output', 'page');
        if (Auth::user()->can('view_all', Menu::class)) {
            $limit = $request->input('limit', 10);
            $offset = $request->input('offset', 0);
            $menus = $this->_menus->getAllWithLimit($limit, $offset);
            $count = $this->_menus->getCountAll();
            if ($output === 'page') {
                return view('admin.menus.index', compact('menus', 'count'));
            } else if ($output === 'table') {
                return view('admin.menus.tables.menus-table', compact('menus', 'count'));
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
                    'admin.menus.tables.menus-table',
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
     * @param  \App\Http\Requests\MenuRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuRequest $request)
    {
        $menu = new Menu();
        $menu->name = $request->name;
        $menu->post_id = ($request->post_id) ? $request->post_id : null;
        $menu->parent_id = ($request->parent) ? $request->parent : null;
        $success = $menu->save();
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
     * @param  \App\Models\Menu $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        if (Auth::user()->can('update', $menu)) {
            Validator::extend('possible_parent', function ($attribute, $value, $parameters, $validator) {
                $parents = $this->_menus->getPossibleParent($parameters[0])->pluck('id')->toArray();
                return in_array($value, $parents);
            });
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:menus,name,'. $menu->id . '|max:255',
                'parent' => 'possible_parent:'.$menu->id,
            ], ['possible_parent' => 'Selected parent is already a child of the menu.']);
            if ($validator->fails()) {
                $errors = $validator->getMessageBag()->toArray();
                return new JsonResponse($errors, 422);
            }
            $menu->name = $request->name;
            $menu->post_id = ($request->post_id) ? $request->post_id : null;
            $menu->parent_id = ($request->parent) ? $request->parent : null;
            $success = $menu->update();
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
        $success = Menu::destroy($id);
        return response()->json(['success' => $success]);
    }

    public function possible_parents($id)
    {
        $parents = $this->_menus->getPossibleParent($id);
        return response()->json($parents);
    }
}
