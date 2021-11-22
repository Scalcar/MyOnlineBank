<?php

namespace App\General\Concretes\Enums;

use App\General\Abstracts\Enum;

class MessageStatus extends Enum
{
    public const INACTIVE_STATUS = 'inactive';
    public const ACTIVE_STATUS = 'active';
    public const UNREAD_STATUS = 'unread';
    public const READ_STATUS = 'read';

    public const INACTIVE_STATUS_ID = 0;
    public const ACTIVE_STATUS_ID = 1;
    public const UNREAD_STATUS_ID = 2;
    public const READ_STATUS_ID = 3;

    public static array $enum = [
        self::INACTIVE_STATUS => self::INACTIVE_STATUS_ID,
        self::ACTIVE_STATUS => self::ACTIVE_STATUS_ID,
        self::UNREAD_STATUS => self::UNREAD_STATUS_ID,
        self::READ_STATUS => self::READ_STATUS_ID,
    ];
}