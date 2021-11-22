<?php

namespace App\Http\Controllers\Accounts;

use App\General\Concretes\Enums\AccountStatuses;
use App\General\Concretes\Repositories\UserRepository;
use App\General\Concretes\Repositories\AccountRepository;
use App\General\Concretes\Repositories\TransactionRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminAddAccountRequest;
use App\Http\Requests\User\InternalTransferRequest;
use App\Http\Requests\User\AtmSimulatorRequest;
use App\Http\Requests\User\ExternalTransferRequest;
use App\Http\Requests\User\TransferBetweenAccountsRequest;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    private $userRepository;
    private $accountRepository;
    private $transactionRepository;

    public function __construct(AccountRepository $accountRepository, UserRepository $userRepository, TransactionRepository $transactionRepository)
    {
        $this->accountRepository = $accountRepository;           
        $this->userRepository = $userRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function addAccountView(Request $request)
    {
        $random = 0;
        $account = Account::select('accNo')->get();
        $accountNumbers = [];
        foreach($account as $value)
        {
            $accountNumbers[] = (int) $value->accNo;
        }

        $index = 0;

        while(in_array(($random = rand(100000,999999)), $accountNumbers) && $index < 100)
        {
            $index++;
        }

        return view('admin.forms.add_account',[
            'customer' => $this->userRepository->getById($request->get('customer')),
            'random' => $random,
        ]);
    }

    public function verifyAccountView(Request $request)
    {
        return view('admin.forms.verify_account',[
            'account' => $this->accountRepository->getById($request->get('account'))
        ]);
    }

    public function addAccountAdmin(AdminAddAccountRequest $request)
    {
        $account = $this->accountRepository->store($request->all());

        if($account !== null && $account instanceof Account)
        {
            return redirect()->route('admin.show_customer',['customer' => $account->user_id])->with('success','Account added successfully!');
        }
    }

    public function showAccount(Request $request)
    {
        return view('admin.tables.show_account',[
            'account' => $this->accountRepository->getById($request->get('account'))
        ]);
    }

    public function showTransactions(Request $request)
    {
        $account = $this->accountRepository->getById($request->get('account'));
        $transactions = Transaction::where('account_id', $request->get('account'))->orderBy('created_at','desc')->paginate(6,['*'],'list'); 

        return view('admin.tables.show_transactions',[
            'transactions' => $transactions,
            'account' => $account,
        ]);
    }

    private function getAccounts()
    {
        $accounts = Account::whereHas('status', function($q) {
            return $q->where('status',AccountStatuses::ACTIVE_STATUS_ID)->orWhere(function ($q2) {
                return $q2->where('status',AccountStatuses::FOR_CLOSE_STATUS_ID)->where('expires',null)->orWhere('expires','>=',Carbon::now());
            });
        })->where('user_id', Auth::user()->id)->get();
        
        return $accounts;
    }

    public function transferBetweenAccountsView()
    {      
        $accounts = $this->getAccounts();

        return view('user.forms.transferBetweenAccounts',[
            'user' => Auth::user(),
            'accounts' => $accounts,
        ]);
    }

    public function atmSimulatorView()
    {
        $accounts = $this->getAccounts();
        
        return view('user.forms.atmSimulator',[
            'user' => Auth::user(),
            'accounts' => $accounts,
        ]);
    }

    public function externalTransferView()
    {
        $accounts = $this->getAccounts();    

        return view('user.forms.externalTransfer',[
            'user' => Auth::user(),
            'accounts' => $accounts,         
        ]);
    }

    public function internalTransferView()
    {
        $accounts = $this->getAccounts();
        $contacts = Contact::where('list_id',Auth::user()->id)->get();

        return view('user.forms.internalTransfer',[
            'user' => Auth::user(),
            'accounts' => $accounts,
            'contacts' => $contacts,
        ]);
    }

    public function deleteAccount(Request $request)
    {
        $account = $this->accountRepository->delete($request->all());

        if($account !== null && $account instanceof Account)
        {
            return redirect()->route('admin.show_customer',['customer' => $account->user_id])->with('success','Account deleted successfully!');
        }     
    }

    public function verifyAccount(Request $request)
    {
        switch ($request->get('action')) {
            case 'save':
                $account = $this->accountRepository->accept($request->all());
                
                if($account !== null && $account instanceof Account)
                {
                    return redirect()->route('admin.home')->with('success','The account request was accepted successfully!');
                } 

                break;
            case 'delete':
                $account = $this->accountRepository->delete($request->all());

                if(!empty($account))
                {
                    if($account->status->status === 2) {
                        return redirect()->route('admin.home')->with('success','The account was closed successfully!');
                    }else {
                        return redirect()->route('admin.home')->with('success','The account request was denied successfully!');
                    }
                }
               
                break;
        }
      
    }

    public function transferBetweenAccounts(TransferBetweenAccountsRequest $request)
    {
        if($request->validated())
        {
            $a = $this->accountRepository->getById($request->post('from_account'));
            $b = $this->accountRepository->getById($request->post('to_account'));
            
            if($a !== null && $b !== null)
            {
                if($a->currency === $b->currency)
                {
                   $c = $this->accountRepository->update([
                        'modelId' => $request->post('from_account'),
                        'balance' => $a->balance - $request->post('amount'), 
                   ]);
                   
                   $d = $this->accountRepository->update([
                        'modelId' => $request->post('to_account'),
                        'balance' => $b->balance + $request->post('amount'), 
                    ]);

                    if($c !== null && $d !== null)
                    {
                        $transaction1 = $this->transactionRepository->store([
                            'trans_no' => rand(1000000,9999999),
                            'description' => "To: #$b->accNo - Between Accounts Transfer",
                            'account_id' => $request->post('from_account'),
                            'debit' => $request->post('amount'),
                            'balance' => $a->balance - $request->post('amount')
                        ]);
                        
                        $transaction2 = $this->transactionRepository->store([
                            'trans_no' => rand(1000000,9999999),
                            'description' => "From: #$a->accNo - Between Accounts Transfer",
                            'account_id' => $request->post('to_account'),
                            'credit' => $request->post('amount'),
                            'balance' => $b->balance + $request->post('amount'),
                        ]);

                        if($transaction1 !== null && $transaction2 !== null)
                        {
                            return redirect()->route('user.home')->with('success','The transfer between accounts was made successfully!');
                        }
                    }
                }else {
                    $amount = $this->accountRepository->exchange($a,$b,$request->post('amount'));

                    $acc1 = $this->accountRepository->update([
                        'modelId' => $request->post('from_account'),
                        'balance' => $a->balance - $request->post('amount'), 
                    ]);
                   
                    $acc2 = $this->accountRepository->update([
                        'modelId' => $request->post('to_account'),
                        'balance' => $b->balance + $amount, 
                    ]);
    
                    if($acc1 !== null && $acc1 instanceof Account && $acc2 !== null && $acc2 instanceof Account)
                    {
                        $transactionA = $this->transactionRepository->store([
                            'trans_no' => rand(1000000,9999999),
                            'description' => "To: #$b->accNo - Between Accounts Transfer",
                            'account_id' => $request->post('from_account'),
                            'debit' => $request->post('amount'),
                            'balance' => $a->balance - $request->post('amount')
                        ]);
                        
                        $transactionB = $this->transactionRepository->store([
                            'trans_no' => rand(1000000,9999999),
                            'description' => "From: #$a->accNo - Between Accounts Transfer",
                            'account_id' => $request->post('to_account'),
                            'credit' => $amount,
                            'balance' => $b->balance + $amount,
                        ]);
    
                        if($transactionA !== null && $transactionB !== null)
                        {
                            return redirect()->route('user.home')->with('success','The transfer between accounts was made successfully!');
                        }                    
                    }
                }             
            }
        } 
    }

    public function atmSimulator(AtmSimulatorRequest $request)
    {
        if($request->validated())
        {
            $model = $this->accountRepository->getById($request->post('from_account'));
            $amount = $request->post('amount');
            
            switch($request->post('atm')) {
                case 0:
                    $account = $this->accountRepository->update([
                        'modelId' => $model->id,
                        'balance' => $model->balance + $amount, 
                    ]);
                    
                    if($account !== null && $account instanceof Account)
                    {
                        $transaction = $this->transactionRepository->store([
                            'trans_no' => rand(1000000,9999999),
                            'description' => "ATM Self Deposit",
                            'account_id' => $model->id,
                            'credit' => $amount,
                            'balance' => $model->balance + $amount,                            
                        ]);

                        if($transaction !== null && $transaction instanceof Transaction)
                        {
                            return redirect()->back()->with('success',"You have deposited $amount $model->accountCurrency");
                        }
                    }
                break;
                case 1:
                    $account = $this->accountRepository->update([
                        'modelId' => $model->id,
                        'balance' => $model->balance - $amount, 
                    ]);
                    
                    if($account !== null && $account instanceof Account)
                    {
                        $transaction = $this->transactionRepository->store([
                            'trans_no' => rand(1000000,9999999),
                            'description' => "ATM Self Withdraw",
                            'account_id' => $model->id,
                            'debit' => $amount,
                            'balance' => $model->balance - $amount,                            
                        ]);

                        if($transaction !== null && $transaction instanceof Transaction)
                        {
                            return redirect()->back()->with('success',"You have withdrawn $amount $model->accountCurrency");
                        }
                    }                       
                break;
            }   
        }
    }

    public function externalTransfer(ExternalTransferRequest $request)
    {
        if($request->validated())
        {
            $model = $this->accountRepository->getById($request->post('from_account'));
            $amount = $request->post('amount');
            $details = $request->post('details');
            $toAccount = $request->post('to_account');

            if(!empty($model))
            {
                $account = $this->accountRepository->update([
                    'modelId' => $model->id,
                    'balance' => $model->balance - $amount, 
               ]);

               if($account !== null && $account instanceof Account)
               {
                   $transaction = $this->transactionRepository->store([
                        'trans_no' => rand(1000000,9999999),
                        'description' => "Sent To ACC/NO: $toAccount / Details: $details",
                        'account_id' => $model->id,
                        'debit' => $amount,
                        'balance' => $model->balance - $amount,
                   ]);

                   if($transaction !== null && $transaction instanceof Transaction)
                    {
                        return redirect()->back()->with('success',"You have sent $amount $model->accountCurrency to account number $toAccount");
                    }
               }
            }              
        }
    }

    public function internalTransfer(InternalTransferRequest $request)
    {
        if($request->validated())
        {
            $model = $this->accountRepository->getById($request->post('from_account'));
            $model2 = $this->accountRepository->getById($request->post('to_account'));
            $value = $request->post('amount');

            if($model !== null && $model2 !== null)
            {
                if($model->currency === $model2->currency)
                {
                    $acc1 = $this->accountRepository->update([
                        'modelId' => $model->id,
                        'balance' => $model->balance - $value,
                    ]);

                    $acc2 = $this->accountRepository->update([
                        'modelId' => $model2->id,
                        'balance' => $model2->balance + $value,
                    ]);

                    if($acc1 !== null && $acc2 !== null)
                    {
                        $transaction1 = $this->transactionRepository->store([
                            'trans_no' => rand(1000000,9999999),
                            'description' => "To: #$model2->accNo - Internal Transfer",
                            'account_id' => $model->id,
                            'debit' => $value,
                            'balance' => $model->balance - $value
                        ]);

                        $transaction2 = $this->transactionRepository->store([
                            'trans_no' => rand(1000000,9999999),
                            'description' => "From: #$model->accNo - Internal Transfer",
                            'account_id' => $model2->id,
                            'credit' => $value,
                            'balance' => $model2->balance + $value
                        ]);

                        if($transaction1 !== null && $transaction2 !== null)
                        {
                            return redirect()->back()->with('success',"The transfer to account number $model2->accNo was made successfully!");
                        }
                    }
                }else {
                    $amount = $this->accountRepository->exchange($model,$model2,$value);

                    $acc1 = $this->accountRepository->update([
                        'modelId' => $model->id,
                        'balance' => $model->balance - $value,
                    ]);

                    $acc2 = $this->accountRepository->update([
                        'modelId' => $model2->id,
                        'balance' => $model2->balance + $amount,
                    ]);

                    if($acc1 !== null && $acc2 !== null)
                    {
                        $transaction1 = $this->transactionRepository->store([
                            'trans_no' => rand(1000000,9999999),
                            'description' => "To: #$model2->accNo - Internal Transfer",
                            'account_id' => $model->id,
                            'debit' => $value,
                            'balance' => $model->balance - $value
                        ]);

                        $transaction2 = $this->transactionRepository->store([
                            'trans_no' => rand(1000000,9999999),
                            'description' => "From: #$model->accNo - Internal Transfer",
                            'account_id' => $model2->id,
                            'credit' => $amount,
                            'balance' => $model2->balance + $amount
                        ]);

                        if($transaction1 !== null && $transaction2 !== null)
                        {
                            return redirect()->back()->with('success',"The transfer to account number $model2->accNo was made successfully!");
                        }
                    }
                }
            }                  
        }       
    }


}
