<?php

namespace App\Http\Requests\User;

use App\Models\Account;
use App\Rules\AtmPin;
use App\Rules\Transfer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ExternalTransferRequest extends FormRequest
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
            'amount' => ['required','numeric', 'min:1','max:999999999.999', 'regex:/^\d+(\.\d{1,3})?$/', new Transfer],
            'details' => 'required|string',
            'pin' => ['required','string','digits:4', new AtmPin],
            'to_account' => [
                'required',
                'digits_between:6,8',
                'string',
                Rule::notIn(Account::pluck('accNo')),
            ],
        ];
    }

    public function messages()
    {
        return [
            'from_account.required' => 'The account to transfer from is required',
            'from_account.numeric' => 'You must choose an account to transfer from',
            'to_account.required' => 'The account number to transfer To is required.',
            'to_account.digits_between' => 'The account number must be between 6 and 8 digits.',
            'amount.regex' => 'You can only have three decimals.',
            'to_account.not_in' => "That's an internal account. Try again!",
        ];
    }
}
