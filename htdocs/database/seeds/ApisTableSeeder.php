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
                'api_id' =>  sprintf('%03d', 1) . str_random(5) . '-cap-' . sprintf('%04d', 1),
                'name' => 'テストカンパニー社のサンプルAPI①',
                'description' => 'Laravelが自動生成したテスト用のAPIです。Laravelが自動生成したテスト用のAPIです。Laravelが自動生成したテスト用のAPIです。',
                'company_id' => 1,
                'nlc_id' => '28680bx78-nlc-1988',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]
        ]);
    }
}
