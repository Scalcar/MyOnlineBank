<?php

namespace App\General\Concretes\Repositories;

use App\General\Abstracts\Repository;
use App\Models\AccountStatus;

class AccountStatusRepository extends Repository
{
    protected $model = AccountStatus::class;
}