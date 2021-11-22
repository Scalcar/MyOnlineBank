<?php

namespace App\Rules;

use App\Models\Account;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class ContactCheck implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $user = User::where('email',$value)->first();
        $account = Account::where('accNo',request()->post('accNo'))->first();
                  
        if(!empty($user) && !empty($account) && ($user->id !== $account->user_id))
        {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute and the account number do not match.';
    }
}
