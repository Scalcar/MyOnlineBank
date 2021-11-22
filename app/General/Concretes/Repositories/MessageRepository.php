<?php

namespace App\General\Concretes\Repositories;

use App\General\Abstracts\Repository;
use App\Models\Message;

class MessageRepository extends Repository
{
    protected $model = Message::class;
}