<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if($this->input('slug')){
            $this->merge(['slug' => make_slug($this->input('slug'))]);
        }else{
            $this->merge(['slug' => make_slug($this->input('title'))]);
        }
    }

    public function rules()
    {
        return [
            'title' => 'required|min:10',
            'slug' => 'unique:products',
            'checkbox' => 'required',
            'image' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'لطفا عنوان محصول را وارد کنید',
            'title.min' => 'عنوان محصول شما باید بیش از ۱۰ کاراکتر باشد',
            'content.min' => 'توضیحات محصول شما باید بیش از 50 کاراکتر باشد',
            'shortContent.min' => 'خلاصه محصول شما باید بیش از 50 کاراکتر باشد',
            'slug.unique' => 'این نامک قبلا ثبت شده است',
            'content.required' => 'لطفا توضیحات محصول را وارد کنید',
            'shortContent.required' => 'لطفا خلاصه محصول را وارد کنید',
            'checkbox.required' => 'لطفا دسته بندی این محصول را انتخاب کنید',
            'image.required' => 'برای محصول خود یک تصویر شاخص انتخاب کنید'
        ];
    }

}
