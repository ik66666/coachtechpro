<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MailRequest extends FormRequest
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
            'message' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'message.required' => 'メッセージを入力してください',
            'message.string' => 'メッセージは文字列型で入力してください',
            'message.max' => 'メッセージはは255文字以下で入力してください',
        ];
    }
}
