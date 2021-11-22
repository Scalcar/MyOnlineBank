<?php

namespace App\Http\Controllers\User;

use App\General\Concretes\Enums\AccountStatuses;
use App\General\Concretes\Enums\MessageStatus;
use App\General\Concretes\Enums\PinStatus;
use App\General\Concretes\Repositories\AccountRepository;
use App\General\Concretes\Repositories\AccountStatusRepository;
use App\General\Concretes\Repositories\TransactionRepository;
use App\General\Concretes\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\ChangePasswordRequest;
use App\Http\Requests\User\ChangePinRequest;
use App\Http\Requests\User\CloseAccountRequest;
use App\Http\Requests\User\EditPersonalDataRequest;
use App\Http\Requests\User\RecoverAccountRequest;
use App\Http\Requests\User\UserAddAccountRequest;
use App\Models\Account;
use App\Models\AccountStatus;
use App\Models\Contact;
use App\Models\Message;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeUserController extends Controller
{
    private $userRepository;
    private $accountRepository;
    private $accountStatusRepository;
    private $transactionRepository;

    public function __construct(UserRepository $userRepository, AccountRepository $accountRepository, AccountStatusRepository $accountStatusRepository, TransactionRepository $transactionRepository)
    {
        $this->userRepository = $userRepository;
        $this->accountRepository = $accountRepository;
        $this->accountStatusRepository = $accountStatusRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function index()
    {
        $user = $this->userRepository->getById(Auth::user()->id);

        $profile = Account::whereHas('status', function($q) {
            return $q->where('status',AccountStatuses::ACTIVE_STATUS_ID);
        })->where('user_id', Auth::user()->id)->get();

        $contact = Contact::where('list_id', Auth::user()->id)->get();
             
        $accounts = Account::whereHas('status', function($q) {
            return $q->where('status',AccountStatuses::ACTIVE_STATUS_ID)->orWhere(function ($q2) {
                return $q2->where('status',AccountStatuses::FOR_CLOSE_STATUS_ID)->where('expires',null)->orWhere('expires','>=',Carbon::now());
            });
        })->where('user_id', Auth::user()->id)->paginate(1, ['*'],'account');

        // $messages = Message::where('sender_id', Auth::user()->id)->orWhere('sent_to_id', Auth::user()->id)->get();
        $messages = Message::where(function($q) {
            return $q->where('sender_id', Auth::user()->id)->where('sender_status',MessageStatus::ACTIVE_STATUS_ID);
        })->orWhere(function($q2) {
            return $q2->where('sent_to_id', Auth::user()->id)->where('receiver_status',MessageStatus::ACTIVE_STATUS_ID);
        })->get();

        $sentMessages = Message::where(function($q) {
            return $q->where('sender_id', Auth::user()->id)->where('sender_status',MessageStatus::ACTIVE_STATUS_ID);
        })->get();

        $receivedMessages = Message::where(function($q) {
            return $q->where('sent_to_id', Auth::user()->id)->where('receiver_status',MessageStatus::ACTIVE_STATUS_ID);
        })->get();
                              
        return view('user.home',[
            'user' => $user,
            'accounts' => $accounts,
            'profile' => $profile,
            'contact' => $contact,
            'messages' => $messages,
            'sentMessages' => $sentMessages,
            'receivedMessages' => $receivedMessages,               
        ]);
    }

    public function closeAccountView()
    {
        $user = $this->userRepository->getById(Auth::user()->id);
        $accounts = $this->accountRepository->getAll();
        return view('user.forms.closeTheAccount',[
            'user' => $user,
            'accounts' => $accounts,
        ]);
    }

    public function requestCloseView(Request $request)
    {
        $account = $this->accountRepository->getById($request->get('account'));

        return view('user.forms.requestClose',[
            'account' => $account,
        ]);
    }

    public function recoverAccountView(Request $request)
    {
        $account = $this->accountRepository->getById($request->get('account'));

        return view('user.forms.recoverAccount',[
            'account' => $account,
        ]);
    }

    public function editPersonalDataView()
    {
        $user = $this->userRepository->getById(Auth::user()->id);

        return view('user.forms.editPersonalData',[
            'user' => $user,
        ]);
    }

    public function changePinStatusView(Request $request)
    {
        $user = Auth::user();
        $account = $this->accountRepository->getById($request->get('account')); 

        return view('user.forms.changePinStatus',[
            'user' => $user,
            'account' => $account
        ]);
    }

    public function newAccountView()
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

        $user = $this->userRepository->getById(Auth::user()->id);
        return view('user.forms.addNewAccount',[
            'user' => $user,
            'random' => $random
        ]);
    }

    public function requestAccount(UserAddAccountRequest $request)
    {
        $account = $this->accountRepository->storeAccount($request->all());

        if($account !== null && $account instanceof Account)
        {
            return redirect()->route('user.home')->with('success','New account requested successfully!');
        }
    }

    public function requestClose(CloseAccountRequest $request)
    {      
        if($request->validated())
        {
            $account = $this->accountRepository->getById($request->post('account_id'));
            $modelId = $request->post('modelId');           
            
            if($account->pin !== $request->post('pin'))
            {
                return redirect()->back()->with('fail','The pin is incorrect. Please try again!');
            }else {
                $expires = Carbon::now()->addMinutes(1);
                $accountStatus = $this->accountStatusRepository->update([
                    'modelId' => $modelId,
                    'status' => AccountStatuses::FOR_CLOSE_STATUS_ID,
                    'activated_at' => null,
                    'expires' => $expires,
                ]);

                if($accountStatus !== null && $accountStatus instanceof AccountStatus)
                {
                    $transaction = $this->transactionRepository->store([
                        'trans_no' => rand(1000000,9999999),
                        'description' => 'Account Waiting to be Closed',
                        'account_id' => $account->id,
                        'balance' => $account->balance,
                    ]);

                    if($transaction !== null && $transaction instanceof Transaction)
                    {
                        return redirect()->route('user.close_account_form')->with('success','The close request was sent successfully!');
                    }                                      
                }                                  
            }
        }
     
    }

    public function recoverAccount(RecoverAccountRequest $request)
    {
        if($request->validated())
        {
            $account = $this->accountRepository->getById($request->post('account_id'));

            $accountStatus = $this->accountStatusRepository->update([
                'modelId' => $request->post('modelId'),
                'status' => AccountStatuses::ACTIVE_STATUS_ID,
                'activated_at' => null,
                'expires' => null,
            ]);

            if($accountStatus !== null && $accountStatus instanceof AccountStatus)
            {
                $transaction = $this->transactionRepository->update([
                    'modelId' => $request->post('transaction_id'),
                    'description' => 'Account Active Again',
                    'balance' => $account->balance,                                   
                ]);

                if($transaction !== null && $transaction instanceof Transaction)
                {
                    return redirect()->route('user.home')->with('success','The account is now active again. Thank you!');                        
                }               
            }
        }
    }

    public function editPersonalData(EditPersonalDataRequest $request)
    {
        if($request->validated())
        {
            $user = $this->userRepository->update($request->all());

            if($user !== null && $user instanceof User)
            {
                return redirect()->route('user.home')->with('success','Personal data was changed successfully!');
            }
        }
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        if($request->validated())
        {
            $user = $this->userRepository->update([
                'modelId' => $request->post('modelId'),
                'password' => Hash::make($request->password),
            ]);
            
            if($user !== null && $user instanceof User)
            {
                return redirect()->route('user.home')->with('success','Password was changed successfully!');
            }
        }
    }

    public function changePin(ChangePinRequest $request)
    {
        if($request->validated())
        {
            $account = $this->accountRepository->update([
                'modelId' => $request->post('account_id'),
                'pin' => $request->post('npin'),
                'pinStatus' => PinStatus::SAFE_STATUS_ID
            ]);

            if($account !== null && $account instanceof Account)
            {
                return redirect()->route('user.home')->with('success',"Account #$account->accNo PIN was changed successfully!");
            }
        }
    }
}
