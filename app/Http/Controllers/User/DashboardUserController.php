<?php

namespace App\Http\Controllers\User;

use App\General\Concretes\Enums\AccountCurrency;
use App\General\Concretes\Enums\AccountStatuses;
use App\General\Concretes\Enums\MessageStatus;
use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class DashboardUserController extends Controller
{
    public function index()
    {
        $accounts = Account::whereHas('status', function($q) {
            return $q->where('status',AccountStatuses::ACTIVE_STATUS_ID)->orWhere(function ($q2) {
                return $q2->where('status',AccountStatuses::FOR_CLOSE_STATUS_ID)->where('expires',null)->orWhere('expires','>=',Carbon::now());
            });
        })->where('user_id', Auth::user()->id)->paginate(1, ['*'],'account');

        $messages = Message::where(function($q) {
            return $q->where('sender_id', Auth::user()->id)->where('sender_status',MessageStatus::ACTIVE_STATUS_ID);
        })->orWhere(function($q2) {
            return $q2->where('sent_to_id', Auth::user()->id)->where('receiver_status',MessageStatus::ACTIVE_STATUS_ID);
        })->orderBy('created_at','desc')->paginate(5,['*'],'list');

        $contacts = Contact::where('list_id', Auth::user()->id)->paginate(1,['*'],'list');
        $balance = $this->currentBalance();

        return view('user.dashboard',[
            'accounts' => $accounts,
            'messages' => $messages,
            'contacts' => $contacts,
            'balance' => $balance,
        ]);
    }

    public function currentBalance()
    {
        $accounts = Account::whereHas('status', function($q) {
            return $q->where('status',AccountStatuses::ACTIVE_STATUS_ID)->orWhere(function ($q2) {
                return $q2->where('status',AccountStatuses::FOR_CLOSE_STATUS_ID)->where('expires',null)->orWhere('expires','>=',Carbon::now());
            });
        })->where('user_id', Auth::user()->id)->get();
        $currencyCategories = [];
        $currencyCategories = $accounts->groupBy('currency');
        $balanceCategories = [];

        foreach($currencyCategories as $key => $value)
        {           
            $balanceCategories[AccountCurrency::getValueById($key)] = array_sum(Arr::pluck($value,'balance'));          
        }
       
        $total = [];

        foreach($balanceCategories as $key => $value)
        {
            if($key === 'RON'){
                $total[] = $value;
            }

            if($key === 'USD'){
                $total [] = $value * 4; 
            }

            if($key === 'EUR'){
                $total[] = $value * 4.5;
            }

            if($key === 'GBP'){
                $total[] = $value * 5;
            }
        }
        
        $AccTotal = array_sum($total);
        
        return $AccTotal;
    }
}
