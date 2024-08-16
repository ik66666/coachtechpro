<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:100|max:999999',
            'description' => 'required|string|max:500',
            'image_url' => 'required|image|mimes:jpeg,png,jpg',
        ];
    }

    public function messages()
    {
        return [
        'name.required' => '商品名を入力してください',
        'name.string' => '商品名は文字列型で入力してください',
        'name.max' => '商品名は255文字以下で入力してください',
        'price.required' => '販売価格を入力してください',
        'price.integer' => '販売価格は数字で入力してください',
        'price.min' => '販売価格は100円以上で設定してください',
        'price.max' => '販売価格は999999円以下で設定してください',
        'description.required' => '商品説明を入力してください',
        'description.string' => '商品説明は文字列型で入力してください',
        'description.max' => '商品説明は500文字以下で入力してください',
        'image_url.required' => '画像を選択してください',
        'image_url.image' => '画像形式で入力してください',
        'image_url.mimes' => '画像はjpeg,png,jpgのいずれかのファイルのみ選択可能です',
        ];
    }
}
