<?php namespace App\Helpers;

class Custom
{
    public static function limit($tulisan, $limit = 10)
    {
        return mb_strimwidth($tulisan, 0, $limit + 3, "...");
    }
}