<?php

namespace App\General\Concretes\Enums;

use App\General\Abstracts\Enum;

class PinStatus extends Enum
{
    public const UNSAFE_STATUS = 'unsafe';
    public const SAFE_STATUS = 'safe';
    public const FORGOTTEN_STATUS = 'forgot pin';

    public const UNSAFE_STATUS_ID = 0;
    public const SAFE_STATUS_ID = 1;
    public const FORGOTTEN_STATUS_ID = 2;

    public static array $enum = [
        self::UNSAFE_STATUS => self::UNSAFE_STATUS_ID,
        self::SAFE_STATUS => self::SAFE_STATUS_ID,
        self::FORGOTTEN_STATUS => self::FORGOTTEN_STATUS_ID
    ];
}