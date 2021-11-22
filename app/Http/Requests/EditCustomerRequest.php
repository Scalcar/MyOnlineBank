<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EditCustomerRequest extends FormRequest
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
            'username' => 'required|string|alpha_dash|max:21',
            'phone' => 'sometimes|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:9|nullable',
            'address' => 'required|regex:/([- ,\/0-9a-zA-Z]+)/',
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique('users')->ignore($this->modelId),            
            ],
            'cnp' => [
                'required',
                'digits:13',
                Rule::unique('users')->ignore($this->modelId),
            ],
        ];
    }

    public function messages()
    {
        return [
            'fname.required' => 'The first name field is required.',
            'fname.alpha' => 'The first name must only contain letters.', 
            'lname.required' => 'The last name field is required.',
            'lname.alpha' => 'The last name must only contain letters.',           
        ];
    }
}
