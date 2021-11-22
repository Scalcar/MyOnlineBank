<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserRegRequest extends FormRequest
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
            'fname' => 'required|string|alpha',
            'lname' => 'required|string|alpha',
            'gender' => 'required|numeric|integer',
            'dob' => 'required|date',
            'cnp' => 'required|digits:13|unique:users,cnp',
            'email' => 'required|email|string|unique:users,email',
            'phone' => 'sometimes|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:9|nullable',
            'address' => 'required|regex:/([- ,\/0-9a-zA-Z]+)/',
            'password' => 'required|min:6|max:21|string',
            'username' => 'required|string|alpha_dash|max:21',
            'cpassword' => 'required|min:6|max:21|same:password'
        ];
    }

    public function messages()
    {
        return [
            'fname.required' => 'The first name field is required.',
            'fname.alpha' => 'The first name must only contain letters.',
            'lname.required' => 'The last name field is required.',
            'lname.alpha' => 'The last name must only contain letters.',
            'cpassword.required' => 'The confirm password field is required.',
            'cpassword.same' => 'The two passwords must match.',
            'cpassword.min' => 'The confirm password must be at least 6 characters.',
            'cpassword.max' => 'The confirm password must not be greater than 21 characters.'
        ];
    }
}
