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
                return 'エラー:教師データがありません。';
                brake;
            case self::Untrained:
                return 'エラー:まだ学習処理が実行されていません。';
                brake;
            case self::Training:
                return 'エラー:現在学習中です。';
                brake;
            case self::StandBy:
                return 'エラー:現在検証中です。コーパスを本番反映すると利用できるようになります。';
                brake;
            case self::Unavailable:
                return 'エラー:現在利用できません。コーパスの登録状況をお確かめください。';
                brake;
            default:
                return self::getKey($value);
        }
    }
}