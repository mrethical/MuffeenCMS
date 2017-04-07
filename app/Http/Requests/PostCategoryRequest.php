<?php

namespace App\Http\Requests;

use App\Models\PostCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Factory as ValidationFactory;

class PostCategoryRequest extends FormRequest
{
    public function __construct(ValidationFactory $validationFactory)
    {

        $validationFactory->extend(
            'not_uncategorized',
            function ($attribute, $value, $parameters) {
                return 'uncategorized' !== strtolower($value);
            },
            'Category :attribute already exists.'
        );

    }

    public function authorize()
    {
        switch($this->method())
        {
            case 'POST':
            {
                return auth()->user()->can('create', PostCategory::class);
            }
            case 'PUT':
            case 'PATCH':
            {
                return auth()->user()->can('update', $this->category);
            }
            default:break;
        }
        return false;
    }

    public function rules()
    {
        switch($this->method())
        {
            case 'POST':
            {
                return [
                    'name' => 'required|unique:posts_categories|max:255|not_uncategorized',
                    'slug' => 'required|unique:posts_categories|max:255|not_uncategorized'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => 'required|unique:posts_categories,name,' . $this->category->id .
                        '|max:255|not_uncategorized',
                    'slug' => 'required|unique:posts_categories,slug,' . $this->category->id .
                        '|max:255|not_uncategorized'
                ];
            }
            default:break;
        }
    }

}
