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
                'content' => 'これはクラスAの教師データ1です。',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'id' => 2,
                'corpus_class_id' => '1',
                'content' => 'これはクラスAの教師データ2です。',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'id' => 3,
                'corpus_class_id' => '1',
                'content' => 'これはクラスAの教師データ3です。',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'id' => 4,
                'corpus_class_id' => '2',
                'content' => 'これはクラスBの教師データ1です。',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'id' => 5,
                'corpus_class_id' => '2',
                'content' => 'これはクラスBの教師データ2です。',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'id' => 6,
                'corpus_class_id' => '3',
                'content' => 'これはクラスCの教師データ1です。',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'id' => 7,
                'corpus_class_id' => '3',
                'content' => 'これはクラスCの教師データ2です。',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'id' => 8,
                'corpus_class_id' => '4',
                'content' => 'これはクラスDの教師データ1です。',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'id' => 9,
                'corpus_class_id' => '4',
                'content' => 'これはクラスDの教師データ2です。',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'id' => 10,
                'corpus_class_id' => '5',
                'content' => 'これはクラスEの教師データ1です。',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'id' => 11,
                'corpus_class_id' => '5',
                'content' => 'これはクラスEの教師データ2です。',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]

        ]);
    }
}
