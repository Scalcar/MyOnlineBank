<?php

namespace App\General\Concretes\Enums;

use App\General\Abstracts\Enum;

class AccountCurrency extends Enum
{
    public const RON_CURRENCY = 'RON';
    public const USD_CURRENCY = 'USD';
    public const EUR_CURRENCY = 'EUR';
    public const GBP_CURRENCY = 'GBP';

    public const RON_CURRENCY_ID = 0;
    public const USD_CURRENCY_ID = 1;
    public const EUR_CURRENCY_ID = 2;
    public const GBP_CURRENCY_ID = 3;

    public static array $enum = [
        self::RON_CURRENCY => self::RON_CURRENCY_ID,
        self::USD_CURRENCY => self::USD_CURRENCY_ID,
        self::EUR_CURRENCY => self::EUR_CURRENCY_ID,
        self::GBP_CURRENCY => self::GBP_CURRENCY_ID,
    ];
}