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
      <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
      <!-- bootstrap 3.0.2 -->
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
      <link href="../css/responsive/jquery-ui.css" rel="stylesheet">

      <script src="../assets/jquery-3.min.js"></script>

      <style media="screen">
        input.no-border{
          border: none;
        }
      </style>
    </head>
<body>
   <div class="header_fixed">
            <div class="morph-button morph-button-modal morph-button-modal-3 morph-button-fixed">
              <button class="blue_color_button"  type="button"  onClick="winBack()">KEMBALI</button>
            </div><!-- morph-button -->
            <!-- <div class="logo_order"></div> -->
   </div>
  <br>
  <br>
<section class="content">
  <div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-1">
            <div class="box_payment">
             <div class="payment_title">BAYAR</div>
                <div class="box-body2 table-responsive">
                   <form id="form1" name="form1" method="post" enctype="multipart/form-data" role="form" novalidate>
                     <input type="hidden" id="i_member" name="i_member" value="<?= $i_member_id?>">
                     <div>
                        <div class="row"  style="margin:10px;">
                          <div class="payment_group">
                           <b> Tipe Pembayaran</b>
                            <br>
                            <br>
                            <input type="hidden" id="branch_id" name="branch_id" value="<?= $i_branch_id?>">
                             <div id="payment_type">
                                <label class="blue" style="background-color: #eee;">
                                 <input type="radio" name="i_payment_method" id="i_payment_method" value="1"
                                   onclick="payment_method(1)" style="position: absolute; opacity: 0;" checked>
                                 <span  onclick="get_change(1)" id="i_span_1" class="i_span"  style="background:#ccc;">
                                   Cash
                                 </span>
                                </label>
                                <label>
                                  <input style="position: absolute; opacity: 0;" type="radio"
                                  name="i_payment_method" id="i_payment_method" value="2" onclick="payment_method(2)">
                                  <span  onclick="get_change(2)" id="i_span_2" class="i_span">
                                    Debit
                                  </span>
                                </label>
                                <label>
                                    <input style="position: absolute; opacity: 0;" type="radio"
                                    name="i_payment_method" id="i_payment_method" value="3" onclick="payment_method(3)">
                                    <span  onclick="get_change(3)" id="i_span_3" class="i_span">
                                      Transfer
                                    </span>
                                </label>
                                <?php if($i_member_id > 0) {
                                  ?>
                                  <label>
                                      <input style="position: absolute; opacity: 0;" type="radio" name="i_payment_method"
                                      id="i_payment_method" value="5" onclick="payment_method(5)">
                                      <span onclick="get_change(5)" id="i_span_5" class="i_span">
                                        Angsuran
                                      </span>
                                  </label>
                                <?php } ?>
                              </div>
                          </div>
                          <div class="payment_group" id="bank_frame" style="display:none; width:100%;">
                            <!-- <div class="payment_group" id="bank_frame" style="width:100%;"> -->
                             <b> Bank</b>
                              <br>
                              <br>
                              <label>Dari :</label>
                              <div class="row">
                              <div class="col-md-6" style="padding-left:0px; ">
                               <select id="basic" name="i_bank_id" size="1" class="selectpicker show-tick form-control"
                               data-live-search="true" style="min-height:100px;">
                               <option value="0"></option>
                                   <?php
                                   $q_bank = mysql_query("select * from banks order by bank_id");
                                   while($r_bank = mysql_fetch_array($q_bank)){
                                    ?>
                                     <option value="<?= $r_bank['bank_id'] ?>"><?= $r_bank['bank_name']?></option>
                                     <?php }  ?>
                                   </select>
                                 </div>
                                 <div class="col-md-6" style="padding-left:0px; ">
                                    <input type="text" name="i_bank_account" id="i_bank_account" class="form-control" value=""
                                    placeholder="" style="text-align:right; font-size:20px;"/>
                                 </div>
                               </div>
                               <br>
                                <label>Menuju :</label>
                               <div class="row">
                               <div class="col-md-6" style="padding-left:0px; ">
                                <select id="i_bank_id_to" name="i_bank_id_to" size="1" class="selectpicker show-tick form-control"
                                data-live-search="true" style="min-height:100px;" onchange="bank_to()" />
                                  <option value="0"></option>
                                    <?php
                                    $q_bank = mysql_query("select * from banks order by bank_id");
                                    while($r_bank = mysql_fetch_array($q_bank)){?>
                                      <option value="<?= $r_bank['bank_id'] ?>"><?= $r_bank['bank_name']?></option>
                                      <?php }  ?>
                                </select>
                                  </div>
                                  <div class="col-md-6" style="padding-left:0px;" id="bank_account_to">
                                     <input type="text" name="" id="" class="form-control" value="" placeholder=""
                                     style="text-align:right; font-size:20px;" readonly/>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-12" style="padding:0px;">
                                <div id="penghitungan_frame" style="display:;">
                                  <div class="payment_group">
                                    <div class="calc_title">
                                    <b>Nominal</b>
                                    </div>
              											<input type="hidden" id="i_transaction_id" name="i_transaction_id" value="<?= $transaction_id ?>"/>

                                    <input type="text" name="i_payment_currency" id="i_payment_currency"
                                    class="form-control calc_nominal" value="<?= format_rupiah($totalkedua) ?>"
                                    style="text-align:right; font-size:50px;height:60px;" onchange="get_nominal()"/>

              											<input type="hidden" id="i_payment" name="i_payment"
                                    class="form-control calc_nominal" value="<?= $totalkedua?>"
                                    style="text-align:right; font-size:50px;height:60px;"/>

              											<div class="row" style="margin-top:10px;">
              												<div class="col-md-5" style="padding:0px;">
              													  <div>
                														<div class="col-md-6" style="padding:0px; padding-right:2px; padding-bottom:2px;">
                                              <div class="calc_button_right">S</div></div>
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
                														<div class="col-md-4" style="padding:0px;"><div class="calc_button"
                                              style="border-top-left-radius:5px;" onclick="add_non_numeric(1)">1</div>
                                            </div>
                														<div class="col-md-4" style="padding:0px;">
                                              <div class="calc_button"  onclick="add_non_numeric(2)">2</div>
                                            </div>
                														<div class="col-md-4" style="padding:0px;">
                                              <div class="calc_button" style="border-top-right-radius:5px;"  onclick="add_non_numeric(3)">3</div>
                                            </div>
              													  </div>
              													  <div>
                														<div class="col-md-4" style="padding:0px;">
                                              <div class="calc_button" onclick="add_non_numeric(4)">4</div>
                                            </div>
                														<div class="col-md-4" style="padding:0px;">
                                              <div class="calc_button" onclick="add_non_numeric(5)">5</div>
                                            </div>
                														<div class="col-md-4" style="padding:0px;">
                                              <div class="calc_button" onclick="add_non_numeric(6)">6</div>
                                            </div>
              													  </div>
              													  <div>
                														<div class="col-md-4" style="padding:0px;">
                                              <div class="calc_button" onclick="add_non_numeric(7)">7</div>
                                            </div>
                														<div class="col-md-4" style="padding:0px;">
                                              <div class="calc_button" onclick="add_non_numeric(8)">8</div>
                                            </div>
                														<div class="col-md-4" style="padding:0px;">
                                              <div class="calc_button" onclick="add_non_numeric(9)">9</div>
                                            </div>
              													  </div>
              													  <div>
                														<div class="col-md-4" style="padding:0px;">
                                              <div class="calc_button" style="border-bottom-left-radius:5px;" onclick="add_clear(0)">C</div>
                                            </div>
                														<div class="col-md-4" style="padding:0px;">
                                              <div class="calc_button"   onclick="add_non_numeric('0')">0</div>
                                            </div>
                														<div class="col-md-4" style="padding:0px;">
                                              <div class="calc_button" style="border-bottom-right-radius:5px;">.</div>
                                            </div>
              													  </div>
              												</div>
                                   </div>
                                </div>
                              </div><!-- end penghitungan_frame -->
                                <div class="payment_group">
                                  <table id="" class="" width="100%">
                                    <tbody>
                                    </tbody>
                                     <tfoot>
                                        <tr>
                                            <td colspan="2" width="50%">Total</td>
                                        </tr>
                                        <tr>
                                          <td colspan="3" style="text-align:right; font-size:20px;">
                                            <?= number_format($total_asli)?>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td colspan="3" style="text-align:right; " >
                                             <input required type="hidden" name="i_total" id="i_total"
                                             class="form-control" value="<?= $totalkedua?>" style="text-align:right; font-size:20px;"/>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>
                                            <div class="form-group">
                                              Diskon Nominal
                                              <input type="text" id="i_diskon_nominal_currency" name="i_diskon_nominal_currency"
                                              class="form-control" value="" style="text-align:right;">
                                              <input type="hidden" id="i_diskon_nominal" name="i_diskon_nominal" class="form-control" value="0">
                                            </div>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>
                                            <div class="form-group">
                                              Diskon Persen
                                              <input type="hidden" id="potongan_diskon_persen" name="potongan_diskon_persen" value="">
                                              <select class="selectpicker show-tick form-control" id="i_diskon_persen" name="i_diskon_persen"
                                              onchange="diskon_persen()" value="0">
                                                <option value="0"></option>
                                                <option value="2.5">2,5 %</option>
                                                <option value="3.5">3,5 %</option>
                                                <option value="5">5 %</option>
                                                <option value="10">10 %</option>
                                                <option value="15">15 %</option>
                                              </select>
                                            </div>
                                          </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" width="50%">Grand Total</td>
                                        </tr>
                                        <tr>
                                          <td colspan="3" style="text-align:right; font-size:20px;">
                                            <input type="text" id="i_grand_total_currency" name="i_grand_total" class="no-border"
                                            style="text-align:right;" value="<?= number_format($totalkedua)?>">
                                            <input required type="hidden" id="i_grand_total" name="i_grand_total"
                                            class="form-control" value="<?= $totalkedua?>" style="text-align:right; font-size:20px;"/>
                                          </td>
                                        </tr>
                                         <tr>
                                            <td colspan="2">Kembalian </td>
                                        </tr>
                                        <tr>
                                           <td colspan="3" style="text-align:right; ">
                                             <input type="hidden" name="i_change" id="i_change"
                                             class="form-control" value="0" style="text-align:right; font-size:20px;"/>
                                             <input type="text" name="i_change_currency" id="i_change_currency"
                                             class="form-control" value="0" style="text-align:right; font-size:20px;" readonly/>
                                            </td>
                                        </tr>
                                    </tfoot>
                                  </table>
                                </div>
                               <div class="col-md-12" style="padding:0px;">
                                 <div class="payment_group">
                                   <table style="width:100%;">
                                     <tr>
                                         <textarea id="transactions_desc" name="transactions_desc" style="width:100%"></textarea>
                                     </tr>
                                   </table>
                                 </div>
                               </div>
                               <div class="col-md-12">
                                 <div class="row">
                                   <div class="col-md-6">
                                     <button onclick="submitForm('transaction_new.php?page=save_payment&print_tipe=1')"
                                     value="submit 1" class="btn button_save_payment btn-block">
                                       <i class="fa fa-save"></i> Simpan Print
                                     </button>
                                   </div>
                                   <div class="col-md-6">
                                     <a href="<?= $close?>" class="btn button_close_payment">
                                       <i class="fa fa-times-circle"></i> Keluar
                                     </a>
                                   </div>
                                 </div>
                               </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div><!-- /.box -->
                    </div>
                    <div class="col-md-4">
                      <div class="payment_widget_frame">
                        <div class="payment_widget_header">
                          <div style="margin-bottom:10px; font-size:20px;">
                            <?= "No. Transaksi : " .$transaction_id ?>
                            <div class="form-group">
                              <label>Kode Transaksi : </label>
                              <?= $transaction_code?>
                            </div>
                          </div>
                        </div>
                        <div class="payment_widget_content">
                          <div class="payment_group" id="i_member_v" style="display:none;" >
                           <div class="row">
                            <div class="form-group">
                              <label>Nama Pembeli : </label>
                              <input type="text" name="" class="form-control no-border"
                              value="<?= strtoupper($row_member['member_name'])?>">
                            </div>
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

