google.load('visualization', '1', { packages : [ 'corechart' ]});
google.setOnLoadCallback(drawChart);

function drawChart(){
  // 表示するデータの設定
  var data = new google.visualization.DataTable({
    "cols": [
      {"type": "string", "label": "日"},
      {"type": "number", "label": "歩数"},
      {"type": "number", "label": "消費カロリー"}
    ],
    "rows": [
      {"c": [{"v": "12月8日"}, {"v": 7432}, {"v": 2199}]},
      {"c": [{"v": "12月9日"}, {"v": 5474}, {"v": 2069}]},
      {"c": [{"v": "12月10日"},{"v": 5751}, {"v": 2075}]},
      {"c": [{"v": "12月11日"},{"v": 6037}, {"v": 2161}]},
      {"c": [{"v": "12月12日"},{"v": 7402}, {"v": 2359}]},
      {"c": [{"v": "12月13日"},{"v":  532}, {"v": 2023}]},
      {"c": [{"v": "12月14日"},{"v": 5188}, {"v": 2093}]},
      {"c": [{"v": "12月11日"},{"v": 6037}, {"v": 2161}]},
      {"c": [{"v": "12月12日"},{"v": 7402}, {"v": 2359}]},
      {"c": [{"v": "12月13日"},{"v":  532}, {"v": 2023}]},
      {"c": [{"v": "12月14日"},{"v": 5188}, {"v": 2093}]}
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
          { title: '歩数(歩)' },
          { title: '乗車時間（分）' }, 
          { title: '消費カロリー（kcal）' }
      ]
  };

  var chart = new google.visualization.ComboChart(document.getElementById('chart_ai'));
  chart.draw(data, option);
}
$(window).resize(function(){
  chart.draw(data, option);
});