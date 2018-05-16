@extends('layouts.corpus-admin.base')

@section('content')
      <!--  コンテンツ  -->
      <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 mt-2">
        <section>
          {{-- <h5>現在の学習状況</h5>
          <div class="row">
            <div class="col-3">
              <div class="card bg-light mb-3">
                <div class="card-header">
                  累計学習回数
                </div>
                <div class="card-body">
                  <p>2<small>回</small></p>
                  <span>最終学習日時：</span><span>2018/05/01 12:00:00</span>
                </div>
              </div>
            </div>

            <div class="col-3">
              <div class="card bg-light mb-3">
                <div class="card-header">
                  未学習データの有無
                </div>
                <div class="card-body">
                  <p>あり</p>
                  <span>まだ学習が完了していないデータがあります。学習を実行し、最新のコーパスに反映してください。</span>
                </div>
              </div>
            </div>
          </div> --}}

          <h5>最新の学習結果</h5>
          <div class="card bg-light mb-3" style="background-color:transparent;">
            {{-- <div class="card-header">
              各種状況一覧
            </div> --}}
            <div class="card-body">
              <div class="row">
                <div class="col-6">  
                  <div class="card-header">
                    累計学習回数
                  </div>
                  <div class="card-body">
                    <p>2<small>回</small></p>
                    <span>最終学習日時：</span><span>2018/05/01 12:00:00</span>
                  </div>

                  <div class="card-header">
                    未学習データの有無
                  </div>
                  <div class="card-body">
                    <p>あり</p>
                    <span>まだ学習が完了していないデータがあります。<br>学習を実行し、最新のコーパスに反映してください。</span>
                  </div>
                </div>  

                <div class="col-6">
                  <div class="card-header">直近の学習結果</div>
                  <canvas id="myBarChart" width="700" height="350"></canvas>
                </div>

              </div>
            </div>
          </div>
        </section>

        <h5 id="opeStatus" class="mt-5 mb-3">稼動状況</h5>

      </main>

      <!-- Graphs -->
      <script src="/js/chart.js"></script>
      <script>
        $( document ).ready(function() {
          $('.chartStat').circliful({
            animationStep: 10,
            foregroundBorderWidth: 10,
            backgroundBorderWidth: 5,
            percent: 85,
            foregroundColor: "#61a9dc",
            backgroundColor: "#eee",
            fontColor: "#61a9dc",
            percentageTextSize: 20,
            text: "90%",
            textStyle: "font-size:15px;",
            textAdditionalCss: "border: solid 1px black",
            percentageY: 90,
            textColor: "gray",
            // halfCircle: 1,
          });

          $('.chartStat2').circliful({
            animationStep: 10,
            foregroundBorderWidth: 10,
            backgroundBorderWidth: 5,
            percent: 70,
            foregroundColor: "#ff6347",
            backgroundColor: "#eee",
            fontColor: "#ff6347",
            percentageTextSize: 20,
            text: "90%",
            textStyle: "font-size:15px;",
            textAdditionalCss: "border: solid 1px black",
            percentageY: 90,
            textColor: "gray",
            // halfCircle: 1,
          });
        });

        //棒グラフ
        var ctx = document.getElementById("myBarChart");
        var myBarChart = new Chart(ctx, {
          type: 'horizontalBar',
          data: {
            labels: ["景表法NG", "薬機法NG", "その他NG", "景表法OK", "薬機法OK", "その他OK"],
            datasets: [
              {
                label: "適合率[%]",
                backgroundColor: "rgba(75,192,192,0.4)",
                borderColor: "rgba(75,192,192,1)",
                data: [89, 90, 85, 81, 92, 90]
              },
              {
                label: "再現率[%]",
                backgroundColor: "rgba(255,127,80,0.4)",
                borderColor: "rgba(255,127,80,1)",
                data: [93, 79, 81, 80, 89, 91]
              }  
            ]
          },
          options: {
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                }
              }]
            }
          }
        });
      </script>
@endsection