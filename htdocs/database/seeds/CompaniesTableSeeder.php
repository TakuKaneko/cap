<?php

use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
            [
                'id' => 1,
                'name' => '株式会社テストカンパニー',
                'authroize_token' => 'BEm7tiSIV3',
                'nlc_url' => 'https://gateway.watson-j.jp/natural-language-classifier/api/v1/classifiers/',
                'nlc_username' => '311e098f-48eb-4496-b56a-1aab90584f14',
                'nlc_password' => 'MkaPamJNR1JN',
                'api_limit_training' => 100,
                'api_limit_update' => 100,
                'api_limit_other' => 50,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'id' => 2,
                'name' => 'ララベル株式会社',
                'authroize_token' => str_random(10),
                'nlc_url' => 'https://gateway.watson-j.jp/natural-language-classifier/api/v1/classifiers/',
                'nlc_username' => '311e098f-48eb-4496-b56a-1aab90584f14',
                'nlc_password' => 'MkaPamJNR1JN',
                'api_limit_training' => 100,
                'api_limit_update' => 100,
                'api_limit_other' => 50,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'id' => 999,
                'name' => '株式会社パソナテック',
                'authroize_token' => str_random(10),
                'nlc_url' => '',
                'nlc_username' => '',
                'nlc_password' => '',
                'api_limit_training' => 99999,
                'api_limit_update' => 99999,
                'api_limit_other' => 99999,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
        ]);
    }
}
