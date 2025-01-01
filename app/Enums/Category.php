<?php

namespace App\Enums;

class Category
{
    const TECHNOLOGY    = 1;
    const HEALTH        = 2;
    const BUSINESS      = 3;
    const EDUCATION     = 4;
    const ENTERTAINMENT = 5;
    const SPORTS        = 6;
    const LIFESTYLE     = 7;
    const TRAVEL        = 8;
    const FOOD          = 9;
    const SCIENCE       = 10;

    public static function getValues()
    {
        return [
            self::TECHNOLOGY    => 'Technology',
            self::HEALTH        => 'Health',
            self::BUSINESS      => 'Business',
            self::EDUCATION     => 'Education',
            self::ENTERTAINMENT => 'Entertainment',
            self::SPORTS        => 'Sports',
            self::LIFESTYLE     => 'Lifestyle',
            self::TRAVEL        => 'Travel',
            self::FOOD          => 'Food',
            self::SCIENCE       => 'Science',
        ];
    }

    public static function getIdByName($name)
    {
        $categories = array_flip(self::getValues());
        return $categories[$name] ?? null;
    }

    public static function getNameById($id)
    {
        $categories = self::getValues();
        return $categories[$id] ?? null;
    }
}
