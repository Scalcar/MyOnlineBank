<?php

namespace App\General\Concretes\Enums;

use App\General\Abstracts\Enum;

class AccountStatuses extends Enum
{
    public const INACTIVE_STATUS = 'inactive';
    public const ACTIVE_STATUS = 'active';
    public const FOR_CLOSE_STATUS = 'for close';

    public const INACTIVE_STATUS_ID = 0;
    public const ACTIVE_STATUS_ID = 1;
    public const FOR_CLOSE_STATUS_ID = 2;

    public static array $enum = [
        self::INACTIVE_STATUS => self::INACTIVE_STATUS_ID,
        self::ACTIVE_STATUS => self::ACTIVE_STATUS_ID,
        self::FOR_CLOSE_STATUS => self::FOR_CLOSE_STATUS_ID,
    ];
}