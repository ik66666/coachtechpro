<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'postcode' => 'required|numeric|digits:7',
            'address' => 'required|string|max:255',
            'building' => 'string|max:255',
        ];
    }

    public function messages()
    {
        return[
            'postcode.required' => '郵便番号を入力してください',
            'postcode.numeric' =>'郵便番号は数字で入力してください',
            'postcode.digits' => '郵便番号は7桁で入力してください',
            'address.required' => '住所を入力してください',
            'address.string' => '住所は文字列型で入力してください',
            'address.max' => '住所は255文字以下で入力してください',
            'building.string' => '建物名は文字列型で入力してください',
            'building.max' => '建物名は255文字以下で入力してください',
        ];
    }
}
