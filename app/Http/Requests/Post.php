<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Post extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "title"=>"required|min:10",
            "thumbnail"=>"required|mimes:jpg,jpeg,png",
            "photos"=>"required|array|min:2",
            "summernote"=>"required",
            "idHashtag"=>"nullable|exists:hashtag"
        ];
    }
}
