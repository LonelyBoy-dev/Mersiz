<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriesProductCreateRequest extends FormRequest
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
            'title' => 'required|min:3',
            'slug' => 'unique:categories',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'لطفا عنوان دسته بندی را وارد کنید',
            'title.min' => 'عنوان دسته بندی شما باید بیش از 3 کاراکتر باشد',
            'slug.unique' => 'این نامک قبلا ثبت شده است',
        ];
    }
}
