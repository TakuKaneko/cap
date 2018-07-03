<?php

use Illuminate\Database\Seeder;

class ApisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('apis')->insert([
            [
                'id' => 1,
                'name' => 'テストカンパニー社のサンプルAPI①',
                'description' => 'Laravelが自動生成したテスト用のAPIです。Laravelが自動生成したテスト用のAPIです。Laravelが自動生成したテスト用のAPIです。',
                'created_at' => '2018-06-19 15:00:00',
                'updated_at' => '2018-06-19 15:00:00'

            ],
            [
                'id' => 20,
                'name' => 'テストカンパニー社のサンプルAPI②',
                'description' => 'Laravelが自動生成したテスト用のAPIです。Laravelが自動生成したテスト用のAPIです。Laravelが自動生成したテスト用のAPIです。',
                'created_at' => '2018-06-19 15:00:00',
                'updated_at' => '2018-06-19 15:00:00'
            ],
        ]);
    }
}
