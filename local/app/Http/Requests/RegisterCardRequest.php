<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterCardRequest extends FormRequest
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
            "name"  => "required|string|max:50|min:6",
            "address"  => "required|min:20",
            'mellicode' => 'required|numeric|max:10|min:10',
            'mellicode' => 'max:10|min:10',
            'bank' => 'required',
            'cardnumber' => 'required|numeric|max:16|min:16',
            'cardnumber' => 'max:16|min:16',
        ];
    }

    public function messages()
    {
        return[
            'name.required'=>'نام و نام خانوادگی را وارد کنید',
            'address.required'=>'آدرس پستی را وارد کنید',
            'name.min'=>'نام و نام خانوادگی باید حداقل 6 کاراکتر باشد',
            'address.min'=>'آدرس پستی باید حداقل 20 کاراکتر باشد',
            'name.max'=>'نام و نام خانوادگی باید حداکثر 50 کاراکتر باشد',
            'name.string'=>'نام و نام خانوادگی باید شامل حروف باشد',
            'mellicode.required'=>'کد ملی را وارد کنید',
            'mellicode.min'=>'کد ملی باید حداقل 10 رقم باشد',
            'mellicode.max'=>'کد ملی باید حداکثر 10 رقم باشد',
            'mellicode.numeric'=>'کد ملی باید شامل عدد باشد',
            'bank.required'=>'بانک مورد نظر خود را انتخاب کنید',
            'cardnumber.required'=>'شماره کارت را وارد کنید',
            'cardnumber.min'=>'شماره کارت باید حداقل 16 رقم باشد',
            'cardnumber.max'=>'شماره کارت باید حداکثر 16 رقم باشد',
            'cardnumber.numeric'=>'شماره کارت باید شامل عدد باشد',
        ];
    }



}
