<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserRole extends Enum
{
    const ServiceManager = 0;
    const User = 10;

    /**
     * Enum値に対応するメッセージを返す
     *
     * @param $value
     * @return string
     */
    public static function getDescription($value): string
    {
        switch ($value){
            case self::NationalLanguage:
                return 'パソナテック管理者';
                brake;
            case self::Image:
                return '一般ユーザー';
                brake;
            default:
                return self::getKey($value);
        }
    }
}