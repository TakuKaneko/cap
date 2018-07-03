<?php

use Illuminate\Database\Seeder;

class CompanyApisTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('company_apis')->insert([
            [
                'company_id' => 1,
                'api_id' => 1,
                'created_at' => '2018-06-19 12:00:00',
                'updated_at' => '2018-06-19 12:00:00'
            ],
            [
                'company_id' => 1,
                'api_id' => 20,
                'created_at' => '2018-06-19 12:00:00',
                'updated_at' => '2018-06-19 12:00:00'
            ]
        ]);
    }
}
