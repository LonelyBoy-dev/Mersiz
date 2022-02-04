<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|string|max:255|min:3',
            'reference_code' => 'required|max:255|min:3',
            'up_line_code' => 'required|max:255|min:3',
            'national_code' => 'required|max:10|min:10',
            'mobile' => 'required|max:10|min:10',
            'tel' => 'required|max:10|min:10',
            'postal_code' => 'required|max:10|min:10',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    public function messages()
    {
        return[
            'name.required'=>'نام را وارد کنید',
            'email.required'=>'ایمیل را وارد کنید',
            'email.email'=>'ایمیل نامعتبر است',
            'required.password'=>'پسورد را وارد کنید',
            'password.min'=>'حداقل پسورد 6 کاراکتر است',

        ];
    }
}
