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
            ApisTableSeeder::class,
            ApiCorpusesTableSeeder::class,
            CompaniesTableSeeder::class,
            CompanyApisTableSeeder::class,
            CorpusesTableSeeder::class,
            UsersTableSeeder::class
        ]);
    }
}
