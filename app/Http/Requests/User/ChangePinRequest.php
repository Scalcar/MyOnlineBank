<?php

namespace App\Http\Requests\User;

use App\Rules\Pin;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ChangePinRequest extends FormRequest
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
            'npin' => 'required|string|digits:4',
            'cpin' => 'required|string|digits:4|same:npin',
            'pin' => [
                'required',
                'string',
                'digits:4',
                new Pin
            ],
        ];
    }

    public function messages()
    {
        return [
          'npin.required' => 'The new pin field is required.',
          'npin.digits' => 'The new pin must be 4 digits.', 
          'pin.required' => 'The old pin field is required.',
          'pin.digits' => 'The old pin must be 4 digits.',
          'cpin.required' => 'The confirm pin field is required.',
          'cpin.digits' => 'The confirm pin must be 4 digits.',
          'cpin.same' => 'The confirm pin and the new pin must match.', 
        ];
    }
}
