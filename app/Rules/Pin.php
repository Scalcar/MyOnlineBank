<?php

namespace App\Rules;

use App\Models\Account;
use Illuminate\Contracts\Validation\Rule;

class Pin implements Rule
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
        $account = Account::where('id',request()->post('account_id'))->get();
            
        if(!empty($account) && ($value !== $account[0]['pin']))
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
        return 'The :attribute is incorrect. Please try again!';
    }
}
