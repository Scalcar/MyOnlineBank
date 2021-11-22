<?php

namespace App\General\Concretes\Enums;

use App\General\Abstracts\Enum;

class UserGenders extends Enum
{
    public const FEMALE_GENDER = 'female';
    public const MALE_GENDER = 'male';
    public const OTHERS_GENDER = 'others';

    public const FEMALE_GENDER_ID = 0;
    public const MALE_GENDER_ID = 1;
    public const OTHERS_GENDER_ID = 2;

    public static array $enum = [
        self::FEMALE_GENDER => self::FEMALE_GENDER_ID,
        self::MALE_GENDER => self::MALE_GENDER_ID,
        self::OTHERS_GENDER => self::OTHERS_GENDER_ID,
    ];
}