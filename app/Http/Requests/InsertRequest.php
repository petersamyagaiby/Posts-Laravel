<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InsertRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "title" => [
                "required",
                "min:3",
                "max:255",
                Rule::unique("posts", "title")
            ],
            "description" => [
                "required",
                "min:10",
                "max:255",
            ],
            "user_id" => ["required", "exists:users,id"],
            "image" => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
    }

    public function messages(): array
    {
        return [
            "title.required" => "Title is required",
            "title.min" => "Title must be at least 3 characters",
            "title.max" => "Title must be at most 255 characters",
            "title.unique" => "Title must be unique",
            "description.required" => "Description is required",
            "description.min" => "Description must be at least 10 characters",
            "description.max" => "Description must be at most 255 characters",
            "user_id.required" => "Posted By is required",
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg.',
            'image.max' => 'The image may not be greater than 2MB.',
        ];
    }
}
