<?php

namespace App\Http\Controllers;

use App\General\Concretes\Enums\AccountCurrency;
use App\General\Concretes\Enums\AccountStatuses;
use App\General\Concretes\Repositories\AccountRepository;
use App\General\Concretes\Repositories\AdminRepository;
use App\General\Concretes\Repositories\TransactionRepository;
use App\General\Concretes\Repositories\UserRepository;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Arr;

class DashboardAdminController extends Controller
{
    private $adminRepository;
    private $userRepository;
    private $accountRepository;
    private $transactionRepository;

    public function __construct(AdminRepository $adminRepository, UserRepository $userRepository, AccountRepository $accountRepository, TransactionRepository $transactionRepository)
    {
        $this->adminRepository = $adminRepository;
        $this->userRepository = $userRepository;
        $this->accountRepository = $accountRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function index()
    {
        $admins = $this->adminRepository->getAll();
        $users = $this->userRepository->getAll();
        $accounts = $this->accountRepository->getAll();
        $transactions = $this->transactionRepository->getAll();
        $lastTransactions = Transaction::orderBy('created_at','desc')->paginate(5);

        $bankBalance = $this->bankBalance();

        return view('admin.dashboard',[
            'admins' => $admins,
            'users' => $users,
            'accounts' => $accounts,
            'transactions' => $transactions,
            'lastTransactions' => $lastTransactions,
            'bankBalance' => $bankBalance,
        ]);
    }

    public function bankBalance()
    {
        $accounts = Account::whereHas('status', function($q) {
            return $q->where('status',AccountStatuses::ACTIVE_STATUS_ID);
        })->get();
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
        
        $bankTotal = array_sum($total);
        
        return $bankTotal;
    }
}
