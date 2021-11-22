<?php

namespace App\General\Concretes\Repositories;

use App\General\Abstracts\Repository;
use App\Models\Admin;

class AdminRepository extends Repository
{
    protected $model = Admin::class;
}