<?php
$query=mysql_query("SELECT * from office");
$r_office = mysql_fetch_array($query);?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?= $r_office['office_name']?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- bootstrap 3.0.2 -->
    <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- font Awesome -->
    <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="../css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- DATA TABLES -->
    <link href="../css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="../css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <!-- Popup Modal -->
    <link href="../css/popModal.css" type="text/css" rel="stylesheet" >
    <!-- Preview -->
    <link href="../css/preview.css" type="text/css" rel="stylesheet" >
    <!-- iCheck for checkboxes and radio inputs -->
    <link href="../css/iCheck/all.css" rel="stylesheet" type="text/css" />
    <!-- daterange picker -->
    <link href="../css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <!-- Bootstrap time Picker -->
    <link href="../css/timepicker/bootstrap-timepicker.min.css" rel="stylesheet"/>
    <!-- datepicker -->
    <link href="../css/datepicker/datepicker.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="../css/style_table.css" />
    <!-- tooltip -->
    <link rel="stylesheet" type="text/css" href="../css/tooltip/tooltip-classic.css" />
    <!-- button component-->
    <link rel="stylesheet" type="text/css" href="../css/button_component/component.css" />
    <link rel="stylesheet" type="text/css" href="../css/button_component/content.css" />
    <!-- lookup -->
    <link rel="stylesheet" type="text/css" href="../css/lookup/bootstrap-select.css">
    <!-- Button -->
    <link rel="stylesheet" type="text/css" href="../css/button/component.css" />
    <!-- tooptip meja -->
    <link rel="stylesheet" type="text/css" href="../css/tooltip/tooltip-classic.css" />
    <!-- jQuery 2.0.2 -->
    <script src="../js/jquery.js"></script>
    <script src="../js/function.js" type="text/javascript"></script>
    <!-- Bootstrap -->
    <script src="../js/bootstrap.min.js" type="text/javascript"></script>
    <!-- DATA TABES SCRIPT -->
    <script src="../js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="../js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
    <script src="../js/plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- select -->
    <script type="text/javascript" src="../js/lookup/bootstrap-select.js"></script>
  </head>
  <body class="skin-blue">
    <div class="header_fixed">
      <div class="morph-button morph-button-modal morph-button-modal-3 morph-button-fixed">
        <button class="blue_color_button" type="button" onClick="winBack()">kembali</button>
      </div><!-- morph-button -->
    <div class="logo_order"></div>
    </div>
  <br>
  <br>
  <br>
  <br>
    <section class="content">
    <div class="container">
      <div class="row">
        <div class="col-md-6 col-md-offset-1">
          <div class="box_payment">
            <div class="payment_title">BAYAR RETUR</div>
            <div class="box-body2 table-responsive">
              <form action="<?= $action?>" method="post" enctype="multipart/form-data" role="form" novalidate>
              <input type="hidden" name="i_transaction_id" id="i_transaction_id" value="<?= $transaction_id?>">
                <div>
                  <div class="row"  style="margin:10px;">
                    <div class="payment_group">
                    <b> Tipe Pembayaran</b>
                    <br>
                    <br>
                      <div id="payment_type">
                        <label class="blue" style="background-color: #eee;">
                          <input checked type="radio" name="i_payment_method" id="i_payment_method" value="1"
                          checked style="position: absolute; opacity: 0;" onclick="payment_method(1)">
                          <span  onclick="get_change(1)" id="i_span_1" class="i_span" style="background:#ccc;">
                            Cash
                          </span>
                        </label>
                      <label>
                        <input type="radio" name="i_payment_method" id="i_payment_method" style="position: absolute; opacity: 0;"
                        value="2" onclick="payment_method(2)">
                        <span  onclick="get_change(2)" id="i_span_2" class="i_span">
                          Debit
                        </span>
                      </label>
                      <label>
                        <input type="radio" name="i_payment_method" id="i_payment_method" style="position: absolute; opacity: 0;"
                        value="3" onclick="payment_method(3)">
                        <span  onclick="get_change(3)" id="i_span_3" class="i_span">
                          Transfer
                        </span>
                      </label>
                      </div>
                    </div>
                  <?php  if($r_member['member_id']!=0){?>
                    <div class="payment_group" id="i_supplier_v">
                      <div class="row">
                        <div class="col-md-8">
                        <div><label>Nama    : <?= $r_member['member_name'] ?></label></div>
                        <div><label>Alamat  : <?= $r_member['member_alamat'] ?></label></div>
                        <div><label>Telepon : <?= $r_member['member_phone'] ?></label></div>
                        <div><label>Ket :
                          <?php if ($r_member['lunas']==1){ ?>
                          lunas
                          <?php }elseif ($r_member['lunas']==2) {?>
                          Sudah Lunas
                          <?}else {?>
                          Lunas
                          <?} ?>
                        </label>
                        </div>
                        </div>
                      </div>
                    </div>
                  <?}?>
                    <div class="payment_group" id="bank_frame" style="display:none; width:100%;">
                      <b>Dari Bank</b>
                      <br>
                      <div class="row">
                        <div class="col-md-6" style="padding-left:0px; ">
                          <select id="i_bank_id" name="i_bank_id" size="1" class="selectpicker show-tick form-control"
                          data-live-search="true" style="min-height:100px;" onchange="from_bank()"/>
                            <option value="0"></option>
                            <?php
                            $q_bank = mysql_query("select * from banks order by bank_id");
                            while($r_bank = mysql_fetch_array($q_bank)){
                            ?>
                            <option value="<?= $r_bank['bank_id'] ?>"><?= $r_bank['bank_name']?></option>
                            <?php }  ?>
                          </select>
                        </div>
                        <div class="col-md-6" style="padding-left:0px;" id="bank_account_from">
                          <input type="text" name="i_bank_account" id="i_bank_account" class="form-control" value=""
                          placeholder="No Kartu" style="text-align:right; font-size:20px;"/>
                        </div>
                      </div>
                      <b>Menuju Bank</b>
                      <br>
                      <div class="row">
                        <div class="col-md-6" style="padding-left:0px; ">
                          <select name="i_bank_id_to" id="i_bank_id_to" size="1" class="selectpicker show-tick form-control"
                          data-live-search="true" style="min-height:100px;"/>
                            <option value="0"></option>
                            <?php
                            while($r_bank = mysql_fetch_array($q_bank_to)){
                            ?>
                            <option value="<?= $r_bank['bank_id'] ?>"><?= $r_bank['bank_name']?></option>
                          <?php }  ?>
                          </select>
                        </div>
                      <div class="col-md-6" style="padding-left:0px; " id="bank_account_to">
                      <input type="text" name="i_bank_account_to" id="i_bank_account_to" class="form-control"
                      placeholder="No Kartu" style="text-align:right; font-size:20px;"/>
                      </div>
                      </div>
                    </div>
                    <div class="col-md-12" style="padding:0px;">
                      <div id="penghitungan_frame" style="display:block;">
                        <div class="payment_group">
                          <div class="calc_title">
                            <b>Nominal</b>
                          </div>
                          <input required type="text" name="i_payment_currency" id="i_payment_currency" class="form-control calc_nominal"
                          value="<?= format_rupiah($total)?>" style="text-align:right; font-size:20px;"/>
                          <input required type="hidden" name="i_payment" id="i_payment" class="form-control calc_nominal"
                          value="<?= $total?>" style="text-align:right; font-size:20px;"/>
                          <input type="hidden" id="i_grand_total" name="i_grand_total" value="<?= $total?>">
                        </div>
                        <div class="payment_group">
                          <div class="calc_title">
                            <b>Kembalian</b>
                          </div>
                          <input required type="text" name="i_change_currency" id="i_change_currency" class="form-control calc_nominal"
                          value="0" style="text-align:right; font-size:20px;"/>
                          <input required type="hidden" name="i_change" id="i_change" class="form-control calc_nominal"
                          value="0" style="text-align:right; font-size:20px;"/>
                        </div>
                      </div><!-- end penghitungan_frame -->
                      <table width="100%">
                        <tr>
                          <td colspan="5">
                            <button type="submit" class="btn button_save_payment btn-block">
                              <i class="fa fa-save"></i> Simpan
                            </button>
                          </td>
                          <td colspan="5" align="right">
                            <a href="<?= $close?>" class="btn button_close_payment">
                              <i class="fa fa-times-circle"></i>
                              close
                            </a>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div><!-- /.box -->
        </div>
        <div class="col-md-3">
          <div class="payment_widget_frame">
            <div class="payment_widget_header">
              <div style="margin-bottom:10px; font-size:20px;"><?= "No. Transaksi : " .$transaction_id ?></div>
              <div><?= $transaction_code?></div>
            </div>
            <div class="payment_widget_content">
              <div class="form-group">
                <div class="row">
                  <div class="form-group">
                    <a href="logout.php" class="btn payment_widget_button">Logout</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section><!-- /.content -->
  </body>
