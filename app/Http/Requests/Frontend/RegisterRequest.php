<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            "name" => ["required", "unique:users,name"],
            "email" => ["required", "unique:users,email"],
            "password" => ["required"],
            "avatar" => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            "phone" => ["required", "numeric"],

        
        ];
    }


    /**
     * table: Tên của bảng bạn đang kiểm tra sự duy nhất.
     * column: Tên của cột bạn đang kiểm tra sự duy nhất.
     * except: ID của bản ghi bạn muốn loại trừ khỏi quy tắc kiểm tra sự duy nhất. (Tuỳ chọn)
     * id: Tên trường khóa chính của bảng (mặc định là "id"). (Tuỳ chọn)
     *
     */
    // public function messages()
    // {
    //     return [
    //         'email.unique' => 'Email is already registered!',
    //     ];
    // }
}
