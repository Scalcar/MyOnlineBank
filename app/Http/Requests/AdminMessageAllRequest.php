<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AdminMessageAllRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(Auth::guard('admin')->check()){
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
            'subject' => 'required|string|min:3',
            'body' => 'required|string|min:10',
        ];
    }

    public function messages()
    {
        return [
            'body.required' => 'The message field is required.',
            'body.min' => 'The message must be at least 10 characters.',
        ];
    }
}
