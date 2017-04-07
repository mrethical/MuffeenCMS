<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use App\Repositories\Pages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{

    public function index()
    {
        $this->authorize('view_all', Page::class);

        if(request()->ajax()) {
            return response()->json([
                'list' => Pages::getAllWithLimit(
                    request('limit', 100),
                    (request('page', 1) - 1) * request('limit', 100)
                ),
                'count' => Pages::getCount()
            ])
                ->header('Cache-Control', ' no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        }

        return view('admin.pages.index');
    }

    public function create()
    {
        $this->authorize('create', Page::class);

        $page = new Page;
        return view('admin.pages.create', compact('page'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Page::class);

        $this->validate($request, [
            'title' => 'required|unique:pages|max:255',
            'content' => 'required',
            'slug' => 'required|unique:pages|max:255'
        ]);

        $page = Page::create([
            'title' => $request->title,
            'content' => $request->input('content'),
            'slug' => $request->slug
        ]);

        $request->session()->flash('added', $page->id);
        return redirect(url('/admin/pages'));
    }

    public function edit(Page $page)
    {
        $this->authorize('update', $page);

        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $this->authorize('update', $page);

        $this->validate($request, [
            'title' => 'required|unique:pages,title,'.$page->id.'|max:255',
            'content' => 'required',
            'slug' => 'required|unique:pages,slug,'.$page->id.'|max:255'
        ]);

        $page->title = $request->title;
        $page->content = $request->input('content');
        $page->slug = $request->slug;
        $page->update();

        $request->session()->flash('edited', $page->id);
        return redirect(url('/admin/pages/'.$page->id.'/edit'));
    }

    public function destroy(Page $page)
    {
        $this->authorize('delete', $page);

        $page->delete();

        return response()->json(['success' => 'success']);
    }

}
