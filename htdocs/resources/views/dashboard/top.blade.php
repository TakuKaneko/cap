@extends('layouts.dashboard.base')

@section('title')
  TOP
@endsection

@section('content')
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
            <div class="col-lg-12 col-md-12">
              <div class="card" style="margin-top: 25px;">
                <div class="card-header card-header-tabs card-header-default">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <span class="nav-tabs-title">AI判定確信度遷移:</span>
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
                  <div class="tab-content">
                    <div id="chart_ai" style="width: 90%; height: 300px;"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script type="text/javascript" src="https://www.google.com/jsapi"></script>
      <script type="text/javascript">
        google.load('visualization', '1', { packages : [ 'corechart' ]});
        google.setOnLoadCallback(drawChart);
        
        function drawChart(){
          // 表示するデータの設定
          var data = new google.visualization.DataTable({
            "cols": [
              {"type": "string", "label": "日"},
              {"type": "number", "label": "AI学習数"},
              {"type": "number", "label": "AI判定平均確信度"}
            ],
            "rows": [
              {"c": [{"v": "1月8日"}, {"v": 2}, {"v": 79}]},
              {"c": [{"v": "1月9日"}, {"v": 0}, {"v": 69}]},
              {"c": [{"v": "1月10日"},{"v": 3}, {"v": 75}]},
              {"c": [{"v": "1月11日"},{"v": 5}, {"v": 61}]},
              {"c": [{"v": "1月12日"},{"v": 0}, {"v": 89}]},
              {"c": [{"v": "1月13日"},{"v": 0}, {"v": 93}]},
              {"c": [{"v": "1月14日"},{"v": 3}, {"v": 90}]},
              {"c": [{"v": "1月15日"},{"v": 1}, {"v": 97}]},
              {"c": [{"v": "1月16日"},{"v": 2}, {"v": 89}]},
              {"c": [{"v": "1月17日"},{"v": 2}, {"v": 83}]},
              {"c": [{"v": "1月18日"},{"v": 5}, {"v": 93}]},
              {"c": [{"v": "1月19日"}, {"v": 2}, {"v": 79}]},
              {"c": [{"v": "1月20日"}, {"v": 0}, {"v": 69}]},
              {"c": [{"v": "1月21日"},{"v": 3}, {"v": 75}]},
              {"c": [{"v": "1月22日"},{"v": 5}, {"v": 61}]},
              {"c": [{"v": "1月23日"},{"v": 0}, {"v": 89}]},
              {"c": [{"v": "1月24日"},{"v": 0}, {"v": 93}]},
              {"c": [{"v": "1月25日"},{"v": 3}, {"v": 90}]},
              {"c": [{"v": "1月26日"},{"v": 1}, {"v": 97}]},
              {"c": [{"v": "1月27日"},{"v": 2}, {"v": 89}]},
              {"c": [{"v": "1月28日"},{"v": 2}, {"v": 83}]},
              {"c": [{"v": "1月29日"},{"v": 5}, {"v": 93}]},
              {"c": [{"v": "1月30日"}, {"v": 2}, {"v": 79}]},
              {"c": [{"v": "1月31日"}, {"v": 0}, {"v": 69}]},
              {"c": [{"v": "2月1日"},{"v": 3}, {"v": 75}]},
              {"c": [{"v": "2月2日"},{"v": 5}, {"v": 61}]},
              {"c": [{"v": "2月3日"},{"v": 0}, {"v": 89}]},
              {"c": [{"v": "2月4日"},{"v": 0}, {"v": 93}]},
              {"c": [{"v": "2月5日"},{"v": 3}, {"v": 90}]},
              {"c": [{"v": "2月5日"},{"v": 1}, {"v": 97}]},
              {"c": [{"v": "2月6日"},{"v": 2}, {"v": 89}]},
              {"c": [{"v": "2月7日"},{"v": 2}, {"v": 83}]},
              {"c": [{"v": "2月8日"},{"v": 5}, {"v": 93}]},
              {"c": [{"v": "2月9日"}, {"v": 2}, {"v": 79}]},
              {"c": [{"v": "2月10日"},{"v": 3}, {"v": 75}]},
              {"c": [{"v": "2月11日"},{"v": 5}, {"v": 61}]},
              {"c": [{"v": "2月12日"},{"v": 0}, {"v": 89}]},
              {"c": [{"v": "2月13日"},{"v": 0}, {"v": 93}]},
              {"c": [{"v": "2月14日"},{"v": 3}, {"v": 90}]},
              {"c": [{"v": "2月15日"},{"v": 1}, {"v": 97}]},
              {"c": [{"v": "2月16日"},{"v": 2}, {"v": 89}]},
              {"c": [{"v": "2月17日"},{"v": 2}, {"v": 83}]},
              {"c": [{"v": "2月18日"},{"v": 5}, {"v": 93}]},
              {"c": [{"v": "2月19日"}, {"v": 2}, {"v": 79}]},
              {"c": [{"v": "2月20日"},{"v": 3}, {"v": 75}]},
              {"c": [{"v": "2月21日"},{"v": 5}, {"v": 61}]},
              {"c": [{"v": "2月22日"},{"v": 0}, {"v": 89}]},
              {"c": [{"v": "2月23日"},{"v": 0}, {"v": 93}]},
              {"c": [{"v": "2月24日"},{"v": 3}, {"v": 90}]},
              {"c": [{"v": "2月25日"},{"v": 1}, {"v": 97}]},
              {"c": [{"v": "2月26日"},{"v": 2}, {"v": 89}]},
              {"c": [{"v": "2月27日"},{"v": 2}, {"v": 83}]},
              {"c": [{"v": "2月28日"},{"v": 5}, {"v": 93}]},
              {"c": [{"v": "3月1日"},{"v": 3}, {"v": 75}]},
              {"c": [{"v": "3月2日"},{"v": 5}, {"v": 61}]},
              {"c": [{"v": "3月3日"},{"v": 0}, {"v": 89}]},
              {"c": [{"v": "3月4日"},{"v": 0}, {"v": 93}]},
              {"c": [{"v": "3月5日"},{"v": 3}, {"v": 90}]},
              {"c": [{"v": "3月5日"},{"v": 1}, {"v": 97}]},
              {"c": [{"v": "3月6日"},{"v": 2}, {"v": 89}]},
              {"c": [{"v": "3月7日"},{"v": 2}, {"v": 83}]},
              {"c": [{"v": "3月8日"},{"v": 5}, {"v": 93}]}
            ]});
        
          // グラフの設定
          var option = {
              width: '100%',
              height: '100%',
              focusTarget: 'category',
              series: [
                  { type: 'bars', targetAxisIndex: 0 },
                  { type: 'line', targetAxisIndex: 1 },
                  { type: 'area', targetAxisIndex: 2 }
              ],
              vAxes: [
                { title: 'AIトレーニング数 [回]' },
                { title: 'AI判定平均確信度 [%/日]' },
                { title: '日' }
              ]
          };
        
          var chart = new google.visualization.ComboChart(document.getElementById('chart_ai'));
          chart.draw(data, option);
        }
        $(window).resize(function(){
          chart.draw(data, option);
        });
      </script>
@endsection