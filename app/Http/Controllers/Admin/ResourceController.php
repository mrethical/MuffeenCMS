<?php

namespace App\Http\Controllers\Admin;

use App\Models\Repositories\ResourcesRepositoryInterface;
use App\Models\Repositories\ResourcesCategoriesRepositoryInterface;
use App\Models\Resource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResourceRequest;
use Auth;
use File;
use ErrorException;
use Storage;


class ResourceController extends Controller
{

    /**
     * @var ResourceRepositoryInterface
     */
    private $_resources;

    /**
     * @var ResourcesCategoriesRepositoryInterface
     */
    private $_resources_categories;

    private $_uploads_locations = [];

    public function __construct(
        ResourcesRepositoryInterface $resources,
        ResourcesCategoriesRepositoryInterface $resources_categories
    ) {
        $this->_resources = $resources;
        $this->_resources_categories = $resources_categories;
        $this->_uploads_locations = Resource::getUploadLocations();
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
        if (Auth::user()->can('view_all', Resource::class)) {
            $limit = $request->input('limit', 10);
            $offset = $request->input('offset', 0);
            $resources = $this->_resources->getAllWithLimit($limit, $offset);
            $categories = $this->_resources_categories->getPairAll();
            $count = $this->_resources->getCountAll();
            $locations = Resource::getUrlLocations();
            if ($output === 'page') {
                return view('admin.resources.index', compact('resources', 'count', 'locations', 'categories'));
            } else if ($output === 'table') {
                return view('admin.resources.tables.resources-table', compact('resources', 'count', 'locations', 'categories'));
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
                    'admin.resources.tables.resources-table',
                    compact('users', 'count'))->setStatusCode(403);
            } else {
                return response('', 403);
            }
        }
    }

    private function _prepare_directories()
    {
        $upload = $this->_uploads_locations['upload'];
        $upload_images_small = $this->_uploads_locations['upload_images_small'];
        $upload_images_medium = $this->_uploads_locations['upload_images_medium'];
        try {
            if (!File::exists($upload)) {
                File::makeDirectory($upload, $mode = 0755, $recursive = true, $force = false);
            }
            if (!File::exists($upload_images_small)) {
                File::makeDirectory($upload_images_small, $mode = 0755, $recursive = true, $force = false);
            }
            if (!File::exists($upload_images_medium)) {
                File::makeDirectory($upload_images_medium, $mode = 0755, $recursive = true, $force = false);
            }
        } catch (ErrorException $ee) {
            return false;
        }
        return true;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->can('create', Resource::class)) {
            $categories = $this->_resources_categories->getAll();
            $added = request()->session()->get('added', null);
            return view('admin.resources.create', compact('categories', 'added'));
        } else {
            return response()->view('errors.admin-403')->setStatusCode(403);
        }
    }
    
    private function _isImage(Resource $resource)
    {
        return in_array($resource->ext, ['jpg', 'jpeg', 'png', 'gif']);
    }

    private function _createDuplicate($filename) 
    {
        $target_path = $this->_uploads_locations['upload'] . '/' . $filename;
        $small = $this->_uploads_locations['upload_images_small'] . '/' . $filename;
        $medium = $this->_uploads_locations['upload_images_medium'] . '/' . $filename;
        list($width,$height) = getimagesize($target_path);
        $small_ratio = 240/$width;
        $small_width = 240;
        $small_height = $height * $small_ratio;
        $medium_ratio = 720/$width;
        $medium_width = 720;
        $medium_height = $height * $medium_ratio;
        $small_create = imagecreatetruecolor($small_width,$small_height);
        $medium_create = imagecreatetruecolor($medium_width,$medium_height);
        $filename_err = explode(".", $target_path);
        $filename_err_count = count($filename_err);
        $file_ext = $filename_err[$filename_err_count-1];
        switch($file_ext){
            case 'jpg' || 'jpeg':
                $small_source = imagecreatefromjpeg($target_path);
                break;
            case 'png':
                $small_source = imagecreatefrompng($target_path);
                break;
            case 'gif':
                $small_source = imagecreatefromgif($target_path);
                break;
            default:
                $small_source = imagecreatefromjpeg($target_path);
        }
        $medium_source = $small_source;
        imagecopyresampled($small_create, $small_source, 0, 0, 0, 0, $small_width, $small_height, $width, $height);
        imagecopyresampled($medium_create, $medium_source, 0, 0, 0, 0, $medium_width, $medium_height, $width, $height);
        switch($file_ext){
            case 'jpg' || 'jpeg':
                imagejpeg($small_create, $small, 80);
                imagejpeg($medium_create, $medium, 80);
                break;
            case 'png':
                imagepng($small_create, $small, 80);
                imagepng($medium_create, $medium, 80);
                break;
            case 'gif':
                imagegif($small_create, $small, 80);
                imagegif($medium_create, $medium, 80);
                break;
            default:
                imagejpeg($small_create, $small, 80);
                imagejpeg($medium_create, $medium, 80);
        }
        return TRUE;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ResourceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResourceRequest $request)
    {
        if ($this->_prepare_directories()) {
            $file = $request->file;
            $resource = new Resource();
            $resource->name = $file->getClientOriginalName();
            $resource->category_id = ($request->category) ? $request->category : null;
            $resource->title = $file->getClientOriginalName();
            $resource->alt = '';
            $resource->size = $file->getClientSize();
            $resource->ext = strtolower($file->guessClientExtension());
            $resource->uploaded_by = Auth::user()->id;
            $same_file = 0;
            while (File::exists($this->_uploads_locations['upload'] . '/' . $resource->name)) {
                $resource->name = ++$same_file . $file->getClientOriginalName();
            }
            $file->move($this->_uploads_locations['upload'], $resource->name);
            if ($this->_isImage($resource)) {
                $this->_createDuplicate($resource->name);
            }
            $resource->save();
            if ($request->submit) {
                $request->session()->flash('added', true);
                return redirect('admin/resources/create');
            }
        } else {
            return response()->json(['error' => ['Unable to create upload directory']])->setStatusCode(500);
        }
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
     * @param  \App\Http\Requests\ResourceRequest  $request
     * @param  \App\Models\Resource $resource
     * @return \Illuminate\Http\Response
     */
    public function update(ResourceRequest $request, Resource $resource)
    {
        $resource->title = $request->title;
        $resource->category_id = ($request->category_id) ? $request->category_id : null;
        $resource->alt = $request->alt;
        $success = $resource->update();
        return response()->json(['success' => $success]);
    }

    private function _deleteUpload(Resource $resource)
    {
        $filename = $resource->name;
        $files = array();
        $files[] = $this->_uploads_locations['upload'] . '/' . $filename;
        if ($this->_isImage($resource)) {
            $files[] = $this->_uploads_locations['upload_images_small'] . '/' . $filename;
            $files[] = $this->_uploads_locations['upload_images_medium'] . '/' . $filename;
        }
        File::delete($files);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Resource $resource
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resource $resource)
    {
        if (Auth::user()->can('delete', $resource)) {
            $success = Resource::destroy($resource->id);
            $this->_deleteUpload($resource);
            return response()->json(['success' => $success]);
        } else {
            return response()->json('Sorry, you are not authorized to do this action.')->setStatusCode(403);
        }
    }
}
