@extends('layouts.dashboard.base')

@section('title')
  <a href="/">TOP</a>
  <span style="margin: 0 5px;"> ＞ </span> 
  API管理
@endsection

@section('content')
      <div class="content">
        <div class="container-fluid">
          @if (session('msg'))
            <script>
              $(function(){
                type = ['', 'info', 'danger','success', 'warning', 'rose', 'primary'];
                color = Math.floor((Math.random() * 6) + 1);

                $.notify({
                  icon: "notifications",
                  message: "{{ session('msg') }}"
                }, {
                  type: 'success',
                  timer: 1000,
                  placement: {
                    from: 'top',
                    align: 'right'
                  }
                });
              });
            </script>
          @endif
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header card-header-default">
                  <h4 class="card-title">利用中のAPI一覧</h4>
                  <p class="card-category">現在契約しているAPIの一覧です。追加のご要望はサイト運営までご連絡ください。</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class="text-info">
                        <th>No</th>
                        <th>API名</th>
                        <th>利用可否</th>
                        <th>ステータス</th>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1</td>
                          <td>景表法と薬機法の抵触リスクチェック</td>
                          <td>可</td>
                          <td>-</td>
                        </tr>
                        <tr>
                          <td>2</td>
                          <td>メディア画像内の文言チェック</td>
                          <td>不可</td>
                          <td>エラー1101（学習が行われていません）</td>
                        </tr>  
                      </tbody>
                    </table>
                    {{-- <button type="button" class="btn btn-danger">新規登録</button> --}}
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <ul class="nav nav-pills nav-pills-icons nav-pills-info" role="tablist">
                <li class="nav-item">
                  <a class="nav-link" href="#dashboard-1" role="tab" data-toggle="tab">
                    レスポンス例
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active" href="#schedule-1" role="tab" data-toggle="tab">
                    資格情報
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#tasks-1" role="tab" data-toggle="tab">
                    利用方法
                  </a>
                </li>
              </ul>
              <div class="tab-content tab-space">
                <div class="tab-pane active" id="dashboard-1">
                  Collaboratively administrate empowered markets via plug-and-play networks. Dynamically procrastinate B2C users after installed base benefits.
                  <br><br>
                  Dramatically visualize customer directed convergence without revolutionary ROI.
                  <br><br>
                  Dramatically visualize customer directed convergence without revolutionary ROI.
                  <br><br>
                  Dramatically visualize customer directed convergence without revolutionary ROI.
                  <br><br>
                  Dramatically visualize customer directed convergence without revolutionary ROI.
                  <br><br>
                  Dramatically visualize customer directed convergence without revolutionary ROI.
                  <br><br>
                  Dramatically visualize customer directed convergence without revolutionary ROI.
                  <br><br>
                  Dramatically visualize customer directed convergence without revolutionary ROI.
                  <br><br>
                  Dramatically visualize customer directed convergence without revolutionary ROI.
                  <br><br>
                  Dramatically visualize customer directed convergence without revolutionary ROI.
                  <br><br>
                  Dramatically visualize customer directed convergence without revolutionary ROI.
                  <br><br>
                  Dramatically visualize customer directed convergence without revolutionary ROI.
                  <br><br>
                  Dramatically visualize customer directed convergence without revolutionary ROI.
                  <br><br>
                  Dramatically visualize customer directed convergence without revolutionary ROI.
                  <br><br>
                  Dramatically visualize customer directed convergence without revolutionary ROI.
                  <br><br>
                  Dramatically visualize customer directed convergence without revolutionary ROI.
                  <br><br>
                  Dramatically visualize customer directed convergence without revolutionary ROI.
                  <br><br>
                  Dramatically visualize customer directed convergence without revolutionary ROI.
                  <br><br>
                  Dramatically visualize customer directed convergence without revolutionary ROI.
                  <br><br>
                  Dramatically visualize customer directed convergence without revolutionary ROI.
                </div>
                <div class="tab-pane" id="schedule-1">
                  Efficiently unleash cross-media information without cross-media value. Quickly maximize timely deliverables for real-time schemas.
                  <br><br>Dramatically maintain clicks-and-mortar solutions without functional solutions.
                </div>
                <div class="tab-pane" id="tasks-1">
                  Completely synergize resource taxing relationships via premier niche markets. Professionally cultivate one-to-one customer service with robust ideas.
                  <br><br>Dynamically innovate resource-leveling customer service for state of the art customer service.
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection