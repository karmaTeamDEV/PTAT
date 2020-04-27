<script type="text/javascript">

	Highcharts.setOptions({
		lang: {
			thousandsSep: ','
		},
		//colors: ['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4']
		colors: ['#5D96FF', '#FFD700', '#FF4500', '#8A2BE2', '#A52A2A', '#50B432', '#FF1493',  '#B8860B', '#006400',   '#D15C73','#00FF7F','#ADFF2F']
	});


function chart_stacked_column_from_table_reverse(render_div_id, data_table_id, stack_type, yaxis_lebel, show_data_leble, chart_title, lebel_rotate)
{
					
	Highcharts.visualize = function (table, options) {
		// the categories
		options.xAxis.categories = [];
		$('thead th:parent', table).each(function (i) {
			//if(i > 0){
				var month = $(this).text();
				options.xAxis.categories.push(month);
			//}
		});
		//console.log(options.xAxis.categories);
		// tthe data series
		options.series = [];
		$('tbody tr', table).each(function (i) {
			var tr = this;
			var tr_class = tr.className;
			console.log(tr_class);
			if(tr_class != 'exclude_chart'){
				var serie = {};
				serie.name = $('th', tr).text();
				serie.data = [];
				$('td', tr).each(function (j) {
					
					serie.data.push(parseFloat(this.innerHTML.replace(/,/g , '')));
				});
				options.series.push(serie);
			}
			
			
		});
		var chart = new Highcharts.Chart(options);
	};

	var table = document.getElementById(data_table_id),
	
		options = {
			chart: {
				renderTo: render_div_id,
				type: 'column'
			},
			credits: {
				 enabled: false
			},
			title: {
				text: chart_title
			},
			xAxis: {},
			yAxis: {
				allowDecimals: false,
				title: {
					text: yaxis_lebel
				}
			},
			 plotOptions: {
				column: {
					stacking: stack_type,
					dataLabels: {
						enabled: show_data_leble,
						rotation: lebel_rotate,
						color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
					}
				}
			},
			tooltip: {
				formatter: function () {
					return '<b>' + this.series.name + '</b><br/> <b>' +
						this.point.category + ':</b> ' + Math.round(this.percentage)+ '%<br/>' +
                '<b>Total:</b> ' + Highcharts.numberFormat(this.point.stackTotal, 0, '.', ',');
				}
			}
		};

	Highcharts.visualize(table, options);
								
}
/*  SHOW STACK CHART WHIT PERCENT LEBLE*/
function chart_stacked_column_from_table_percent(render_div_id, data_table_id, stack_type, yaxis_lebel, show_data_leble, chart_title, lebel_rotate)
{
					
	Highcharts.visualize = function (table, options) {
		// the categories
		options.xAxis.categories = [];
		$('thead th:parent', table).each(function (i) {
			var month = $(this).text();
			options.xAxis.categories.push(month);
		});
		//console.log(options.xAxis.categories);
		// tthe data series
		options.series = [];
		$($('tbody tr', table).get().reverse()).each(function (i) {
			var tr = this;
			var tr_class = tr.className;
			console.log(tr_class);
			if(tr_class != 'exclude_chart'){
				var serie = {};
				serie.name = $('th', tr).text();
				serie.data = [];
				$('td', tr).each(function (j) {
					
					serie.data.push(parseFloat(this.innerHTML.replace(/,/g , '')));
				});
				options.series.push(serie);
			}
			
			
		});
		var chart = new Highcharts.Chart(options);
	};

	var table = document.getElementById(data_table_id),
	
		options = {
			chart: {
				renderTo: render_div_id,
				type: 'column'
			},
			credits: {
				 enabled: false
			},
			title: {
				text: chart_title
			},
			xAxis: {},
			yAxis: {
				allowDecimals: false,
				/*reversedStacks: false,*/
				title: {
					text: yaxis_lebel
				}
			},
			 plotOptions: {
				column: {
					stacking: stack_type,
					dataLabels: {
						enabled: show_data_leble,
						rotation: lebel_rotate,
						format: '{point.percentage:.0f} %',
						color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'black'
					}
				}
			},
			tooltip: {
				formatter: function () {
					return '<b>' + this.series.name + '</b><br/> <b>' +
						this.point.category + ':</b> ' + Math.round(this.percentage)+ '%<br/>' +
                '<b>Total:</b> ' + Highcharts.numberFormat(this.point.stackTotal, 0, '.', ',');
				}
			}
		};

	Highcharts.visualize(table, options);
								
}

/* DRAW MIXED LINE AND COLUMN CHART. TR CLASS WILL SERISE TYPE*/				
function chart_line_column_from_table_reverse(render_div_id, data_table_id,  yaxis_lebel, show_data_leble, chart_title, hover_sufix)
{
					
	Highcharts.visualize = function (table, options) {
		// the categories
		options.xAxis.categories = [];
		$('thead th:parent', table).each(function (i) {
			var month = $(this).text();
			options.xAxis.categories.push(month);
		});
		//console.log(options.xAxis.categories);
		// tthe data series
		options.series = [];
		$('tbody tr', table).each(function (i) {
			var tr = this;
			
			//console.log(tr.className);
			
			var serie = {};
			serie.type = tr.className;
			serie.name = $('th', tr).text();
			serie.data = [];
			$('td', tr).each(function (j) {
				serie.data.push(parseFloat(this.innerHTML.replace(/[,%]/g , '')));
			});
			options.series.push(serie);
		});
		var chart = new Highcharts.Chart(options);
	};

	var table = document.getElementById(data_table_id),
	
		options = {
			chart: {
				renderTo: render_div_id
			},
			credits: {
				 enabled: false
			},
			title: {
				text: chart_title
			},
			xAxis: {},
			yAxis: {
				allowDecimals: false,
				title: {
					text: yaxis_lebel
				}
			},
			 plotOptions: {
				column: {
					
					dataLabels: {
						enabled: show_data_leble,
						color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'black'
					}
				}
			},
			tooltip: {
				formatter: function () {
					return '<b>' + this.series.name + '</b><br/>' +
						this.point.y + '' +hover_sufix + ' ' + this.point.category;
				}
			}
		};

	Highcharts.visualize(table, options);
								
}



