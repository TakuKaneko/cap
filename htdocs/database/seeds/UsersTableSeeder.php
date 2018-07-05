<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('users')->insert([
      [
        'sei_kanji' => 'テスト',
        'sei_kana' => 'てすと',
        'mei_kanji' => '太郎1',
        'mei_kana' => 'たろう1',
        'email' => 'test@gmail.com',
        'password' => bcrypt('sld001'),
        'company_id' => 1,
        'remember_token' => '',
        'created_at' => NOW(),
        'updated_at' => NOW()
      ],
      [
        'sei_kanji' => 'テスト',
        'sei_kana' => 'てすと',
        'mei_kanji' => '太郎2',
        'mei_kana' => 'たろう2',
        'email' => 'test2@gmail.com',
        'password' => bcrypt('sld002'),
        'company_id' => 1,
        'remember_token' => '',
        'created_at' => NOW(),
        'updated_at' => NOW()
      ]
    ]);
  }
}
