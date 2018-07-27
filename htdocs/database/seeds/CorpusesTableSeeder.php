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
                'id' => 1,
                'name' => '初期コーパス',
                'description' => 'これはLaravelが自動生成した初期コーパスです。これはLaravelが自動生成した初期コーパスです。これはLaravelが自動生成した初期コーパスです。',
                'status' => CorpusStateType::NoTrainingData,
                'type' => '1',
                'is_production' => '1',
                'company_id' => '1',
                'language' => '0',
                'tmp_nlc_id' => '',
                'create_user_id' => '1',
                'update_user_id' => '1',
                'created_at' => NOW(),
                'updated_at' => NOW()
            ]
        ]);
    }
}
