<?php

if(!$_SESSION['login']){
header("location: ../login.php");
}
?>
<?php
$query=mysql_query("SELECT * from office");
$r_office = mysql_fetch_array($query);?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?= $r_office['office_name']?></title>
<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<!-- font Awesome -->
<link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<!-- Ionicons -->
<link href="../css/ionicons.min.css" rel="stylesheet" type="text/css" />
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
<!-- tooltip -->
<link rel="stylesheet" type="text/css" href="../css/tooltip/tooltip-classic.css" />
<!-- button component-->
<link rel="stylesheet" type="text/css" href="../css/button_component/component.css" />
<link rel="stylesheet" type="text/css" href="../css/button_component/content.css" />
<!-- Button -->
<link rel="stylesheet" type="text/css" href="../css/button/component.css" />
<!-- tooptip meja -->
<link rel="stylesheet" type="text/css" href="../css/tooltip/tooltip-classic.css" />
<!-- select -->
<link rel="stylesheet" type="text/css" href="../css/lookup/bootstrap-select.css">
<link href="../select2/dist/css/select2.min.css" rel="stylesheet">

<script src="../assets/jquery-3.min.js"></script>
<link href="../css/responsive/jquery-ui.css" rel="stylesheet">
</head>
<body class="skin-blue">
<div class="header_fixed">
<div class="morph-button morph-button-modal morph-button-modal-3 morph-button-fixed">
<button class="blue_color_button" type="button" onClick="winBack()">KEMBALI</button>
</div><!-- morph-button -->
<div class="logo_order"></div>
</div>
<br>
<br>
<br>
<!-- header logo: style can be found in header.less -->
  <?php if(isset($_GET['err']) && $_GET['err'] == 1){ ?>
    <section class="content_new">
    <div class="alert alert-warning alert-dismissable">
    <i class="fa fa-warning"></i>
    <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
    <b>Simpan Gagal !</b>
    Pembayaran tidak boleh lebih kecil dari total
    </div>
    </section>
  <?php } ?>
