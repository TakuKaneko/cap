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
        'corpus_id' => 1,
        'created_at' => NOW(),
        'updated_at' => NOW()
      ],
    ]);
  }
}
