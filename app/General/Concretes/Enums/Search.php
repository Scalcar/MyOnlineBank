<?php

namespace App\General\Concretes\Enums;

use App\General\Abstracts\Enum;

class Search extends Enum
{
    public const BY_NAME_SEARCH = 'nickname';
    public const BY_ACCOUNT_NUMBER = 'account number';

    public const BY_NAME_SEARCH_ID = 0;
    public const BY_ACCOUNT_NUMBER_ID = 1;

    public static array $enum = [
        self::BY_NAME_SEARCH => self::BY_NAME_SEARCH_ID,
        self::BY_ACCOUNT_NUMBER => self::BY_ACCOUNT_NUMBER_ID,
    ];
}