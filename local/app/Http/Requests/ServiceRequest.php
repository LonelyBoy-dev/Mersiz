<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
            'title' => 'required|min:3',
            'slug' => 'required|min:3|unique:posts',
            'shortContent' => 'required|min:3',
            'content' => 'required|min:3',
            'seoTitle' => 'required|min:3',
            'image' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'title.required'   => 'وارد کردن عنوان الزامی می باشد.',
            'title.min'   => 'حداقل عنوان 3 کاراکتر می باشد',
            'slug.min'   => 'حداقل نامک 3 کاراکتر می باشد',
            'slug.required'   => 'وارد کردن نامک الزامی می باشد.',
            'slug.unique'   => 'نامک از قبل وجود دارد',
            'shortContent.required'   => 'وارد کردن خلاصه الزامی می باشد.',
            'shortContent.min'   => 'حداقل خلاصه 3 کاراکتر می باشد',
            'content.required'   => 'وارد کردن توضیحات الزامی می باشد.',
            'content.min'   => 'حداقل توضیحات 3 کاراکتر می باشد',
            'seoTitle.required'   => 'وارد کردن عنوان سئو الزامی می باشد.',
            'seoTitle.min'   => 'حداقل عنوان سئو 3 کاراکتر می باشد',
            'image.required'   => 'یک تصویر شاخص انتخاب کنید',
        ];
    }
}
