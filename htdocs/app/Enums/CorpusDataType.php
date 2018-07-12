<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class CorpusDataType extends Enum
{
    const Test = 0;
    const Training = 1;

    /**
     * Enum値に対応するメッセージを返す
     *
     * @param $value
     * @return string
     */
    public static function getDescription($value): string
    {
        switch ($value){
            case self::Test:
                return 'テストデータ';
                brake;
            case self::Training:
                return '学習データ';
                brake;
            default:
                return self::getKey($value);
        }
    }
}