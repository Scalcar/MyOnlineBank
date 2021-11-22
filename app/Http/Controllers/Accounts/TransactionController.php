<?php

namespace App\Http\Controllers\Accounts;

use App\General\Concretes\Repositories\AccountRepository;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    private $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function transactionsView(Request $request)
    {
        $transactions = Transaction::where('account_id',$request->get('account'))->orderBy('updated_at','desc')->paginate(7, ['*'],'page');
        $account = $this->accountRepository->getById($request->get('account'));
        
        return view('user.tables.transactions',[
            'user' => Auth::user(),
            'transactions' => $transactions,
            'account' => $account,
        ]);
    }
}
