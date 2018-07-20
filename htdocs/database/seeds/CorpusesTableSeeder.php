<?php

use Illuminate\Database\Seeder;
use App\Enums\CorpusStateType;
use App\Enums\CorpusType;
use App\Enums\ClassifierLanguage;

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
                'name' => 'サンプル_景表法チェックコーパス',
                'description' => 'これはLaravelが自動生成した初期コーパスです。これはLaravelが自動生成した初期コーパスです。これはLaravelが自動生成した初期コーパスです。',
                'status' => CorpusStateType::Available,
                'type' => CorpusType::NationalLanguage,
                'is_production' => true,
                'company_id' => '1',
                'language' => ClassifierLanguage::Japanese,
                'created_at' => NOW(),
                'updated_at' => NOW()
            ],
        ]);
    }
}