/* DRAW SPEEDOMETER CHART*/				
function chart_speedometer(render_div_id, min_point, max_point, chart_title, meter_title, point1_start, point1_end, point1_color, point2_start, point2_end, point2_color, point3_start, point3_end, point3_color, series_name, series_value, hover_sufix)
{
					
					Highcharts.chart(render_div_id, {
					
						chart: {
							type: 'gauge',
							plotBackgroundColor: null,
							plotBackgroundImage: null,
							plotBorderWidth: 0,
							plotShadow: false
						},
						credits: {
							 enabled: false
						},
						title: {
							text: chart_title
						},
					
						pane: {
							startAngle: -150,
							endAngle: 150,
							background: [{
								backgroundColor: {
									linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
									stops: [
										[0, '#FFF'],
										[1, '#333']
									]
								},
								borderWidth: 0,
								outerRadius: '109%'
							}, {
								backgroundColor: {
									linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
									stops: [
										[0, '#333'],
										[1, '#FFF']
									]
								},
								borderWidth: 1,
								outerRadius: '107%'
							}, {
								// default background
							}, {
								backgroundColor: '#DDD',
								borderWidth: 0,
								outerRadius: '105%',
								innerRadius: '103%'
							}]
						},
					
						// the value axis
						yAxis: {
							min: min_point,
							max: max_point,
					
							minorTickInterval: 'auto',
							minorTickWidth: 1,
							minorTickLength: 10,
							minorTickPosition: 'inside',
							minorTickColor: '#666',
					
							tickPixelInterval: 30,
							tickWidth: 2,
							tickPosition: 'inside',
							tickLength: 10,
							tickColor: '#666',
							labels: {
								step: 2,
								rotation: 'auto'
							},
							title: {
								text: meter_title
							},
							plotBands: [{
								from: point1_start,
								to: point1_end,
								color: point1_color // green
							}, {
								from: point2_start,
								to: point2_end,
								color: point2_color // yellow
							}, {
								from: point3_start,
								to: point3_end,
								color: point3_color // red
							}]
						},
					
						series: [{
							name: series_name,
							data: [series_value],
							tooltip: {
								valueSuffix: hover_sufix
							}
						}]
					
					});
					
								
}


/* DRAW PIE CHART*/				
function chart_pie_from_table_reverse(render_div_id, data_table_id,  yaxis_lebel, show_data_leble, chart_title, hover_sufix)
{
	/*				
	Highcharts.visualize = function (table, options) {
		// the categories
		//options.xAxis.categories = [];
		options.series = [];
		var serie = {};
		serie.data = [];

		$('thead th:parent', table).each(function (i) {
			serie.name = $(this).text();
			//options.xAxis.categories.push(month);
		});
		//console.log(options.xAxis.categories);
		// tthe data series
		
		$('tbody tr', table).each(function (i) {
			var tr = this;
			
			//console.log(tr.className);
			
			
			
			
			$('td', tr).each(function (j) {
				serie.data.push(parseFloat(this.innerHTML.replace(/[,%]/g , '')));
			});
			
		});
		options.series.push(serie);
		var chart = new Highcharts.Chart(options);
	};*/
	
		Highcharts.visualize = function (table, options) {
		// the categories
		//options.xAxis.categories = [];
		$('thead th:parent', table).each(function (i) {
			var month = $(this).text();
			//options.xAxis.categories.push(month);
		});
		//console.log(options.xAxis.categories);
		// tthe data series
		options.series = [];
		options.series.data = [];
		$('tbody tr', table).each(function (i) {
			var tr = this;
			
			//console.log(tr.className);
			
			var serie = {};
			var serieData = {};
			//serie.type = tr.className;
			serieData.name = $('th', tr).text();
			serie.data = [];
			$('td', tr).each(function (j) {
				serieData.y = parseFloat(this.innerHTML.replace(/[,%]/g , ''));
				serie.data.push(serieData);
			});
			options.series.push(serie);
		});
		var chart = new Highcharts.Chart(options);
	};


	var table = document.getElementById(data_table_id),
	
		options = {
			chart: {
				renderTo: render_div_id
			},
			credits: {
				 enabled: false
			},
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie'
			},
			title: {
				text: 'Browser market shares January, 2015 to May, 2015'
			},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						format: '<b>{point.name}</b>: {point.percentage:.1f} %',
						style: {
							color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
						}
					}
				}
			}
		};

	Highcharts.visualize(table, options);
								
}
					

					
					/*					
            
						Highcharts.chart('ed_monthly_age', {
							data: {
								table: 'ed_monthly_age_table'
							},
							chart: {
								type: 'column'
							},
							credits: {
                           		 enabled: false
                        	},
							title: {
								text: ' '
							},
							yAxis: {
								allowDecimals: false,
								title: {
									text: 'Cost ($)'
								}
							},
							 plotOptions: {
								column: {
									stacking: 'normal',
									dataLabels: {
										enabled: true,
										color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
									}
								}
							},
							tooltip: {
								formatter: function () {
									return '<b>' + this.series.name + '</b><br/>' +
										this.point.y + ' ' + this.point.name.toLowerCase();
								}
							}
						});
					
					*/
					
</script>
    
