<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UploadFile;
use App\Models\Resource;
use App\Repositories\ResourceCategories;
use App\Repositories\Resources;
use App\Services\Uploads;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResourcesController extends Controller
{

    public function index()
    {
        $this->authorize('view_all', Resource::class);

        if(request()->ajax()) {
            return response()->json([
                'list' => Resources::getAllWithLimit(
                    request('limit', 100),
                    (request('page', 1) - 1) * request('limit', 100)
                ),
                'count' => Resources::getCount()
            ])
                ->header('Cache-Control', 'no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        }

        $categories = ResourceCategories::getAllByName();
        return view('admin.resources.index', compact('categories'));
    }

    public function create()
    {
        $this->authorize('create', Resource::class);

        $categories = ResourceCategories::getAllByName();
        return view('admin.resources.create', compact('categories'));
    }

    public function store(UploadFile $request)
    {
        $uploads = new Uploads;
        $file = $request->file;
        $name = $uploads->save($file);

        Resource::create([
            'name' => $name,
            'category_id' => ($request->category) ? $request->category : null,
            'title' => $file->getClientOriginalName(),
            'alt' => '',
            'size' => $file->getClientSize(),
            'ext' => strtolower($file->guessClientExtension()),
            'uploaded_by' => auth()->user()->id
        ]);

        if ($request->submit) {
            $request->session()->flash('added', true);
            return redirect('admin/resources/create');
        } else {
            return response()->json(['success' => 'success']);
        }
    }

    public function edit(Resource $resource)
    {
        $this->authorize('update', $resource);
    }

    public function update(Request $request, Resource $resource)
    {
        $this->authorize('update', $resource);

        $this->validate($request, [
            'title' => 'required',
            'category' => 'required'
        ]);

        $resource->title = $request->title;
        $resource->category_id = $request->category;
        $resource->alt = ($request->alt) ? $request->alt : '';
        $resource->update();

        return response()->json(['success' => 'success']);
    }

    public function destroy(Resource $resource)
    {
        $this->authorize('delete', $resource);

        $success = $resource->delete();
        return response()->json(['success' => $success]);
    }

}
