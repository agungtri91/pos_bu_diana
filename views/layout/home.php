<?php
      $query=mysql_query("SELECT * from office");
      $r_img = mysql_fetch_array($query);
      $gambar = $r_img['office_img'];
      ?>
<style>
  .img-office{
    background-image: image('<?= "../img/menu/".$gambar?>');
    width: auto;;
  }
  .center{
    text-align: center;
  }
</style>
  <?php
  if(isset($_GET['did']) && $_GET['did'] == 1){
  ?>
  <section class="content_new">
    <div class="alert alert-info alert-dismissable">
      <i class="fa fa-check"></i>
      <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
      <b>Sukses !</b>
      Simpan Berhasil
    </div>
  </section>
  <?php }else if(isset($_GET['did']) && $_GET['did'] == 2){ ?>
  <section class="content_new">
    <div class="alert alert-info alert-dismissable">
      <i class="fa fa-check"></i>
      <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
      <b>Sukses !</b>
      Edit Berhasil
    </div>
  </section>
  <?php }else if(isset($_GET['did']) && $_GET['did'] == 3){ ?>
  <section class="content_new">
    <div class="alert alert-info alert-dismissable">
      <i class="fa fa-check"></i>
      <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
      <b>Sukses !</b>
      Delete Berhasil
    </div>
  </section>
  <?php } ?>
                <!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
  <div class="row">
      <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-white home_back1">
              <div class="inner">
                  <h3>
                      <?= $date_now ?>
                  </h3>
                  <p>
                     Tanggal
                  </p>
              </div>
              <div class="icon home_icon1"></div>
          </div>
      </div><!-- ./col -->
      <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-white home_back2">
              <div class="inner">
                  <h3>
                      <?= $jumlah_penjualan ?>
                  </h3>
                  <p>
                      Jumlah Penjualan
                  </p>
              </div>
              <div class="icon home_icon2"></div>
          </div>
      </div><!-- ./col -->
      <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-white home_back2">
              <div class="inner">
                  <h3>
                      <?= $jumlah_pembelian ?>
                  </h3>
                  <p>
                      Jumlah Pembelian
                  </p>
              </div>
              <div class="icon home_icon2"></div>
          </div>
      </div><!-- ./col -->
  </div><!-- /.row -->
  <div class="row">
    <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-white home_back3">
            <div class="inner">
                <h3>
                    <?php echo "<span style='font-size:20px'>Rp. </span>".$total_omset ?>
                </h3>
                <p>
                    Total Omset
                </p>
            </div>
            <div class="icon home_icon3">
            </div>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-white home_back3">
            <div class="inner">
                <h3>
                    <?php echo "<span style='font-size:20px'>Rp. </span>".$total_pengeluaran ?>
                </h3>
                <p>
                    Total Pengeluaran
                </p>
            </div>
            <div class="icon home_icon3">
            </div>
        </div>
    </div><!-- ./col -->
    <div class="col-lg-4 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-white home_back4" >
            <div class="inner" style="height:90px;">
                <h3 style="font-size:16px;">
                   <?= $menu_terlaris?>
                </h3>
                <p>
                   Item Terlaris
                </p>
            </div>
            <div class="icon home_icon4"></div>
        </div>
    </div><!-- ./col -->
  </div>
  <div class="row">
    <div class="col-md-6" class="img-office">
      <div class="box">
        <div class="box-header" style="background-color:white;">
          <h1 class="box-title" style="color:black;">Grafik Penjualan & Pembelian</h3>
        </div>
        <div class="box box-info">
          <div class="box-body">
            <div class="chart">
              <canvas id="lineChart" style="height: 300px;width: 1241px;padding-top: 1px;
              padding-left: 17px;padding-right: 17px;"></canvas>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
      </div>
    </div>
    <div class="col-md-6" class="img-office">
      <div class="box">
        <div class="box-header" style="background-color:white;">
          <h1 class="box-title" style="color:black;">Grafik Item</h3>
        </div>
        <div class="box box-info">
          <div class="box-body">
            <div class="row">
              <div class="col-md-3">
                <label>Pilih Item : </label>
              </div>
            </div>
            <div class="form-group">
              <form method="post" id="order_form">
                <div class="col-md-9">
                  <!-- <label for="selogtype">Graph Type:</label> -->
                  <select name="item_id" id="item_id" class="selectpicker show-tick form-control" data-live-search="true">
                    <option value="0"></option>
                    <?php
                    while ($r_item = mysql_fetch_array($q_item)) {?>
                      <option value="<?= $r_item['item_id']?>"><?= $r_item['item_name']?></option>
                    <?}?>
                  </select>
                </div>
                <div class="col-md-3">
                   <div class="form-group">
                     <div class="input-group">
                       <input type="submit" name="btnorderchart" id="btnorderchart" class="btn btn-danger" value="Preview" />
                     </div><!-- /.input group -->
                   </div><!-- /.form group -->
                </div>
              </form>
            </div>
            <div id="ocanvas_frame" class="chart">
              <canvas id="ocanvas" style="height: 200px;width: 1241px;padding-top: 1px;
              padding-left: 17px;padding-right: 17px;"></canvas>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
      </div>
    </div>
  </div>