<!-- Main content -->
<br>
  <section class="content">
    <div class="row">
      <div class="col-md-6 col-md-offset-1">
        <div class="box_payment">
          <div class="payment_title">BAYAR PEMBELIAN</div>
          <div class="box-body2 table-responsive">
          <form action="<?= $action1 ?>" method="post" enctype="multipart/form-data" role="form" novalidate>
            <input type="hidden" id="purchase_id" name="purchase_id" value="<?= $purchase_id?>">
            <div>
              <div class="row"  style="margin:10px;">
                <div class="payment_group">
                <b> Tipe Pembayaran</b>
                <br>
                <br>
                  <div id="payment_type">
                    <label class="blue" style="background-color: #eee;">
                      <input  checked type="radio" id="i_payment_method" name="i_payment_method" value="1"
                      style="position: absolute; opacity: 0;" onclick="payment_method(1)">
                      <span  onclick="get_change(1)" id="i_span_1" class="i_span" style="background:#ccc;">
                      Cash
                      </span>
                    </label>
                    <label>
                      <input style="position: absolute; opacity: 0;" type="radio" name="i_payment_method" id="i_payment_method"
                      value="2" onclick="payment_method(2)">
                      <span  onclick="get_change(2)" id="i_span_2" class="i_span">
                      Debit
                      </span>
                    </label>
                    <label>
                      <input style="position: absolute; opacity: 0;" type="radio" name="i_payment_method" id="i_payment_method"
                      value="3" onclick="payment_method(3)">
                      <span  onclick="get_change(3)" id="i_span_3" class="i_span">
                      Transfer
                      </span>
                    </label>
                    <?php if($i_supplier > 0) { ?>
                      <label>
                        <input style="position: absolute; opacity: 0;" type="radio" name="i_payment_method" id="i_payment_method"
                        value="5" onclick="payment_method(5)">
                        <span onclick="get_change(5)" id="i_span_5" class="i_span">
                        Angsuran
                        </span>
                      </label>
                    <?php } ?>
                  </div>
                </div>
                <div class="payment_group" id="bank_frame" style="display:none; width:100%;">
                  <b> Bank</b>
                  <br>
                  <br>
                  <label>Dari :</label>
                  <div class="row">
                    <div class="col-md-6" style="padding-left:0px; ">
                      <select id="i_bank_id" name="i_bank_id" size="1" class="selectpicker show-tick form-control"
                      data-live-search="true" style="min-height:100px;" onchange="from_bank()">
                        <option value="0"></option>
                        <?php
                        while($r_bank = mysql_fetch_array($q_bank)){ ?>
                        <option value="<?= $r_bank['bank_id'] ?>"><?= $r_bank['bank_name']?></option>
                        <?php }  ?>
                      </select>
                    </div>
                    <div class="col-md-6" style="padding-left:0px;" id="bank_account">
                      <input type="text" name="i_bank_account" id="i_bank_account" class="form-control" value=""
                      placeholder="" style="text-align:right; font-size:20px;"/>
                    </div>
                  </div>
                <br>
                  <label>Menuju :</label>
                  <div class="row">
                    <div class="col-md-6" style="padding-left:0px; ">
                      <select id="i_bank_id_to" name="i_bank_id_to" size="1" class="selectpicker show-tick form-control"
                      data-live-search="true" style="min-height:100px;">
                        <option value="0"></option>
                        <?php
                        while($r_bank_to = mysql_fetch_array($q_bank_to)){
                        ?>
                        <option value="<?= $r_bank_to['bank_id'] ?>">
                          <?= $r_bank_to['bank_name']?>
                        </option>
                        <?php }  ?>
                      </select>
                    </div>
                    <div class="col-md-6" style="padding-left:0px;" id="bank_account_to">
                      <input type="text" name="i_bank_account_to" id="i_bank_account_to" class="form-control"
                      value="" placeholder="" style="text-align:right; font-size:20px;"/>
                    </div>
                  </div>
                </div>
                <div class="col-md-12" style="padding:0px;display:;">
                  <div id="penghitungan_frame" style="display:;">
                    <div class="payment_group">
                      <div class="calc_title">
                        <b>Nominal</b>
                      </div>
                      <input required type="text"  id="i_payment_currency" name="i_payment_currency" class="form-control calc_nominal"
                      value="<?= format_rupiah($totalkedua) ?>" style="text-align:right; font-size:20px;" onChange="update_change()"/>
                      <input required type="hidden" id="i_payment" name="i_payment" class="form-control calc_nominal" value="<?= $totalkedua ?>"
                      style="text-align:right; font-size:20px;"/>
                      <div class="row" style="margin-top:10px;">
                        <div class="col-md-5" style="padding:0px;">
                          <div>
                            <div class="col-md-6" style="padding:0px; padding-right:2px; padding-bottom:2px;">
                              <div class="calc_button_right">S</div>
                            </div>
                            <div class="col-md-6" style="padding:0px; padding-right:2px; padding-bottom:2px;">
                              <div class="calc_button_right" onclick="add_clear(160000)">160</div>
                            </div>
                          </div>
                          <div>
                            <div class="col-md-6" style="padding:0px; padding-right:2px; padding-bottom:2px;">
                              <div class="calc_button_right" onclick="add_clear(200000)">200</div>
                            </div>
                            <div class="col-md-6" style="padding:0px; padding-right:2px; padding-bottom:2px;">
                              <div class="calc_button_right" onclick="add_clear(250000)">250</div>
                            </div>
                          </div>
                          <div>
                            <div class="col-md-6" style="padding:0px; padding-right:2px; padding-bottom:2px;">
                              <div class="calc_button_right" onclick="add_numeric(10000)">+10</div>
                            </div>
                            <div class="col-md-6" style="padding:0px; padding-right:2px; padding-bottom:2px;">
                              <div class="calc_button_right" onclick="add_numeric(20000)">+20</div>
                            </div>
                          </div>
                          <div>
                            <div class="col-md-6" style="padding:0px; padding-right:2px; padding-bottom:2px;">
                              <div class="calc_button_right" onclick="add_numeric(50000)">+50</div>
                            </div>
                            <div class="col-md-6" style="padding:0px; padding-right:2px; padding-bottom:2px;">
                              <div class="calc_button_right">Sisa</div>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-7" style="padding:0px;">
                          <div style="border-top-left-radius:5px; border-top-right-radius:5px;">
                            <div class="col-md-4" style="padding:0px;">
                              <div class="calc_button" style="border-top-left-radius:5px;" onclick="add_non_numeric(1)">1</div>
                            </div>
                            <div class="col-md-4" style="padding:0px;">
                              <div class="calc_button"  onclick="add_non_numeric(2)">2</div>
                            </div>
                            <div class="col-md-4" style="padding:0px;">
                              <div class="calc_button" style="border-top-right-radius:5px;" onclick="add_non_numeric(3)">3</div>
                            </div>
                          </div>
                          <div>
                            <div class="col-md-4" style="padding:0px;"><div class="calc_button" onclick="add_non_numeric(4)">4</div></div>
                            <div class="col-md-4" style="padding:0px;"><div class="calc_button" onclick="add_non_numeric(5)">5</div></div>
                            <div class="col-md-4" style="padding:0px;"><div class="calc_button" onclick="add_non_numeric(6)">6</div></div>
                          </div>
                          <div>
                            <div class="col-md-4" style="padding:0px;"><div class="calc_button" onclick="add_non_numeric(7)">7</div></div>
                            <div class="col-md-4" style="padding:0px;"><div class="calc_button" onclick="add_non_numeric(8)">8</div></div>
                            <div class="col-md-4" style="padding:0px;"><div class="calc_button" onclick="add_non_numeric(9)">9</div></div>
                          </div>
                          <div>
                            <div class="col-md-4" style="padding:0px;">
                              <div class="calc_button" style="border-bottom-left-radius:5px;" onclick="add_clear(0)">C</div>
                            </div>
                            <div class="col-md-4" style="padding:0px;">
                              <div class="calc_button" onclick="add_non_numeric('0')">0</div>
                            </div>
                            <div class="col-md-4" style="padding:0px;">
                              <div class="calc_button" style="border-bottom-right-radius:5px;">.</div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12" style="padding:0px;">
                      <div class="payment_group">
                        <table id="" class="" width="100%">
                          <tfoot>
                            <tr>
                              <td colspan="2" width="50%">Grand Total </td>
                            </tr>
                            <tr>
                              <td colspan="3" style="text-align:right; font-size:20px;" ><?= number_format($totalawal)?>
                              <input required type="hidden" name="i_total" id="i_total" class="form-control" value="<?= ($totalawal)?>"
                              style="text-align:right; font-size:30px; height:50px;" readonly/>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="3" style="text-align:right; " >
                                <input required type="hidden" name="i_grand_total" id="i_grand_total" class="form-control"
                                value="<?= $totalkedua?>" style="text-align:right; font-size:20px;" readonly/>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="3" style="text-align:right; " ></td>
                            </tr>
                            <tr>
                              <td colspan="2">Kembalian </td>
                            </tr>
                            <tr>
                              <td colspan="3" style="text-align:right; " >
                                <input required type="text" id="i_change_currency" name="i_change_currency" class="form-control"
                                value="0" style="text-align:right; font-size:20px;" readonly/>
                                <input required type="hidden" id="i_change" name="i_change" class="form-control"
                                value="0" style="text-align:right; font-size:20px;" readonly/>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="5" style="font-size:36px;"></td>
                            </tr>
                          </tfoot>
                        </table>
                      </div>
                    </div>
                  </div><!-- end penghitungan_frame -->
                  <div class="payment_group" id="angsuran_frame" style="display:none;width:98%;margin:10px; height:430px;">
                    <table style="width:100%;">
                      <tr>
                        <td colspan="2" width="50%">Total</td>
                      </tr>
                      <tr>
                        <td colspan="3" style="text-align:right; font-size:20px;" ><?= number_format($totalkedua)?>
                        <input required type="hidden" name="i_total_a" id="i_total_a" class="form-control"
                        value="<?= ($totalkedua)?>" style="text-align:right; font-size:30px; height:50px;" readonly/>
                        </td>
                      </tr>
                    </table>
                    <b>Angsuran</b>
                    <br><br>
                    Uang muka
                    <input id="uang_muka" name="uang_muka" type="number"
                    style="text-align:right;" class="form-control" onchnge="update_change_a()" required />
                    Sisa
                    <input name="uang_sisa" id="uang_sisa" type="number"
                    style="text-align:right;" disabled="hidden" class="form-control"/>
                    <div class="form-group">
                      <br>
                      <label>Tanggal Batas : </label>
                    <input  type="text" placeholder=""  name="i_tgl" id="i_tgl" class="form-control"/>
                    </div>
                    <input type="hidden" id="output" name="output"/>
                    <input type="hidden" id="output_sisa" name="output_sisa"/>
                    <input type="hidden" id="output_angsuran" name="output_angsuran"/>
                    <!-- <div class="input-group-btn"> -->
                    <br>
                  </div>
                  <div class="col-md-12" style="padding:0px;">
                    <div class="payment_group">
                      <label>Catatan</label>
                      <table style="width:100%;">
                        <tr>
                          <textarea id="purchase_desc" name="purchase_desc" style="width:100%"></textarea>
                        </tr>
                      </table>
                    </div>
                  </div>
                  <table width="100%">
                    <tr>
                      <td colspan="5">
                        <button type="submit" class="btn button_save_payment btn-block">
                          <i class="fa fa-save"></i> Simpan
                        </button>
                      </td>
                      <td colspan="5" align="right">
                        <a href="<?= $close?>" class="btn button_close_payment"><i class="fa fa-times-circle"></i> Keluar</a>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div><!-- /.box -->
      </div>
      <div class="col-md-3">
        <div class="payment_widget_frame">
          <div class="payment_widget_header">
            <div style="margin-bottom:10px; font-size:20px;"><?= "No. Transaksi : " .$purchase_id ?></div>
            <div><?= $purchases_code?></div>
            <!--<div><?= $row_code['transaction_code']?></div>-->
          </div>
          <div class="payment_widget_content">
            <div class="payment_group" id="i_supplier_v">
              <div class="row">
                <div class="col-md-12">
                  <?php
                  $q_supplier = mysql_query("SELECT * FROM suppliers WHERE supplier_id = '".$i_supplier."'");
                  $row_supplier = mysql_fetch_array($q_supplier);
                  ?>
                  <div class="form-group">
                    <label>Nama Supplier : </label>
                    <input type="text" name="" class="form-control no-border"
                    value="<?= strtoupper($row_supplier['supplier_name'])?>">
                  </div>
                  <div class="form-group">
                    <label>Alamat Supplier : </label>
                    <input type="text" name="" class="form-control no-border"
                    value="<?= strtoupper($row_supplier['supplier_addres'] ? $row_supplier['supplier_addres'] : "-")?>">
                  </div>
                  <div class="form-group">
                    <label>Telepon Supplier : </label>
                    <input type="text" name="" class="form-control no-border"
                    value="<?= strtoupper($row_supplier['supplier_phone'] ? $row_supplier['supplier_phone'] : "-")?>">
                  </div>
                </div>
              </div>
              <input type="hidden" name="i_supplier" value="<?=$i_supplier?>">
            </div>
          </div>
        </div>
      </div>
    </div>
  </section><!-- /.content -->
