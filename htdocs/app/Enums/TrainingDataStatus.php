<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class TrainingDataStatus extends Enum
{
    const NoData = 1;
    const DataDeficiencies = 2;
    const ExistUntrainingData = 3;
    const NnUntrainingData = 4;

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
                return '未登録';
                brake;
            case self::DataDeficiencies:
                return 'データ不備';
                brake;
            case self::ExistUntrainingData:
                return 'あり';
                brake;
            case self::NnUntrainingData:
                return 'なし';
                brake;
            default:
                return self::getKey($value);
        }
    }
    
}