<?php

namespace App\Http\Controllers\Admin;

use App\Models\MenuGroup;
use App\Models\Menu;
use App\Models\MenuOrder;
use App\Repositories\Menus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenusController extends Controller
{

    public function edit(MenuGroup $menu)
    {
        $this->authorize('update', $menu);

        if(request()->ajax()) {
            return response()->json(Menus::getByGroupID($menu->id))
                ->header('Cache-Control', ' no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        }

        return view('admin.menus.edit', compact('menu'));
    }

    private function saveChildren($children, $parent, $menu)
    {
        foreach($children as $index=>$child) {
            $child_menu = Menu::create([
                'name' => $child->name,
                'menu_group_id' => $menu->id,
                'url' => $child->url,
                'parent_id' => ($parent) ? $parent->id : null
            ]);
            MenuOrder::create([
                'menu_id' => $child_menu->id,
                'order' => $index
            ]);
            $this->saveChildren($child->children, $child_menu, $menu);
        }
    }

    public function update(Request $request, MenuGroup $menu)
    {
        $this->authorize('update', $menu);

        $menu->children()->delete();
        $this->saveChildren(json_decode($request->data), null, $menu);

        return response()->json(['success' => 'success']);
    }

}
