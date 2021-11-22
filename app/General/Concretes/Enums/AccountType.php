<?php

namespace App\General\Concretes\Enums;

use App\General\Abstracts\Enum;

class AccountType extends Enum
{
    public const SAVINGS_TYPE = 'savings';
    public const CHECKING_TYPE = 'checking';

    public const SAVINGS_TYPE_ID = 0;
    public const CHECKING_TYPE_ID = 1;

    public static array $enum = [
        self::SAVINGS_TYPE => self::SAVINGS_TYPE_ID,
        self::CHECKING_TYPE => self::CHECKING_TYPE_ID,
    ];
}