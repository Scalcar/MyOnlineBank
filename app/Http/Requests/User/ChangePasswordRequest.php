<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ChangePasswordRequest extends FormRequest
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
            'opassword' => 'required|string|min:6|max:21|current_password:web',
            'password' => 'required|min:6|max:21|string|',
            'cpassword' => 'required|min:6|max:21|same:password'            
        ];
    }

    public function messages()
    {
        return [
            'opassword.required' => 'The old password field is required',
            'opassword.min' => 'The old password must be at least 6 characters.',
            'opassword.max' => 'The old password must not be greater than 21 characters.',
            'cpassword.required' => 'The confirm password field is required.',
            'cpassword.same' => 'The two new passwords must match.',
            'cpassword.min' => 'The confirm password must be at least 6 characters.',
            'cpassword.max' => 'The confirm password must not be greater than 21 characters.'
        ];
    }
}
