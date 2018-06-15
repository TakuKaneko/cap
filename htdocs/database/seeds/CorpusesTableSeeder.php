<?php

use Illuminate\Database\Seeder;

class CorpusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('corpuses')->insert([
            'name' => 'サンプルシードコーパス',
            'company_id' => 0,
            'description' => 'これはLaravelが自動生成した初期コーパスです。これはLaravelが自動生成した初期コーパスです。これはLaravelが自動生成した初期コーパスです。',
            'classifire_id' => str_random(10),
            'is_active' => false,
        ]);
    }
}
