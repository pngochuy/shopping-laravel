<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateProfileRequest extends FormRequest
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
        // câu hình chuỗi Pattern
        return [
            "name" => ["required"],
            "email" => ["required"],
            // "password" => ["required"],
            "avatar" => 'image|mimes:jpeg,png,jpg,gif|max:1024' // size < 1mb, còn < 2mb => 2048
        ];
    }

    // public function messages()
    // {
    //     return [
    //         ""
    //     ];
    // }
}
