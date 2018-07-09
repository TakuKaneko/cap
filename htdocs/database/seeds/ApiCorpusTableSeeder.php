<?php

use Illuminate\Database\Seeder;

class ApiCorpusTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('api_corpus')->insert([
      [
        'api_id' => 1,
        'corpus_id' => 100,
        'created_at' => '2018-06-19 15:00:00',
        'updated_at' => '2018-06-19 15:00:00'
      ],
      [
        'api_id' => 20,
        'corpus_id' => 101,
        'created_at' => '2018-06-19 15:00:00',
        'updated_at' => '2018-06-19 15:00:00'
      ],
    ]);
  }
}
