<?php


namespace App\General\Interfaces;


interface IEnum
{
    public static function getValueById(int $id):string;
    public static function getIdByValue(string $value):int;
    public static function getEnum():array;
}
