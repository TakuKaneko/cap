@extends('layouts.dashboard.base')

@section('title')
  TOP
@endsection

@section('content')
  @if (session('msg') || count($errors) > 0)
    <script>
      //   type = ['', 'info', 'danger','success', 'warning', 'rose', 'primary'];
      //   color = Math.floor((Math.random() * 6) + 1);
      function showAlert(msg, type) {
        $.notify({
          icon: "notifications",
          message: msg

        }, {
          type: type,
          timer: 1000,
          placement: {
            from: 'top',
            align: 'center'
          }
        });
      }

    @if(session('msg')) 
      showAlert('{{ session("msg") }}', 'success');
    @endif

    @if(count($errors) > 0)
      // error_msg = '<ul style="margin-bottom: 0;">';
      error_msg = '<p class="warning-notify">';
      @foreach($errors->all() as $error)
        error_msg += '{{ $error }}<br>';
      @endforeach
      error_msg += '</p>';

      showAlert(error_msg, 'warning');
    @endif
      
    </script>
  @endif
  
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            {{--  AIコーパス総数  --}}
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">content_copy</i>
                  </div>
                  <p class="card-category">AIコーパス数</p>
                  <h3 class="card-title">3/5
                  </h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">settings</i>
                    <a href="#">新規登録・編集・削除</a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">school</i>
                  </div>
                  <p class="card-category">当月AI学習数</p>
                  <h3 class="card-title">100 <small>回</small></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">update</i> 更新
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">play_circle_outline</i>
                  </div>
                  <p class="card-category">APIコール数</p>
                  <h3 class="card-title">75 <small>回</small></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">update</i> 更新
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">group</i>
                  </div>
                  <p class="card-category">管理ユーザー数</p>
                  <h3 class="card-title">3 <small>人</small></h3>
                </div>
                <div class="card-footer">
                  <div class="stats">
                    <i class="material-icons">settings</i>
                    <a href="/acount">新規登録・削除</a>
                  </div>
                </div>
              </div>
            </div>            
          </div>

          <div class="row">
            <div class="col-md-12 col-lg-6">
              <div class="card" style="margin-top: 25px;">
                <div class="card-header card-header-tabs card-header-default">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <span class="nav-tabs-title">API応答確信度推移:</span>
                      <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          60日
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="#">3日</a>
                          <a class="dropdown-item" href="#">10日</a>
                          <a class="dropdown-item" href="#">30日</a>
                          <a class="dropdown-item" href="#">60日</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body" style="padding:0;">
                  <div class="container" style="width:100%;height:100%;">
                    <canvas id="classifyChart" style="width:100%;height:300px;"></canvas>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12 col-lg-6">
              <div class="card" style="margin-top: 25px;">
                <div class="card-header card-header-tabs card-header-default">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <span class="nav-tabs-title">APIコール数推移:</span>
                      <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          60日
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                          <a class="dropdown-item" href="#">3日</a>
                          <a class="dropdown-item" href="#">10日</a>
                          <a class="dropdown-item" href="#">30日</a>
                          <a class="dropdown-item" href="#">60日</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body" style="padding:0;">
                  <div class="container" style="width:100%;height:100%;">
                    <canvas id="apiCallChart" style="width:100%;height:300px;"></canvas>
                  </div>
                </div>
              </div>
            </div>            
          </div>
        </div>
      </div>

      <!-- Graphs -->
      <script src="/js/chart.js"></script>
      <script>
        var ctx = document.getElementById("apiCallChart");
        var myChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
            datasets: [
              {
                label: "景表法&薬機法の抵触リスクチェックAPI",
                backgroundColor:"rgba(255,127,80,0.4)",
                borderColor:"rgba(255,127,80,1)",
                data: [17876, 19345, 20483, 18003, 19489, 18092, 15034],
                borderWidth: 3
              },
              {
                label: "メディア画像内の文言チェック",
                backgroundColor:"rgba(30,200,200,0.4)",
                borderColor:"rgba(30,200,200,1)",
                data: [15339, 21345, 18483, 24003, 23489, 24092, 12034],
                borderWidth: 3
              },
            ]
          },
          options: {
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero: false
                }
              }]
            },
            legend: {
              display: true,
            }
          }
        });

        var ctx2 = document.getElementById("classifyChart");
        var myChart2 = new Chart(ctx2, {
          type: 'bar',
          data: {
            labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
            datasets: [
              {
                label: "景表法&薬機法の抵触リスクチェックAPI",
                backgroundColor:"rgba(255,127,80,0.4)",
                borderColor:"rgba(255,127,80,1)",
                data: [93, 94, 91, 95, 90, 90, 93],
                borderWidth: 3
              },
              {
                label: "メディア画像内の文言チェック",
                backgroundColor:"rgba(30,200,200,0.4)",
                borderColor:"rgba(30,200,200,1)",
                data: [89, 81, 91, 85, 89, 92, 85],
                borderWidth: 3
              }
            ]
          },
          options: {
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero: false
                }
              }]
            },
            legend: {
              display: true,
            }
          }
        });
      </script>
@endsection