<?php

namespace App\Enums;

class Category
{
    const TECHNOLOGY    = 'Technology';
    const HEALTH        = 'Health';
    const BUSINESS      = 'Business';
    const EDUCATION     = 'Education';
    const ENTERTAINMENT = 'Entertainment';
    const SPORTS        = 'Sports';
    const LIFESTYLE     = 'Lifestyle';
    const TRAVEL        = 'Travel';
    const FOOD          = 'Food';
    const SCIENCE       = 'Science';

    public static function getValues()
    {
        return [
            self::TECHNOLOGY,
            self::HEALTH,
            self::BUSINESS,
            self::EDUCATION,
            self::ENTERTAINMENT,
            self::SPORTS,
            self::LIFESTYLE,
            self::TRAVEL,
            self::FOOD,
            self::SCIENCE,
        ];
    }
}
