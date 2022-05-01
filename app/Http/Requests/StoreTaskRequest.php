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
            'array' => 'Данные в поле :attribute неверные',
        ];
    }

    public function attributes()
    {
        return [
            'flag' => 'Флаг',
            'url' => 'Ссылка на задачу'
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
            'name' => 'required|string|max:255|min:3|unique:mysql.tasks,name',
            'category' => 'required',
            'new_category' => 'nullable|unique:mysql.categories,name',
            'subcategory' => 'required|string|max:255|min:2',
            'flag' => 'unique:mysql.tasks,flag|required|string|min:8|max:255',
            'resources' => 'nullable|array',
            'resources.*' => 'exists:mysql.resources,id',
            'new_resources' => 'nullable|array',
            'attachments' => 'nullable|array',
            'description' => 'required|string|min:2',
        ];
    }
}
