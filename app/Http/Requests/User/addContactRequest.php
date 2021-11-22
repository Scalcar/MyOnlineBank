<?php

namespace App\Http\Requests\User;

use App\Models\Account;
use App\Rules\ContactCheck;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class addContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(Auth::check())
        {
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
            'nickname' => 'required|string|max:15',
            'email' => ['required','string','email','exists:users,email', new ContactCheck],
            'accNo' => [
                'required',
                'string',
                'digits:6',
                'exists:accounts,accNo',
                Rule::notIn(Account::where('user_id', Auth::user()->id)->pluck('accNo')),
            ],
        ];
    }

    public function messages()
    {
        return [
            'accNo.required' => 'The account number field is required.',
            'accNo.digits' => 'The account number must be 6 digits.',
            'accNo.exists' => 'The selected account is not in our database.',
            'email.exists' => 'The selected email is not in our database.',
            'accNo.not_in' => "That's your account. Try again!",
        ];
    }
}