<!-- TOP Food-->
<div class="row">
      <div class="col-md-6">
          <form role="form" action="<?= $action?>" method="post">
          <div class="box box-primary">
              <div class="box-header">
                  <h3 class="box-title">Item Terlaris</h3>
              </div>
              <div class="box-body2 table-responsive">
              	<div class="col-md-9">
                  <div class="form-group">
                      <div class="input-group">
                          <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                          </div>
                          <input id="reservation" name="i_date" type="text" required class="form-control pull-left"
                          value="<?= $date_default?>"/>
                      </div><!-- /.input group -->
                  </div><!-- /.form group -->
                </div>
                 <div class="col-md-3">
                    <div class="form-group">
                      <div class="input-group">
                        <input class="btn btn-danger" type="submit" value="Preview"/>
                      </div><!-- /.input group -->
                    </div><!-- /.form group -->
                 </div>
                    <div style="clear:both;"></div>
                   <table id="item_terlaris_tb" class="table table-bordered table-striped">
                      <thead>
                          <tr>
                          <th width="5%">No</th>
                              <th>Nama Item</th>
                              <th>Qty</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php
                         $no = 1;
                         while($row_top_food = mysql_fetch_array($query_top_food)){ ?>
                          <tr <?php if($no == 1){ ?> class="top_food_tr"<?php } ?>>
                            <td><?php if($no == 1){ ?><div class="top_food"><?= $no ?></div><?php }else{ ?><?= $no ?><?php } ?></td>
                            <td><?= $row_top_food['item_name']?></td>
                            <td><?= $row_top_food['jumlah']?></td>
                          </tr>
                          <?php $no++; } ?>
                      </tbody>
                  </table>
              </div><!-- /.box-body -->
          </div><!-- /.box -->
     </form>
      </div>
<!-- stok limit -->
      <div class="col-md-6">
         <div class="box">
            <div class="box-header">
                  <h3 class="box-title">Stock Krisis</h3>
              </div>
              <div class="box-body2 table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                          <th>No</th>
                          <th>Item</th>
                          <th>Stok</th>
                          <th>Cabang</th>
                          <!-- <th>office</th> -->
                        </tr>
                    </thead>
                      <?php
                        $no=1;
                        $query_stock_limit = select_stock_limit($s_cabang);
                        while($row_stock_limit = mysql_fetch_array($query_stock_limit)){ ?>
                        <tr>
                          <td><?= $no?></td>
                          <td><?= ($row_stock_limit['item_name']); ?></td>
                          <td><?= $row_stock_limit['item_stock_qty']."(".$row_stock_limit['unit_name'].")"?></td>
                          <td><?= $row_stock_limit['branch_name']?></td>
                        </tr>
                        <?php $no++; } ?>
                  </table>
              </div><!-- /.box-body -->
          </div><!-- /.box -->
      </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="box">
        <div class="box-header">
            <h3 class="box-title">Piutang Terlambat</h3>
        </div>
        <div class="box-body2 table-responsive">
          <table id="example2" class="table table-bordered table-striped">
            <thead>
                <tr>
                  <th class="center" style="width:5%;">No</th>
                  <th class="center">Nama</th>
                  <th class="center">Bulan</th>
                  <th class="center">Tanggal Angsuran</th>
                  <th class="center">Periode</th>
                  <th class="center">Config.</th>
                </tr>
            </thead>
            <tbody id="tb_telat_body">

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section><!-- /.content -->
<script type="text/javascript">

