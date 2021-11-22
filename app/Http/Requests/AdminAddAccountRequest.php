<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AdminAddAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(Auth::guard('admin')->check()){
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
            'accNo' => 'required|string|digits:6|unique:accounts,accNo',
            'branch' => 'required|numeric|integer',
            'balance' => 'required|numeric|integer',
            'type' => 'required|numeric|integer',
            'pin' => 'required|string|digits:4',
            'currency' => 'required|numeric|integer'
        ];
    }
}
