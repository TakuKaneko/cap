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
        'mei_kanji' => '太郎1',
        'email' => 'test@gmail.com',
        'password' => bcrypt('sld001'),
        'company_id' => 1,
        'role' => 10,
        'remember_token' => NULL,
        'created_at' => NOW(),
        'updated_at' => NOW()
      ],
      [
        'sei_kanji' => 'テスト',
        'mei_kanji' => '太郎2',
        'email' => 'test2@gmail.com',
        'password' => bcrypt('sld002'),
        'company_id' => 1,
        'role' => 10,
        'remember_token' => NULL,
        'created_at' => NOW(),
        'updated_at' => NOW()
      ],
      [
        'sei_kanji' => 'パソナテック',
        'mei_kanji' => '管理者',
        'email' => 'test3@gmail.com',
        'password' => bcrypt('sld003'),
        'company_id' => 2,
        'role' => 0,
        'remember_token' => NULL,
        'created_at' => NOW(),
        'updated_at' => NOW()
      ]
    ]);
  }
}
