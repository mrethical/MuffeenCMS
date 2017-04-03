<?php

namespace App\Http\Requests;

use App\Models\Resource;
use Illuminate\Foundation\Http\FormRequest;

class UploadFile extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('create', Resource::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
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
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'file.mimes' => 'Invalid filetype.',
        ];
    }
}
