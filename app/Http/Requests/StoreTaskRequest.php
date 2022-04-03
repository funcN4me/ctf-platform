<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::user()->isAdmin()) {
            return true;
        }

        return false;
    }

    public function messages()
    {
        return [
            'required' => 'Поле :attribute обязательно для заполнения',
            'string' => 'Поле :attribute должно быть строковым значением',
            'max' => 'Поле :attribute должно содержать максимум :max символов',
            'min' => 'Поле :attribute должно содержать минимум :min символов',
            'unique' => 'Данное :attribute уже используется',
            'in' => 'Выберите из списка',
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
            'name' => 'required|string|max:255|min:3|unique:tasks,name',
            'category' => 'required|in:Web,Reverse,Stegano,Forensic,Networking,Other',
            'subcategory' => 'required|string|max:255|min:2',
            'description' => 'required|string|min:2',
            'link' => 'string|unique',
            'flag' => 'required|string|min:8|max:255|unique:tasks,flag',
        ];
    }
}
