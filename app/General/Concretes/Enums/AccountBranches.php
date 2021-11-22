<?php

namespace App\General\Concretes\Enums;

use App\General\Abstracts\Enum;

class AccountBranches extends Enum
{
    public const BRANCH_BUCURESTI = 'Bucuresti';
    public const BRANCH_BRASOV = 'Brasov';
    public const BRANCH_CLUJ_NAPOCA = 'Cluj-Napoca';
    public const BRANCH_CONSTANTA = 'Constanta';
    public const BRANCH_IASI = 'Iasi';
    public const BRANCH_TIMISOARA = 'Timisoara';

    public const BRANCH_BUCURESTI_ID = 0;
    public const BRANCH_BRASOV_ID = 1;
    public const BRANCH_CLUJ_NAPOCA_ID = 2;
    public const BRANCH_CONSTANTA_ID = 3;
    public const BRANCH_IASI_ID = 4;
    public const BRANCH_TIMISOARA_ID = 5;

    public static array $enum = [
        self::BRANCH_BUCURESTI => self::BRANCH_BUCURESTI_ID,
        self::BRANCH_BRASOV => self::BRANCH_BRASOV_ID,
        self::BRANCH_CLUJ_NAPOCA => self::BRANCH_CLUJ_NAPOCA_ID,
        self::BRANCH_CONSTANTA => self::BRANCH_CONSTANTA_ID,
        self::BRANCH_IASI => self::BRANCH_IASI_ID,
        self::BRANCH_TIMISOARA => self::BRANCH_TIMISOARA_ID,
    ];
}