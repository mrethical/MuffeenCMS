<?php

namespace App\Http\Requests;

use App\Models\PostsTag;
use Illuminate\Foundation\Http\FormRequest;
use Auth;

class PostsTagRequest extends FormRequest
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
                return Auth::user()->can('create', PostsTag::class);
            }
            case 'PUT':
            case 'PATCH':
            {
                return Auth::user()->can('update', $this->tag);
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
                return [
                    'name' => 'required|unique:posts_tags|max:255',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => 'required|unique:posts_tags,name,' . $this->tag->id . '|max:255',
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
