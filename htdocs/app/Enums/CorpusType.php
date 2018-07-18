<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class CorpusType extends Enum
{
    const NationalLanguage = 1;
    const Image = 2;

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
                return '自然言語';
                brake;
            case self::Image:
                return '画像';
                brake;
            default:
                return self::getKey($value);
        }
    }
}