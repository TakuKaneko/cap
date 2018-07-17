<?php

use Illuminate\Database\Seeder;

class CorpusCreativesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('corpus_creatives')->insert([
            [
                'id' => 1,
                'corpus_class_id' => '1',
                'data_type' => 1,
                'content' => 'これはクラスAの学習データ1です。',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'id' => 2,
                'corpus_class_id' => '1',
                'data_type' => 0,
                'content' => 'これはクラスAのテストデータ1です。',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'id' => 3,
                'corpus_class_id' => '1',
                'data_type' => 1,
                'content' => 'これはクラスAの学習データ2です。',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'id' => 4,
                'corpus_class_id' => '2',
                'data_type' => 0,
                'content' => 'これはクラスBのテストデータ1です。',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'id' => 5,
                'corpus_class_id' => '2',
                'data_type' => 1,
                'content' => 'これはクラスBの学習データ1です。',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'id' => 6,
                'corpus_class_id' => '3',
                'data_type' => 1,
                'content' => 'これはクラスCの学習データ1です。',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'id' => 7,
                'corpus_class_id' => '3',
                'data_type' => 0,
                'content' => 'これはクラスCのテストデータ1です。',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'id' => 8,
                'corpus_class_id' => '4',
                'data_type' => 1,
                'content' => 'これはクラスDの学習データ1です。',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'id' => 9,
                'corpus_class_id' => '4',
                'data_type' => 0,
                'content' => 'これはクラスDのテストデータ1です。',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'id' => 10,
                'corpus_class_id' => '5',
                'data_type' => 1,
                'content' => 'これはクラスEの学習データ1です。',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'id' => 11,
                'corpus_class_id' => '5',
                'data_type' => 0,
                'content' => 'これはクラスEのテストデータ1です。',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'id' => 12,
                'corpus_class_id' => '6',
                'data_type' => 1,
                'content' => 'これはクラスaの学習データ1です。',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'id' => 13,
                'corpus_class_id' => '6',
                'data_type' => 0,
                'content' => 'これはクラスaのテストデータ1です。',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]

        ]);
    }
}
