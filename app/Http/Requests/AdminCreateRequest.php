<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AdminCreateRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email|string|unique:admins,email',
            'password' => 'required|min:6|max:21|string',
            'cpassword' => 'required|min:6|max:21|same:password',
        ];
    }

    public function messages()
    {
        return [
            'cpassword.required' => 'The confirm password field is required.',
            'cpassword.same' => 'The two passwords must match.',
            'cpassword.min' => 'The confirm password must be at least 6 characters.',
            'cpassword.max' => 'The confirm password must not be greater than 21 characters.'
        ];
    }
}
