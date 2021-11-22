<?php

namespace App\General\Concretes\Enums;

use App\General\Abstracts\Enum;

class AtmActions extends Enum
{
    public const DEPOSIT_ACTION = 'deposit';
    public const WITHDRAW_ACTION = 'withdraw';

    public const DEPOSIT_ACTION_ID = 0;
    public const WITHDRAW_ACTION_ID = 1;

    public static array $enum = [
        self::DEPOSIT_ACTION => self::DEPOSIT_ACTION_ID,
        self::WITHDRAW_ACTION => self::WITHDRAW_ACTION_ID,
    ];
}