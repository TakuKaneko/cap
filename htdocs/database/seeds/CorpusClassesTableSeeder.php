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
                'threshold' => null,
                'data_count' => 3,
                'data_type' => 'production',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'id' => 2,
                'name' => 'クラスB',
                'corpus_id' => '100',
                'threshold' => null,
                'data_count' => 2,
                'data_type' => 'production',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'id' => 3,
                'name' => 'クラスC',
                'corpus_id' => '101',
                'threshold' => null,
                'data_count' => 2,
                'data_type' => 'production',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
        ]);
    }
}
