<?php 

namespace App\General\Abstracts;

use App\General\Interfaces\IEnum;

abstract class Enum implements IEnum
{
    /** @var array $enum */
    public static array $enum = array();

    public static function getValueById(int $id): string
    {
        return array_search($id, static::$enum, true);
    }

    public static function getIdByValue(string $value): int
    {
        return static::$enum[$value];
    }

    public static function getEnum(): array
    {
        return static::$enum;
    }

    public static function getJson(): string
    {
        return json_encode(static::$enum, JSON_THROW_ON_ERROR);
    }
}