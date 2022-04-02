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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
//        if ($this->input('category') !== '-1') {
        return [
            'name' => ['required', 'string', 'max:255', 'min:3', 'unique:tasks,name'],
            'category' => ['required', 'integer'],
            'subcategory' => ['required', 'string', 'max:255', 'min:2'],
            'description' => ['required', 'string', 'min:2'],
            'link' => ['string'],
            'flag' => ['required', 'string', 'min:8', 'max:255', 'unique:tasks,flag'],
        ];
//        }
//        return [
//            'name' => ['required', 'string', 'max:255', 'min:3', 'unique:tasks,name'],
//            'new-category' => ['required'],
//            'subcategory' => ['required', 'string', 'max:255', 'min:2'],
//            'description' => ['required', 'string', 'min:2'],
//            'link' => ['string'],
//            'flag' => ['required', 'string', 'min:8', 'max:255', 'unique:tasks,flag'],
//        ];
    }
}
