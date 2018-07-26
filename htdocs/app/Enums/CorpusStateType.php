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
                return '本番稼働中';
                brake;
            case self::NoTrainingData:
                return '注意：教師データなし';
                brake;
            case self::Untrained:
                return '注意：学習未実行';
                brake;
            case self::Training:
                return '注意：学習中';
                brake;
            case self::StandBy:
                return '注意：本番反映未実行';
                brake;
            case self::Unavailable:
                return '注意：コーパスの登録不備';
                brake;
            default:
                return self::getKey($value);
        }
    }

    public static function getTrainingAvairableMessage($value): string
    {
        switch ($value){
            case self::Available:
                return '完了済み';
                brake;
            case self::NoTrainingData:
                return '学習不可';
                brake;
            case self::Untrained:
                return '学習可能';
                brake;
            case self::Training:
                return '学習中...';
                brake;
            case self::StandBy:
                return '完了済み';
                brake;
            case self::Unavailable:
                return '学習可能';
                brake;
            default:
                return self::getKey($value);
        }
    }

}