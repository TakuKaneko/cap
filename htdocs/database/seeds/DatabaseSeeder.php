<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CompaniesTableSeeder::class,
            ApisTableSeeder::class,
            CompanyApisTableSeeder::class,
            CorpusesTableSeeder::class,
            ApiCorpusesTableSeeder::class
        ]);
    }
}
