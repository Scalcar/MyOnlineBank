<?php

namespace App\Http\Requests\User;

use App\Rules\AtmPin;
use App\Rules\AtmSimulator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AtmSimulatorRequest extends FormRequest
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
            'from_account' => 'required|numeric|integer',
            'atm' => 'required|numeric|integer',
            'pin' => ['required','string','digits:4', new AtmPin],
            'amount' => [
                'required',
                'numeric',
                'min:1',
                'max:999999999.999',
                'regex:/^\d+(\.\d{1,3})?$/',
                new AtmSimulator,
            ]
        ];
    }

    public function messages()
    {
        return [
            'from_account.numeric' => 'You must choose an account first.',
            'amount.regex' => 'You can have only three decimals.',
            'atm.required' => 'Must choose an action.'
        ];
    }
}
