<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(Auth::check()){
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
        return [
            'searchForm' => 'required|string|min:2',
            'searchSelect' => 'required|numeric|integer'
        ];
    }

    public function messages()
    {
        return [
            'searchForm.required' => 'The search bar is empty.',
            'searchForm.min' => 'The search must be at least 2 characters.',
            'searchSelect.numeric' => 'You must choose what to search by.'
        ];
    }
}
