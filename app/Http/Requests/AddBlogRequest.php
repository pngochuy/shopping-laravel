<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AddBlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {

        /** 
         * By default it returns false, change it to 
         * something like this if u are checking authentication
         */

        // return false;
        // return true;
        return Auth::check(); // <-------

        /** 
         * You could also use something more granular, like
         * a policy rule or an admin validation like this:
         * return auth()->user()->isAdmin();
         * 
         * Or just return true if you handle the authorisation
         * anywhere else:
         * return true;
         */
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "blogTitle" => ["required"],
            "blogImage" => ["image", "required"],
            "blogDescription" => ["required"],
            "blogContent" => ["required"],

        ];
    }
}
