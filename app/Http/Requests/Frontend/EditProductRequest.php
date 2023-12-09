<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class EditProductRequest extends FormRequest
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
        // name, price, detail, image (tối đa 3 ảnh), category_id, brand_id, user_id, status, sale_price, company_profile
        return [
            'name' => ['required'],
            'price' => ['required'],
            'image.*' => ['image', 'max:1024'], // Mỗi ảnh có dung lượng không quá 1MB
            'image' => ['array', 'max:3'], // Tối đa 3 ảnh được chọn
            'category_id' => ['required'],
            'brand_id' => ['required'],
            // 'user_id' => ['required'],
            'status' => ['required'],
            // 'sale_price' => ['']
            'company_profile' => ['required'],
            'detail' => ['required'],
        ];
    }
}
