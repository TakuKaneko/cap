<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ClassifierLanguage extends Enum
{
    const Japanese = 0;
    const English = 1;
    const Arabic = 2;
    const French = 3;
    const German = 4;
    const Italian = 5;
    const Korean = 6;
    const BrazilianPortuguese = 7;
    const Spanish = 8;


    /**
     * Enum値に対応するメッセージを返す
     *
     * @param $value
     * @return string
     */
    public static function getDescription($value): string
    {
        switch ($value){
            case self::Japanese:
                return 'ja';
                brake;
            case self::English:
                return 'en';
                brake;
            case self::Arabic:
                return 'ar';
                brake;
            case self::French:
                return 'fr';
                brake;
            case self::German:
                return 'de';
                brake;
            case self::Italian:
                return 'it';
                brake;
            case self::Korean:
                return 'ko';
                brake;
            case self::BrazilianPortuguese:
                return 'pt';
                brake;
            case self::Spanish:
                return 'es';
                brake;
            default:
                return self::getKey($value);
        }
    }



    /**
     * コーパス新規作成モーダルで言語選択するときのセレクトボックス用
     */
    public static function getList() {
        return [
            [
                'label' => self::getJapaneseDescription(self::Japanese),
                'value' => self::Japanese
            ],
            [
                'label' => self::getJapaneseDescription(self::English),
                'value' => self::English
            ],
            // [
            //     'label' => self::getJapaneseDescription(self::Arabic),
            //     'value' => self::Arabic
            // ],
            // [
            //     'label' => self::getJapaneseDescription(self::French),
            //     'value' => self::French
            // ],
            // [
            //     'label' => self::getJapaneseDescription(self::German),
            //     'value' => self::German
            // ],
            // [
            //     'label' => self::getJapaneseDescription(self::Italian),
            //     'value' => self::Italian
            // ],
            // [
            //     'label' => self::getJapaneseDescription(self::Korean),
            //     'value' => self::Korean
            // ],
            // [
            //     'label' => self::getJapaneseDescription(self::BrazilianPortuguese),
            //     'value' => self::BrazilianPortuguese
            // ],
            // [
            //     'label' => self::getJapaneseDescription(self::Spanish),
            //     'value' => self::Spanish
            // ]
        ];
    }


    /**
     * 
     */
    public static function getJapaneseDescription($value): string
    {
        switch ($value){
            case self::Japanese:
                return '日本語';
                brake;
            case self::English:
                return '英語';
                brake;
            case self::Arabic:
                return 'アラビア語';
                brake;
            case self::French:
                return 'フランス語';
                brake;
            case self::German:
                return 'ドイツ語';
                brake;
            case self::Italian:
                return 'イタリア語';
                brake;
            case self::Korean:
                return '韓国語';
                brake;
            case self::BrazilianPortuguese:
                return 'ブラジルポルトガル語';
                brake;
            case self::Spanish:
                return 'スペイン語';
                brake;
            default:
                return self::getKey($value);
        }
    }

}