<?php

namespace App\General\Concretes\Repositories;

use App\General\Abstracts\Repository;
use App\General\Concretes\Enums\AccountStatuses;
use App\Models\Account;
use App\Models\AccountStatus;
use App\Models\Transaction;
use DateTime;

class AccountRepository extends Repository
{
    protected $model = Account::class;

    private $accountStatusRepository;
    private $transactionRepository;

    public function __construct(AccountStatusRepository $accountStatusRepository, TransactionRepository $transactionRepository)
    {
        $this->accountStatusRepository = $accountStatusRepository;
        $this->transactionRepository = $transactionRepository;
    }

    public function store(array $args)
    {
        $account = parent::store($args);

        if($account !== null && $account instanceof Account){
            $accountStatus = $this->accountStatusRepository->store([
                'account_id' => $account->id,
                'status' => AccountStatuses::ACTIVE_STATUS_ID,
                'activated_at' => null
            ]);

            $transaction = $this->transactionRepository->store([
                'trans_no' => rand(1000000,9999999),
                'description' => 'Account Opening',
                'account_id' => $account->id,
                'credit' => $account->balance,
                'balance' => $account->balance
            ]);

            if($accountStatus !== null && $accountStatus instanceof AccountStatus && $transaction !== null && $transaction instanceof Transaction)
            {
                return $account;
            }else {
                $account->delete();
                return false;
            }
        }

        return false;
    }

    public function storeAccount(array $args)
    {
        $account = parent::store($args);

        if($account !== null && $account instanceof Account)
        {
            $accountStatus = $this->accountStatusRepository->store([
                'account_id' => $account->id,
                'status' => AccountStatuses::INACTIVE_STATUS_ID,
                'activated_at' => null
            ]);
            
            $transaction = $this->transactionRepository->store([
                'trans_no' => rand(1000000,9999999),
                'description' => 'Account Waiting for Approval',
                'account_id' => $account->id,
                'balance' => $account->balance
            ]);

            if($accountStatus !== null && $accountStatus instanceof AccountStatus && $transaction !== null && $transaction instanceof Transaction)
            {
                return $account;
            }else {
                $account->delete();
                return false;
            }
        }

        return false;
    }

    public function delete(array $args)
    {
        $account = parent::delete($args);

        if($account !== null && $account instanceof Account)
        {
            $accountStatus = $this->accountStatusRepository->delete([
                'modelId' => $account->status->id 
            ]);

            $transactions = Transaction::where('account_id',$account->id)->get();
            foreach($transactions as $key => $value)
            {
                $transaction = $this->transactionRepository->delete([
                    'modelId' => $value->id
                ]);
            }

            if($transaction !== null && $transaction instanceof Transaction && $accountStatus !== null && $accountStatus instanceof AccountStatus)
            {
                return $account;
            }

            return null;
        }

        return false;
    }

    public function accept(array $args)
    {
        $account = parent::update($args);

        if($account !== null && $account instanceof Account)
        {
            $accountStatus = $this->accountStatusRepository->update([
                'modelId' => $account->status->id,
                'status' => AccountStatuses::ACTIVE_STATUS_ID,
                'activated_at' => new DateTime(),    
            ]);
            
            $transaction = $this->transactionRepository->update([
                'modelId' => $account->transactions()->latest()->first()->id,
                'description' => 'Account Opening',
                'credit' => $account->balance,
                'balance' => $account->balance,
            ]);

            if($accountStatus !== null && $accountStatus instanceof AccountStatus && $transaction !== null && $transaction instanceof Transaction)
            {
                return $account;
            }
            else {
                if($account->wasChanged())
                {
                    $account = parent::update($account->getOriginal());

                    if($account !== null && $account instanceof Account)
                    {
                        return $account;
                    }
                    else {
                        return false;
                    }
                }
                else {
                    return false;
                }
            }
        }

        return false;
    }

    public function exchange($a,$b,$value)
    {
        if($a->currency === 0) {
            switch($b->currency) {
                case 1:
                    $amount = $value * 0.25;                                      
                break;
                case 2:
                    $amount = $value * 0.22;                          
                break;
                case 3:
                    $amount = $value * 0.20;
                break;     
            }
        }elseif($a->currency === 1) {
            switch($b->currency) {
                case 0:
                    $amount = $value * 4;                                      
                break;
                case 2:
                    $amount = $value * 0.88;                          
                break;
                case 3:
                    $amount = $value * 0.80;
                break;     
            }
        }elseif($a->currency === 2) {
            switch($b->currency) {
                case 0:
                    $amount = $value * 4.5;                                      
                break;
                case 1:
                    $amount = $value * 1.125;                          
                break;
                case 3:
                    $amount = $value * 0.90;
                break;     
            }
        }elseif($a->currency === 3) {
            switch($b->currency) {
                case 0:
                    $amount = $value * 5;                                      
                break;
                case 1:
                    $amount = $value * 1.25;                          
                break;
                case 2:
                    $amount = $value * 1.11;
                break;     
            }
        }

        return $amount;
    }
}