<?php

namespace App\Rules;

use App\Models\Account;
use Illuminate\Contracts\Validation\Rule;

class TransferBetweenAccounts implements Rule
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
        if((request()->post('from_account') !== 'Choose account :')){
            $accountFrom = Account::where('id',request()->post('from_account'))->get();
        }
                
        if(!empty($accountFrom))
        {                                        
            if($accountFrom[0]['balance'] >= $value){                     
                return true;
            }

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
        return "You don't have enough funds.";
    }
}