$(document).ready(function(){
  var no = 1;
  $.ajax({
    type:'GET',
    url:'home.php?page=get_data_telat',
    dataType:'json',
  }).done(function(data){
    $('#tb_telat_body').html('');
    for (var i = 0; i < data.length; i++) {
      $('#tb_telat_body').append('\
      <tr>\
        <td class="center">'+no+'</td>\
        <td>'+data[i].nama+'</td>\
        <td class="center">'+data[i].bulan+'</td>\
        <td class="center">'+data[i].tanggal_angsuran_1+' - '+data[i].tanggal_angsuran_2+'</td>\
        <td class="center">'+data[i].periode_name+'</td>\
        <td class="center">\
          <a class="btn btn-default" href="angsuran.php?page=list_piutang_member&id='+data[i].member_id+'">\
            <i class="fa fa-search"></i>\
          </a>\
        </td>\
      </tr>\
      ')
    no++;}
    piutang_terlambat_msg();
  });
});

function piutang_terlambat_msg() {
  alert('Cek Kotak List Piutang');
}

$(function() {
  var uang_kasir = <?php echo $uang_kasir ?>;
  var log_out = <?php echo $log_out ?>;
  if ( uang_kasir != 0) {
      $(window).load(function()
      {
        $('#medium_modal').modal();
    		var url = 'home.php?page=home_popmodal&log_out='+log_out;
          $('#medium_modal_content').load(url,function(result){
        });
      });
  }
});

$(document).ready(function() {
$('#item_terlaris_tb').DataTable( {
    dom: 'Bfrtip',
    buttons: [

        {
            extend: 'pageLength'
        },
        {
            extend: 'copy'
        },
        {
            extend: 'excel'
        },
        {
            extend: 'pdf'
        }
    ],
    lengthMenu: [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
    ]
} );
} );

function drawLineChart() {
    // Add a helper to format timestamp data
    Date.prototype.formatDDMMYYYY = function() {

      var day = new Array();
          day[0] = "Minggu";
          day[1] = "Senin";
          day[2] = "Selasa";
          day[3] = "Rabu";
          day[4] = "Kamis";
          day[5] = "Jumat";
          day[6] = "Sabtu";

          var n = day[this.getDay()];
        return n;
    }

    function formatThousands(n, dp) {
      var s = ''+(Math.floor(n)), d = n % 1, i = s.length, r = '';
      while ( (i -= 3) > 0 ) { r = ',' + s.substr(i, 3) + r; }
      return s.substr(0, i + 3) + r + (d ? '.' + Math.round(d * Math.pow(10,dp||2)) : '');
    }

    var jsonData = $.ajax({
                            url     : 'home.php?page=grafik_transaksi',
                            type    :'get',
                            dataType: 'json',
                          }).done(function (results) {

                              var labels = [], data=[], data2=[];
                              for(var inn = 0; inn < results.data.length; inn++){
                                labels.push(new Date(results.data[inn].transaction_date).formatDDMMYYYY());
                                data.push(parseFloat(results.data[inn].transaction_grand_total));
                                data2.push(parseFloat(results.data[inn].purchase_total));
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


 $(function () {

   Date.prototype.formatDDMMYYYY = function() {
     var day = new Array();
         day[0] = "Minggu";
         day[1] = "Senin";
         day[2] = "Selasa";
         day[3] = "Rabu";
         day[4] = "Kamis";
         day[5] = "Jumat";
         day[6] = "Sabtu";

         var n = day[this.getDay()];
       return n;
   }

   $('#order_form').on('submit', function (e) {
     e.preventDefault();
    //  var jsonData =
     $.ajax({
         type: 'post',
         url: 'home.php?page=item_chart',
         async: false,
         data: $('#order_form').serialize(),
         dataType: 'json',
       }).done(function(result){
          $('#ocanvas').remove();
          $('#ocanvas_frame').append('<canvas id="ocanvas" style="height: 200px;width: 1241px;padding-top: 1px;\
          padding-left: 17px;padding-right: 17px;"></canvas>');
           var labels = [], data=[], data2=[], tanggal=[];
           for(var inn = 0; inn < result.length; inn++){
             labels.push(new Date(result[inn].tanggal).formatDDMMYYYY());
             data.push(parseFloat(result[inn].total_penjualan));
             data2.push(parseFloat(result[inn].total_pembelian));
           };
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
                      {
                          label : "Pembelian",
                          fillColor: "rgba(238, 154, 154, 0.29)",
                          strokeColor: "rgba(210, 214, 222, 1)",
                          pointColor: "#d00000",
                          pointStrokeColor: "#d00000",
                          pointHighlightFill: "#fff",
                          pointHighlightStroke: "rgba(220,220,220,1)",
                          data: data2,
                       },
            ],
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
                 legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++)\
                 {%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
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
               var ctx = document.getElementById("ocanvas").getContext("2d");
               // Instantiate a new chart
               var myLineChart = new Chart(ctx);
               myLineChart.Line(tempData, areaChartOptions);
             });
             return false;
           });
    });


</script>
