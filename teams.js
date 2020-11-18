var url_string = window.location.href;
var url = new URL(url_string);
var id = url.searchParams.get("id");
console.log(id);
var pivot = new WebDataRocks({
    container: "#wdr-component",
    toolbar: false,
    height: 380,
    width: "80%",
    report: {
    dataSource: {
       "dataSourceType": "csv",
        "filename": "https://user.credo.science/user-interface/particle_hunters/data/teams/"+id+".csv"
        // "filename": "https://credo.science/particle_hunters/test/teams_score.csv"
    },
    slice: {
        reportFilters: [
          { uniqueName: "color" }
        ],
				rows: [

          // s
          { uniqueName: "date" }
				],
				columns: [
          {}
				],
				measures: [
					{ uniqueName: "good" },
          { uniqueName: "all" },
          { uniqueName: "too_often" },
          { uniqueName: "bad" },
          { uniqueName: "time_work" },
          { uniqueName: "devices" }
				]
    }
  },
  reportcomplete: function() {
    pivot.off("reportcomplete");
    createFusionChart();
  }
});

function createFusionChart() {
	var chart = new FusionCharts({
		"type": "pie2d",
		"renderAt": "fusionchartContainer",
    "width": "80%",
    "height": 500
	});

	pivot.fusioncharts.getData({
    	type: chart.chartType()
	}, function(data) {
		chart.setJSONData(data);
    chart.setChartAttribute("theme", "candy"); // apply the FusionCharts theme
		chart.render();
	}, function(data) {
		chart.setJSONData(data);
    chart.setChartAttribute("theme", "candy"); // apply the FusionCharts theme
	});
}


// Plotly.d3.csv("https://raw.githubusercontent.com/plotly/datasets/master/finance-charts-apple.csv", function(err, rows){
Plotly.d3.csv("https://user.credo.science/user-interface/particle_hunters/data/teams/"+id+".csv", function(err, rows){

    function unpack(rows, key) {
    return rows.map(function(row) { return row[key]; });
  }
  
  
  var trace1 = {
    type: "scatter",
    mode: "lines",
    name: 'all detect',
    x: unpack(rows, 'data'),
    y: unpack(rows, 'all'),
    line: {color: '#17BECF'}
  }
  
  var trace2 = {
    type: "scatter",
    mode: "lines",
    name: 'good detect',
    x: unpack(rows, 'data'),
    y: unpack(rows, 'good'),
    line: {color: '#7F7F7F'}
  }
  
  var trace3 = {
    type: "scatter",
    mode: "lines",
    name: 'time_work',
    x: unpack(rows, 'data'),
    y: unpack(rows, 'time_work'),
    line: {color: '#000000'}
  }
  
  var data = [trace1,trace2,trace3];
  
  var layout = {
    title: 'Teams: '+id+', detection evry days',
    xaxis: {
      autorange: true,
      range: ['2020-10-21', '2020-11-31'],
      rangeselector: {buttons: [
          {
            count: 1,
            label: '1m',
            step: 'month',
            stepmode: 'backward'
          },
          {
            count: 6,
            label: '6m',
            step: 'month',
            stepmode: 'backward'
          },
          {step: 'all'}
        ]},
      rangeslider: {range: ['2020-10-21', '2020-11-6']},
      type: 'date'
    },
    yaxis: {
      autorange: true,
      range: [86.8700008333, 138.870004167],
      type: 'linear'
    }
  };
  
  Plotly.newPlot('myDiv', data, layout, {showSendToCloud: true});
  })
  