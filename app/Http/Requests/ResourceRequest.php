<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Resource;
use Auth;

class ResourceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        switch($this->method())
        {
            case 'POST':
            {
                return Auth::user()->can('create', Resource::class);
            }
            case 'PUT':
            case 'PATCH':
            {
                return Auth::user()->can('update', $this->resource);
            }
            default:break;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch($this->method())
        {
            case 'POST':
            {
                $validation = [
                    'file' => 'required|max:5120|' .
                        'mimes:' .
                            'txt,' . // text
                            'jpg,jpeg,png,,' . // images
                            'pdf,doc,docx,ppt,pptx,pps,ppsx,xls,xlsx,' . // documents
                            'mp3,m4a,ogg,wav,' . // audio
                            'mp4,m4v,mov,wmv,avi,mpg,ogv,3gp,3g2,' . // videos
                            'zip' . // compressed
                        ''
                ];
                if ($this->category) $validation['category'] = 'exists:resources_categories,id';
                return $validation;
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'title' => 'required|max:255',
                ];
            }
            default:break;
        }
    }

    // OPTIONAL OVERRIDE
    public function forbiddenResponse()
    {
        // Optionally, send a custom response on authorize failure
        // (default is to just redirect to initial page with errors)
        //
        // Can return a response, a view, a redirect, or whatever else
        return response()->json('Sorry, you are not authorized to do this action.')->setStatusCode(403);
    }
}
