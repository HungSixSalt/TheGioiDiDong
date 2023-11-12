<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SigninRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'form_email'=>['required', 'email'],
            'form_password'=>'required',
        ];
    }
    public function messages()
    {
        return[
            'required'=>':attribute không được để trống',
            'email'=>':attribute phải là email',
        ];
    }
    public function attributes()
    {
        return[
            'form_email'=>'E-mail',
            'form_password'=>'Password',
        ];
    }
}
