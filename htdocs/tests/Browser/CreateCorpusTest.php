<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\User;
use Log;

class CreateCorpusTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testCreateCorpus()
    {
        LOG::info('[dusk] testCreateCorpus');

        $this->browse(function ($browser) {
            // ログインしてコーパス新規作成モーダルを開く
            $browser->loginAs(User::find(1))
                    ->visit('/corpus')
                    ->press('新規作成')
                    ->waitForText('コーパスの作成');

            // フォームに作成するコーパス情報を入力してpostする
            $browser->type('name', 'Duskテスト: コーパス新規作成')
                    ->type('description', 'これはDuskテストで登録したコーパスです。')
                    ->press('作成');

                

            // 完了メッセージが表示されることを確認する
            $browser->waitForText('コーパスが作成されました', 10);

        });
    }
}
