<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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

    public function attributes() {

        return [
            'name' => 'ФИО',
            'email' => 'Email адрес',
            'group' => 'Номер группы',
            'password' => 'Пароль'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Поле :attribute обязательно для заполнения',
            'string' => 'В поле :attribute должны содержаться строчные символы',
            'max' => 'Поле :attribute не должно превышать :max символов',
            'email' => 'Поле :attribute должно содержать адрес электронной почты',
            'email.unique' => 'Данный :attribute уже существует',
            'min' => 'Поле :attribute не должно содержать меньше :min символов',
            'password.confirmed' => 'Пароли не совпадают',
            'regex' => 'В поле :attribute содержатся недопустимые символы',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'group' => ['required', 'string', 'max:10', 'regex:/^[а-яА-ЯЙйЁё\-\s\d]+$/u'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
