<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
            "name" => "required|min:4|max:20",
            "email" => [
                "required",
                "email",
                Rule::unique("users", "email")->ignore($this->user),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "Name is required",
            "name.min" => "Name must be at least 4 characters",
            "name.max" => "Name must be at most 20 characters",
            "email.required" => "Please enter your email",
            "email.email" => "Invalid email format",
            "email.unique" => "This email already exists",
        ];
    }
}
