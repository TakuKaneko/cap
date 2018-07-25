<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class TrainingDataStatus extends Enum
{
    const NoData = 1; // 学習データなし
    const DataDeficiencies = 2; // データの不備
    const ExistUntrainingData = 3; // 未学習データあり
    const NoUntrainingData = 4; // 全データ学習済み

    /**
     * Enum値に対応するメッセージを返す
     *
     * @param $value
     * @return string
     */
    public static function getDescription($value): string
    {
        switch ($value){
            case self::NoData:
                return 'データ未登録';
                brake;
            case self::DataDeficiencies:
                return 'データ不備';
                brake;
            case self::ExistUntrainingData:
                return '学習可能';
                brake;
            case self::NoUntrainingData:
                return '学習済み';
                brake;
            default:
                return self::getKey($value);
        }
    }
    
}