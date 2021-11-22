<?php

namespace App\Http\Requests\User;

use App\Rules\TransferBetweenAccounts;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TransferBetweenAccountsRequest extends FormRequest
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
            'from_account' => ['required','numeric','integer'],
            'to_account' => 'required|numeric|integer|different:from_account',
            'amount' => ['required','numeric', 'min:1','max:999999999.999', 'regex:/^\d+(\.\d{1,3})?$/', new TransferBetweenAccounts],
        ];
    }

    public function messages()
    {
        return [
            'from_account.numeric' => 'You must choose an account to transfer from',
            'to_account.numeric' => 'You must choose an account to transfer to',
            'to_account.different' => 'You must send to a different account.',
            'amount.regex' => 'You can have only three decimals.'
        ];
    }
}
