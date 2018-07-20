<?php

use Illuminate\Database\Seeder;

class CorpusClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('corpus_classes')->insert([
            [
                'id' => 1,
                'name' => 'クラスA',
                'corpus_id' => '100',
                'training_data_count' => 2,
                'test_data_count' => 1,
                'threshold' => 0.5,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'id' => 2,
                'name' => 'クラスB',
                'corpus_id' => '100',
                'training_data_count' => 1,
                'test_data_count' => 1,
                'threshold' => 0.5,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'id' => 3,
                'name' => 'クラスC',
                'corpus_id' => '100',
                'training_data_count' => 1,
                'test_data_count' => 1,
                'threshold' => 0.5,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'id' => 4,
                'name' => 'クラスD',
                'corpus_id' => '101',
                'training_data_count' => 1,
                'test_data_count' => 1,
                'threshold' => 0.5,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'id' => 5,
                'name' => 'クラスE',
                'corpus_id' => '101',
                'training_data_count' => 1,
                'test_data_count' => 1,
                'threshold' => 0.5,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'id' => 6,
                'name' => 'クラスa',
                'corpus_id' => '1',
                'training_data_count' => 1,
                'test_data_count' => 1,
                'threshold' => 0.5,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]
        ]);
    }
}
