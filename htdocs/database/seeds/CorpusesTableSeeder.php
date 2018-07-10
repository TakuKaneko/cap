<?php

use Illuminate\Database\Seeder;
use App\Enums\CorpusStateType;

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
            [
                'id' => 100,
                'name' => 'サンプル自然言語コーパス',
                'description' => 'これはLaravelが自動生成した初期コーパスです。これはLaravelが自動生成した初期コーパスです。これはLaravelが自動生成した初期コーパスです。',
                'service_url' => 'https://www.test.co.jp',
                'service_username' => str_random(10),
                'service_hidden_password' => str_random(10),
                'service_identify_id' => str_random(10),
                'status' => CorpusStateType::Available,
                'type' => '1',
                'is_production' => true,
                'created_at' => '2018-04-01 12:00:00',
                'updated_at' => NOW()
            ],
            [
                'id' => 101,
                'name' => 'サンプル画像コーパス',
                'description' => 'これはLaravelが自動生成した初期コーパスです。これはLaravelが自動生成した初期コーパスです。これはLaravelが自動生成した初期コーパスです。',
                'service_url' => 'https://www.test.co.jp',
                'service_username' => str_random(10),
                'service_hidden_password' => str_random(10),
                'service_identify_id' => str_random(10),
                'status' => CorpusStateType::Unavailable,
                'type' => '2',
                'is_production' => true,
                'created_at' => '2018-04-02 09:00:00',
                'updated_at' => NOW()
            ],

        ]);
    }
}
