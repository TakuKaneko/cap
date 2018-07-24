<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Models\Business\TrainingDataModel;
use App\Models\Business\NlcClassifierModel;

use App\Models\Corpus;
use App\Enums\CorpusStateType;

use Log; // 追加

class CheckNlcTrainingStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $corpus_id;
    protected $nlc_url; 
    protected $username;
    protected $password;
    protected $classifier_id;  // NLC classfier-id
    protected $err_msg; // エラーメッセージ


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($corpus_id, $nlc_url, $username, $password, $classifier_id)
    {
        $this->corpus_id = $corpus_id;
        $this->nlc_url = $nlc_url;
        $this->username = $username;
        $this->password = $password;
        $this->classifier_id = $classifier_id;

        var_dump('[CheckNlcTrainingStatus] インスタンス生成');
    }


    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $break_status = 'Available';
        $sleep_time = 60 * 3;


        // nlcを生成
        $nlc = new NlcClassifierModel($this->nlc_url, $this->username, $this->password, $this->classifier_id);

        // ループ処理
        Log::info('[CheckNlcTrainingStatus] コーパスステータスを確認します');

        while($nlc->getStatus() !== $break_status) {
            sleep($sleep_time);
            $nlc->setStatus();
        }


        // ループを抜けたら諸々アップデート
        $training_data = new TrainingDataModel($corpus_id);

        // クリエイティブの学習完了日をセット
        $training_data->setTrainingDoneDate();

        // コーパスのステータス変更
        $corpus = Corpus::find($corpus_id);
        $corpus->status = CorpusStateType::StandBy;
        $corpus->save();

        Log::info('[CheckNlcTrainingStatus] コーパスステータスの変更が完了しました');


    }


    /**
     * 失敗したジョブの処理
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        // 失敗の通知をユーザーへ送るなど…
    }


}