</body>
</html>

<script src="../js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
<script src="../assets/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
<script src="../js/lookup/bootstrap-select.js" type="text/javascript"></script>
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<script src="../js/function.js" type="text/javascript"></script>
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
  return(formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
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

document.getElementById('i_payment');
  $(document).each(function(){
    $(this).keyup(function(){
      var hargareal = $(i_total).val();
      var uangmuka = $(uang_muka).val();
      hargareal = $.isNumeric(hargareal)?hargareal:0;
      $("#uang_sisa").val(parseInt(hargareal)-parseInt(uangmuka));
      $("#output").val(parseInt(uangmuka));
      document.getElementById('output_sisa').value = document.getElementById('uang_sisa').value
    })
  });

  function update_change_a(a = 0){
    var bayar = parseFloat($("#uang_muka").val());
    if(a == 0){
    var total = parseFloat($("#i_total_a").val());
    } else { var total = a; }
    if(bayar > total ){
      alert("Kelebihan");
      $("#uang_muka").val(0);
      kembali = 0;
    } else {
      kembali = total - bayar;
    }
    $("#uang_sisa").val(kembali);
    document.getElementById('output_sisa').value = document.getElementById('uang_sisa').value
  }

  function get_change(id){
    var color = "#eee";
    $(".i_span").css("background-color", color);
    document.getElementById("i_span_"+id).style.backgroundColor = "#ccc";
  }

  function update_change(){
    // var bayar = parseFloat($("#i_payment").val());
    //   var total = parseFloat($("#i_grand_total").val());
    //   var total = a;
    // if(bayar < total ){
    //   alert("Pembayaran tidak boleh lebih kecil dari Total Pembelian");
    //   kembali = 0;
    // } else {
    //   kembali = bayar - total;
    // }
    // $("#i_change").val(kembali);
  }

  function payment_method(id){
    window.methodpembayaran = id;
    var bank_frame = document.getElementById("bank_frame");
    var angsuran_frame = document.getElementById("angsuran_frame");
    var penghitungan_frame = document.getElementById("penghitungan_frame");
    penghitungan_frame.style.display = 'none';
    if(id == 1){
      bank_frame.style.display = 'none';
      angsuran_frame.style.display = 'none';
      penghitungan_frame.style.display = 'block';
    } else if(id==2 || id==3){
      bank_frame.style.display = 'table';
      angsuran_frame.style.display = 'none';
      penghitungan_frame.style.display = 'block';
    } else if(id==4){
      bank_frame.style.display = 'none';
      angsuran_frame.style.display = 'none';
      penghitungan_frame.style.display = 'block';
    } else if(id==5){
      bank_frame.style.display = 'block';
      angsuran_frame.style.display = 'block';
      penghitungan_frame.style.display = 'none';
    }
  }

  function winBack(){
    var x = document.getElementById('purchase_id').value;
    window.location.href = 'purchase.php?page=delete_purchases_tmp&id='+x;
  }

  $(document).ready(function () {
    $('#i_tgl').datepicker({
    format: "dd-mm-yyyy"
    });
  });

  function from_bank() {
    var x = document.getElementById('i_bank_id').value;
      $.ajax({
        type:'POST',
        data:{x:x},
        url:'purchase.php?page=bank_to',
        dataType:'json',
      }).done(function(data){
        $('#bank_account').html("");
        $('#bank_account').append('<input type="text" name="i_bank_account" id="i_bank_account"\
        class="form-control" value='+data.data[0].bank_account_number+' placeholder=""\
        style="text-align:right; font-size:20px;" disabled/>\
        ');
      });
  }
</script>
