<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MiniproductRequest extends FormRequest
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

    public function rules()
    {
        return [
            'title' => 'required|min:3',
            'description' => 'required|min:30',
            'image' => 'required',
            'link' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'لطفا عنوان محصول را وارد کنید',
            'title.min' => 'عنوان محصول شما باید بیش از 3 کاراکتر باشد',
            'description.min' => 'توضیحات شما باید بیش از 30 کاراکتر باشد',
            'description.required' => 'لطفا توضیحات را وارد کنید',
            'image.required' => 'برای محصول خود یک لوگو انتخاب کنید',
            'link.required' => 'برای محصول خود یک لینک وارد کنید'
        ];
    }
}