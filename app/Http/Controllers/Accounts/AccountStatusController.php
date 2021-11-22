<?php

namespace App\Http\Controllers\Accounts;

use App\General\Concretes\Repositories\AccountStatusRepository;
use App\Http\Controllers\Controller;

class AccountStatusController extends Controller
{
    private $accountStatusRepository;

    public function __construct(AccountStatusRepository $accountStatusRepository)
    {
        $this->accountStatusRepository = $accountStatusRepository;
    }
}
