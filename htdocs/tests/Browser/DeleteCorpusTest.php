<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\User;
use Log;

class DeleteCorpusTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testDeleteCorpus()
    {
        LOG::info('[dusk] testDeleteCorpus');

        $this->browse(function (Browser $browser) {
            // コーパス作成テストで作成したコーパスのモーダルを開く
            $browser->loginAs(User::find(1))
                    ->visit('/corpus')
                    ->rightClick('[data-corpus-name="Duskテスト: コーパス新規作成"]')
                    ->press('削除');

            // 開いたモーダル、アラートで削除を許可する
            $browser->waitForText('コーパスの削除')
                    ->press('確認')
                    ->acceptDialog();

            // 削除が完了したことを確認する
            $browser->waitForText('コーパスの削除が完了しました', 10);

        });
    }
}
