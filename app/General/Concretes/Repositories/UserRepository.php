<?php

namespace App\General\Concretes\Repositories;

use App\General\Abstracts\Repository;
use App\Models\Account;
use App\Models\AccountStatus;
use App\Models\Transaction;
use App\Models\User;

class UserRepository extends Repository
{
    protected $model = User::class;

    private $accountRepository;
 
    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;        
    }

    public function delete(array $args)
    {
        $user = parent::delete($args);
    
        if($user !== null && $user instanceof User){
            if(isset($args['accounts']))
            {
                foreach($args['accounts'] as $key => $value)
                {
                    $account = $this->accountRepository->delete([
                        'modelId' => $value
                    ]);                       
                }

                if($account !== null && $account instanceof Account)
                    {
                        return $user;            
                    }
    
                return null;
            }else {
                return $user;
            }                       
        }

        return false;
    }
}