<div class="row">
	<?php
	$title = array(
	"Jumlah Hari",
	"Jumlah Pembelian",
	"Total Pembelian",
	"Jumlah Penjualan",
	"Total Penjualan",
	"Item Terlaris"
	);
		$content = array($jumlah_hari, $jumlah_pembelian, "<span style='font-size:20px'>Rp. </span>".
		$total_pembelian, $jumlah_penjualan, "<span style='font-size:20px'>Rp. </span>".$total_penjualan, $menu_terlaris);
		for($i=0; $i<=5; $i++){ ?>
			<div class="col-lg-3 col-xs-6" >
			<!-- small box -->
				<div  style="background-color:#FFF; ">
					<div class="box box-primary" style="padding:10px; height:100px;">
						<?php
						if($i==3){ ?>
							<span style="font-size:24px; font-weight:bold;">
						<?php }else{ ?>
							<span style="font-size:24px; font-weight:bold;">
						<?php } ?>
						<?= $content[$i]?>
							</span>
							<p><?= $title[$i]?></p>
					</div>
				</div>
			</div><!-- ./col -->
		<?php } ?>
</div><!-- /.row -->
<div class="row">
	<div class="col-md-12">
		<div class="box">
			<div class="box-body2">
				<div style="text-align:center;">
					<label>Grafik Penjualan dan Pembelian Tahun <?php echo $tahun; ?></label>
				</div>
				<canvas id="lineChart" style="height: 346px;width: 1029px;"></canvas>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
// $(function(){
	function drawLineChart() {
			// Add a helper to format timestamp data
			Date.prototype.formatDDMMYYYY = function() {

				var Month = new Array();
						Month[0] = "Minggu";
						Month[1] = "Senin";
						Month[2] = "Selasa";
						Month[3] = "Rabu";
						Month[4] = "Kamis";
						Month[5] = "Jumat";
						Month[6] = "Sabtu";
						Month[7] = "Sabtu";

						var n = Month[this.getMonth()];
					return n;
			}

			function formatThousands(n, dp) {
				var s = ''+(Math.floor(n)), d = n % 1, i = s.length, r = '';
				while ( (i -= 3) > 0 ) { r = ',' + s.substr(i, 3) + r; }
				return s.substr(0, i + 3) + r + (d ? '.' + Math.round(d * Math.pow(10,dp||2)) : '');
			}

			var jsonData = $.ajax({
	                            url     : 'report_detail.php?page=grafik_transaksi',
	                            type    :'get',
	                            dataType: 'json',
	                          }).done(function (results) {

	                              var labels = [], data=[], data2=[];
	                              for(var inn = 0; inn < results.data.length; inn++){
	                                labels.push(results.data[inn].bulan);
	                                data.push(parseFloat(results.data[inn].total_penjualan));
	                                data2.push(parseFloat(results.data[inn].total_pembelian));
	                              };
																//Create the chart.js data structure using 'labels' and 'data'
																var tempData = {
																	labels : labels,
																	datasets : [{
																						 label : "Penjualan",
																						 fillColor: "rgba(196, 239, 242, 0.7)",
																						 strokeColor: "rgba(210, 214, 222, 1)",
																						 pointColor: "#0b3780",
																						 pointStrokeColor: "#0b3780",
																						 pointHighlightFill: "#fff",
																						 pointHighlightStroke: "rgba(220,220,220,1)",
																						 data: data,
																	},
																	{          label : "Pembelian",
																						 fillColor: "rgba(238, 154, 154, 0.29)",
																						 strokeColor: "rgba(210, 214, 222, 1)",
																						 pointColor: "#d00000",
																						 pointStrokeColor: "#d00000",
																						 pointHighlightFill: "#fff",
																						 pointHighlightStroke: "rgba(220,220,220,1)",
																						 data: data2,
																	},
																]
																};
																var areaChartOptions = {
																			//Boolean - If we should show the scale at all
																			showScale: true,
																			//Boolean - Whether grid lines are shown across the chart
																			scaleShowGridLines: true,
																			//String - Colour of the grid lines
																			scaleGridLineColor: "rgba(8, 4, 139, 0.08)",
																			//Number - Width of the grid lines
																			scaleGridLineWidth: 1,
																			//Boolean - Whether to show horizontal lines (except X axis)
																			scaleShowHorizontalLines: true,
																			//Boolean - Whether to show vertical lines (except Y axis)
																			scaleShowVerticalLines: true,
																			scaleFontSize: 16,
																			//Boolean - Whether the line is curved between points
																			bezierCurve: true,
																			//Number - Tension of the bezier curve between points
																			bezierCurveTension: 0.3,
																			//Boolean - Whether to show a dot for each point
																			pointDot: true,
																			//Number - Radius of each point dot in pixels
																			pointDotRadius: 4,
																			//Number - Pixel width of point dot stroke
																			pointDotStrokeWidth: 2,
																			//Number - amount extra to add to the radius to cater for hit detection outside the drawn point
																			pointHitDetectionRadius: 20,
																			//Boolean - Whether to show a stroke for datasets
																			datasetStroke: true,
																			//Number - Pixel width of dataset stroke
																			datasetStrokeWidth: 3,
																			//Boolean - Whether to fill the dataset with a color
																			datasetFill: true,
																			//String - A legend template
																			legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
																			//Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
																			maintainAspectRatio: true,
																			//Boolean - whether to make the chart responsive to window resizing
																			responsive: true,
																			limitLines: [
																										{
																												label: 'max',
																												value: 17,
																												color: 'rgba(255, 0, 0, .8)'
																										},
																										{
																												label: 'min',
																												value: 1
																										},
																										{
																												value: 7,
																												color: 'rgba(0, 255, 255, .8)'
																										}
																								]
																		};
																		//Get the context of the canvas element we want to select
																		var ctx = document.getElementById("lineChart").getContext("2d");

																		// Instantiate a new chart
																		var myLineChart = new Chart(ctx);
																		myLineChart.Line(tempData, areaChartOptions);
																});
		}

		drawLineChart();

	// });
</script>
