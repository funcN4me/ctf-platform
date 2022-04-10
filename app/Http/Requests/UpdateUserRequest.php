<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function messages()
    {
        return [
            'required' => 'Поле :attribute обязательно для заполнения',
            'string' => 'В поле :attribute должны содержаться строчные символы',
            'max' => 'Поле :attribute не должно превышать :max символов',
            'email' => 'Поле :attribute должно содержать адрес электронной почты',
            'min' => 'Поле :attribute не должно содержать меньше :min символов',
            'regex' => 'В поле :attribute содержатся недопустимые символы',
        ];
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'group' => ['required', 'string', 'max:30', 'regex:/^[а-яА-ЯЙйЁё\-\s\d]+$/u'],
        ];
    }
}
