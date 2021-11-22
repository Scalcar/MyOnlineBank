<?php

namespace App\Http\Requests\User;

use App\Models\Account;
use App\Rules\AtmPin;
use App\Rules\Transfer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class InternalTransferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(Auth::check()) {
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
            'from_account' => ['required','numeric','integer'],
            'pin' => ['required','string','digits:4', new AtmPin],
            'amount' => ['required','numeric', 'min:1','max:999999999.999', 'regex:/^\d+(\.\d{1,3})?$/', new Transfer],
            'to_account' => [
                'required',
                'numeric',
                'integer',
                Rule::notIn(Account::where('user_id', Auth::user()->id)->pluck('id')),
            ],
        ];
    }

    public function messages()
    {
        return [
            'from_account.required' => 'The account to transfer from is required',
            'from_account.numeric' => 'You must choose an account to transfer from',
            'to_account.required' => 'The account to transfer to is required',
            'to_account.numeric' => 'You must choose a contact to transfer to',
            'to_account.not_in' => "That's your account. Use transfer between accounts instead.",
            'amount.regex' => 'You can only have three decimals.',          
        ];
    }
}
