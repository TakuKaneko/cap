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
                'api_limit_training' => 100,
                'api_limit_update' => 100,
                'api_limit_other' => 50,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
            [
                'id' => 999,
                'name' => '株式会社パソナテック',
                'api_limit_training' => 99999,
                'api_limit_update' => 99999,
                'api_limit_other' => 99999,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
        ]);
    }
}
