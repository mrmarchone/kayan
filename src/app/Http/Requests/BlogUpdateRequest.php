<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;

class BlogUpdateRequest extends FormRequest
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
        $postId = Post::findOrFailByHashId($this->route('blog'))->id;
        return [
            'title' => 'required|unique:posts,title,' . $postId,
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'type' => 'required|in:free,paid'
        ];
    }
}