<!-- popmodal -->
<div id="large_popmodal" class="modal fade bs-example-modal-lg" tabindex="-1"
role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document" style="width:1200px;">
    <div class="modal-content" id="large_popmodal_content" style="border-radius:0;">

    </div>
  </div>
</div>
 <!-- page script -->
<script src="../js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
<script src="../assets/jquery-ui-1.12.1/jquery-ui.min.js" type="text/javascript"></script>
<script src="../js/lookup/bootstrap-select.js" type="text/javascript"></script>
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<script src="../js/function.js" type="text/javascript"></script>

<link rel="stylesheet" href="../css/gadai.css">
<script type="text/javascript">


$(function(){
  $("#i_diskon_nominal_currency").keyup(function(e){
      var price = $("#i_diskon_nominal_currency").val();

      var i_grand_total_currency = $('#i_grand_total_currency').val();
      var i_diskon_persen = $('#i_diskon_persen').val();

      if (i_diskon_persen != 0) {
        var i_total = $('#i_grand_total').val();
      } else {
        var i_total = $('#i_total').val();
      }
      var i_grand_total_remove_currency = i_grand_total_currency.toString().replace(/[^0-9\.]+/g, "");

      var kembali_currency = $('#i_change_currency').val();
      var kembali = $('#i_change').val(kembali);
      var kembali_remove_currency = kembali_currency.toString().replace(/[^0-9\.]+/g, "");

      var str = price.toString().replace(/[^0-9\.]+/g, "");

      $("#i_diskon_nominal").val(str);

      $("#i_diskon_nominal").val(str);
      $(this).val(format($(this).val()));

      var hasil_diskon_nominal = parseInt(i_total) - parseInt(str);
      console.log(i_grand_total);
      $('#i_grand_total').val(hasil_diskon_nominal);
      $('#i_grand_total_currency').val(format(hasil_diskon_nominal));
    });
  });

  function diskon_persen(){
    var i_diskon_persen = $('#i_diskon_persen').val();
    var i_diskon_nominal = $('#i_diskon_nominal').val();

    if (i_diskon_nominal != 0) {
        var i_total = $('#i_grand_total').val();
      } else {
        var i_total = $('#i_total').val();
      }

      var potongan_diskon_persen = parseInt(i_total) * parseInt(i_diskon_persen) / 100;
      var hasil_diskon_persen = parseInt(i_total) - parseInt(potongan_diskon_persen);

      $('#potongan_diskon_persen').val(potongan_diskon_persen);
      $('#i_grand_total').val(hasil_diskon_persen);
      $('#i_grand_total_currency').val(format(hasil_diskon_persen));
    }

    function get_change(id){
        var color = "#eee";
        var color_active = "#ccc";
        $(".i_span").css("background", color);
        $("#i_span_"+id).css("background", color_active);
      }

  function payment_method(id){
		window.methodpembayaran = id;
        var bank_frame = document.getElementById("bank_frame");
        var voucher_frame = document.getElementById("voucher_frame");
        var angsuran_frame = document.getElementById("angsuran_frame");
        var penghitungan_frame = document.getElementById("penghitungan_frame");
        var print_struk = document.getElementById("print_struk");
        print_struk
        penghitungan_frame.style.display = 'block';
        if(id == 1){
          bank_frame.style.display = 'none';
          penghitungan_frame.style.display = 'block';
        }else if(id==2 || id==3){
          bank_frame.style.display = 'table';
          penghitungan_frame.style.display = 'block';
        }else if(id==4){
          bank_frame.style.display = 'none';
          penghitungan_frame.style.display = 'block';
       }else if(id==5){
         validasi_item();
      }
    }

