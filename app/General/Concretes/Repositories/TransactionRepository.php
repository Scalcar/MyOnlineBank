<?php

namespace App\General\Concretes\Repositories;

use App\General\Abstracts\Repository;
use App\Models\Transaction;

class TransactionRepository extends Repository
{
    protected $model = Transaction::class;
}