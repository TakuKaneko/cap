<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class CorpusStateType extends Enum
{
    const Available = 0;
    const NoTrainingData = 1;
    const Untrained = 2;
    const Training = 3;
    const StandBy = 4;
    const Unavailable = 9;

    /**
     * Enum値に対応するメッセージを返す
     *
     * @param $value
     * @return string
     */
    public static function getDescription($value): string
    {
        switch ($value){
            case self::Available:
                return '利用可能';
                brake;
            case self::NoTrainingData:
                return '教師データなし';
                brake;
            case self::Untrained:
                return '未学習';
                brake;
            case self::Training:
                return '学習中';
                brake;
            case self::StandBy:
                return '本番反映前';
                brake;
            case self::Unavailable:
                return '利用不可';
                brake;
            default:
                return self::getKey($value);
        }
    }
}