<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
                Rule::unique("posts", "title")->ignore($this->post),
            ],
            "description" => [
                "required",
                "min:10",
                "max:255",
            ],
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
            "description.min" => "Description must be at least 3 characters",
            "description.max" => "Description must be at most 255 characters",
        ];
    }
}
