<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EditPersonalDataRequest extends FormRequest
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
            'fname' => 'required|string|alpha',
            'phone' => 'sometimes|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:9|nullable',
            'address' => 'required|regex:/([- ,\/0-9a-zA-Z]+)/',
            'username' => 'required|string|alpha_dash|max:21',
            'email' => [
                'required',
                'string',
                'email',
                Rule::unique('users')->ignore($this->modelId),            
            ],
        ];
    }

    public function messages()
    {
        return [
            'fname.required' => 'The first name field is required.',
            'fname.alpha' => 'The first name must only contain letters.',
        ];
    }
}
