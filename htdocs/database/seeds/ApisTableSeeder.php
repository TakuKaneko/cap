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
                'display_api_id' =>  '001abcd-cap-001',
                'name' => 'テストカンパニー社のサンプルAPI①',
                'description' => 'Laravelが自動生成したテスト用のAPIです。Laravelが自動生成したテスト用のAPIです。Laravelが自動生成したテスト用のAPIです。',
                'company_id' => 1,
                'nlc_id' => '',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]
        ]);
    }
}