function validasi_item(){
  var id = $('#i_transaction_id').val();
  $.ajax({
    type: 'POST',
    url: 'transaction_new.php?page=validasi_item',
    data: {id:id},
    dataType: 'json',
  }).done(function(data) {
    if(data.jml == 1 && data.pcs == 1){
      angsuran_popmodal();
    } else {
      alert("Item lebih dari satu");
    }
  });
}

function angsuran_popmodal(){
  var id = $('#i_transaction_id').val();
  var payment_method_id = $('#i_payment_method').val();
  var branch_id = $('#branch_id').val();
  var i_member = $('#i_member').val();
  $('#large_popmodal').modal();
  var url = 'transaction_new.php?page=anguran_popmodal&id='+id+'&payment_method_id='+payment_method_id+
  '&branch_id='+branch_id+'&i_member='+i_member;
    $('#large_popmodal_content').load(url,function(result){
  });
}


	function winBack(){
        var x = document.getElementById('i_transaction_id').value;
        window.location.href = 'transaction_new.php?page=delete_transaction_tmp&id='+x;
	}
        var i = document.getElementById("i_member").value;
        var k = document.getElementById("i_member_v");
        if(i!=0)
        {
          k.style.display='block';
        }else {
          k.style.display='none';
        }
        $(document).ready(function () {

    				$('#i_tgl').datepicker({
    						format: "dd-mm-yyyy"
    				});
    		});

        function bank_to() {
          var x = document.getElementById('i_bank_id_to').value;
          $.ajax({
            type:'POST',
            data:{x:x},
            url:'transaction_new.php?page=bank_to',
            dataType:'json',
          }).done(function(data){
            $('#bank_account_to').html("");
            $('#bank_account_to').append('<input type="text" name="i_bank_account_to" id="i_bank_account_to"\
             class="form-control" value='+data.data[0].bank_account_number+' placeholder="" style="text-align:right;\
              font-size:20px;" disabled/>\
            ');
            });
        }

  $(document).ready(function(){
    $('#per_tanggal').daterangepicker({
        format: 'DD'
      });
  });

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

          $('#i_change_currency').val(toRp(kembali));
          $('#i_change').val(kembali);
      });
    });

    function get_nominal(){
      var i_payment     = $('#i_payment').val();
      var i_grand_total = $('#i_grand_total').val();
      if (i_payment<i_grand_total) {
        alert("Pembayaran Tidak Boleh Kurang dari Grand Total");
        $('#i_payment_currency').val(toRp(i_grand_total));
        $('#i_payment').val(i_grand_total);
      }
    }

    function submitForm(action){
    document.getElementById('form1').action = action;
    document.getElementById('form1').submit();
    }

    $(document).ready(function(){
      $('.selectpicker').selectpicker('refresh');
    });

</script>