</html>
<script type="text/javascript">

var format = function(num){
  var str = num.toString().replace("Rp. ", ""), parts = false, output = [], i = 1, formatted = null;
  if(str.indexOf(".") > 0) {
    parts = str.split(".");
    str = parts[0];
  }
  str = str.split("").reverse();
  for(var j = 0, len = str.length; j < len; j++) {
    if(str[j] != ",") {
      output.push(str[j]);
      if(i%3 == 0 && j < (len - 1)) {
        output.push(",");
      }
      i++;
    }
  }

  formatted = output.reverse().join("");
  return("" + formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
};

$(function(){
    var grand_total = $('#i_grand_total').val();
    var kembali = 0;
    var price = 0;
    var str = 0;
    $("#i_payment_currency").keyup(function(e){
        price = $("#i_payment_currency").val();
        str = price.toString().replace(/[^0-9\.]+/g, "");
        $("#i_payment").val(str);
        $(this).val(format($(this).val()));
        if (str>grand_total) {
          kembali = str - grand_total;
        }

        if (str<grand_total) {
          alert("Pembayaran Tidak boleh");
        }

        $('#i_change_currency').val(format(kembali));
        $('#i_change').val(kembali);
    });
  });

  function get_change(id){
    var color = "#eee";
    $(".i_span").css("background-color", color);
    document.getElementById("i_span_"+id).style.backgroundColor = "#ccc";
  }

  function payment_method(id){
    window.methodpembayaran = id;
    var bank_frame = document.getElementById("bank_frame");
    penghitungan_frame.style.display = 'block';
    if(id == 1){
      bank_frame.style.display = 'none';
    }else if(id==2 || id==3){
      bank_frame.style.display = 'table';
    }
  }


  function winBack(){
    var x = document.getElementById('i_transaction_id').value;
    window.location.href = 'retur.php?page=kembali&id='+x;
  }

  $(document).ready(function () {
    $('#i_tgl').datepicker({
      format: "yyyy-mm-dd"
    });
  });

  function from_bank() {
    var x = document.getElementById('i_bank_id').value;
    $.ajax({
      type:'POST',
      data:{x:x},
      url:'retur.php?page=bank_to',
      dataType:'json',
      }).done(function(data){
      $('#bank_account_from').html("");
      $('#bank_account_from').append('<input type="text" name="i_bank_account" id="i_bank_account" class="form-control"\
      value='+data.data[0].bank_account_number+' placeholder="No Kartu" style="text-align:right; font-size:20px;" disabled/>\
      ');
    });
  }

</script>
