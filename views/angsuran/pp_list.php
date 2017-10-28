<?php
// BAYAR ANGSURAN PIUTANG
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
                <button class="blue_color_button"  type="button"  onClick="winBack()">Kembali</button>
              </div><!-- morph-button -->
              <div class="logo_order"></div>
     </div>
  <?php
  if(isset($_GET['err']) && $_GET['err'] == 1){ ?>
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
    <br>
    <br>
    <br>
    <section class="content">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-md-offset-1">
            <div class="box_payment">
              <div class="payment_title">BAYAR ANGSURAN PIUTANG</div>
                <div class="box-body2 table-responsive">
                  <form action="<?= $action?>" method="post" enctype="multipart/form-data" role="form" novalidate>
                    <input type="hidden" id="i_member" name="i_member" value="<?= $member_id?>">
                    <input type="hidden" id="kredit_id" name="kredit_id" value="<?=$kredit_id?>">
                    <input type="hidden" id="transaction_id" name="transaction_id" value="<?=$transaction_id?>">
                    <div>
                      <div class="row"  style="margin:10px;">
                        <div class="payment_group">
                        <b> Tipe Pembayaran</b>
                        <br>
                        <br>
                          <div id="payment_type">
                            <label class="blue" style="background-color: #eee;">
                              <input checked type="radio" name="i_payment_method" id="i_payment_method"
                              value="1" checked onclick="payment_method(1)" style="position: absolute; opacity: 0;">
                              <span  onclick="get_change(1)" id="i_span_1" class="i_span" style="background:#ccc;">Cash </span>
                            </label>
                          <label>
                            <input name="i_payment_method" id="i_payment_method" style="position: absolute; opacity: 0;"
                            type="radio" value="2" onclick="payment_method(2)">
                            <span  onclick="get_change(2)" id="i_span_2" class="i_span">Debit</span>
                          </label>
                            <label>
                              <input name="i_payment_method" id="i_payment_method" style="position: absolute; opacity: 0;"
                              type="radio" value="3" onclick="payment_method(3)">
                              <span  onclick="get_change(3)" id="i_span_3" class="i_span">Transfer</span>
                            </label>
                          </div>
                        </div>
                        <div class="payment_group" id="bank_frame" style="display:none; width:100%;">
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
                              while($r_bank = mysql_fetch_array($q_bank)){
                              ?>
                              <option value="<?= $r_bank['bank_id'] ?>"><?= $r_bank['bank_name']?></option>
                              <?php }  ?>
                              </select>
                            </div>
                            <div class="col-md-6" style="padding-left:0px; ">
                              <input type="text" name="i_bank_account" id="i_bank_account" class="form-control"
                              value="" placeholder="No Kartu" style="text-align:right; font-size:20px;"/>
                            </div>
                          </div>
                          <br>
                          <label>Menuju :</label>
                          <div class="row">
                            <div class="col-md-6" style="padding-left:0px; ">
                              <select id="i_bank_id_to" name="i_bank_id_to" size="1" class="selectpicker show-tick form-control"
                              data-live-search="true" style="min-height:100px;" onchange="bank_to()">
                              <option value="0"></option>
                              <?php while($r_bank_to = mysql_fetch_array($q_bank_to)){?>
                              <option value="<?= $r_bank_to['bank_id'] ?>"><?= $r_bank_to['bank_name']?></option>
                              <?php }  ?>
                              </select>
                            </div>
                            <div class="col-md-6" style="padding-left:0px; ">
                              <input type="text" name="i_bank_account_to" id="i_bank_account_to" class="form-control"
                              value="" placeholder="No Kartu" style="text-align:right; font-size:20px;" readonly/>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-12" style="padding:0px;">
                          <div id="penghitungan_frame" style="display:;">
                            <div class="payment_group">
                              <div class="calc_title">
                                <b>Nominal</b>
                              </div>
                            <input required type="text" name="i_payment_currency" id="i_payment_currency" class="form-control calc_nominal"
                            value="<?= format_rupiah($total_angsuran_bayar)?>" style="text-align:right; font-size:50px;height:60px;"/>
                            <input required type="hidden" name="i_payment" id="i_payment" class="form-control calc_nominal"
                            value="<?= $total_angsuran_bayar?>" style="text-align:right; font-size:50px;height:60px;"/>
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
                                  <td colspan="2" width="50%">Total Pengangsuran</td>
                                </tr>
                                <tr>
                                  <td colspan="3" style="text-align:right; font-size:20px;">
                                    <?= format_rupiah($total_angsuran_bayar)?>
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="3" style="text-align:right; " >
                                    <input required type="hidden" name="i_grand_total" id="i_grand_total"
                                    class="form-control" value="<?= $total_angsuran_bayar?>" style="text-align:right; font-size:20px;" readonly/>
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
                                    <input required type="text" name="i_change_currency" id="i_change_currency"
                                    class="form-control" value="0" style="text-align:right; font-size:20px;" readonly/>
                                    <input required type="hidden" name="i_change" id="i_change"
                                    class="form-control" value="0" style="text-align:right; font-size:20px;" readonly/>
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="5" style="font-size:36px;"></td>
                                </tr>
                              </tfoot>
                            </table>
                          </div>
                        </div>
                        <div class="payment_group" id="angsuran_frame" style="display:none; width:98%;margin:10px; height:430px;">
                          <table style="width:100%;">
                            <tr>
                              <td colspan="2" width="50%">Grand Total </td>
                            </tr>
                            <tr>
                              <td colspan="3" style="text-align:right; font-size:20px;" ><?= number_format($totalawal)?>
                                <input required type="hidden" name="i_total_a" id="i_total_a" class="form-control" value=""
                                style="text-align:right; font-size:30px; height:50px;" readonly/>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="2" width="50%">Tax (10%)</td>
                            </tr>
                            <tr>
                              <td colspan="3" style="text-align:right; font-size:20px;" >
                                <input required type="hidden" name="i_totaltax_a" id="i_totaltax_a" class="form-control" value=""
                                style="text-align:right; font-size:30px; height:50px;" readonly/>
                              </td>
                            </tr>
                          </table>
                          <b>Angsuran</b>
                          <br><br>
                          Uang muka
                          <input required type="number" style="text-align:right;" class="form-control" id="uang_muka"/>
                          <br>
                          Angsuran
                          <div class="input-group">
                            <div class="input-group-btn">
                              <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                              aria-expanded="false" style="width: 120px;">Cicilan <span class="caret" ></span></button>
                              <ul class="dropdown-menu">
                              <?php
                              $q_cicilan = mysql_query("SELECT * from angsuran");
                              while ($r_cicilan=mysql_fetch_array($q_cicilan)) { ?>
                              <li value="<?= $r_cicilan['id_angsuran']?>" class="text-center"><a><?= $r_cicilan['jml_angsuran']?></a></li>
                              <?php } ?>
                              </ul>
                            </div><!-- /btn-group -->
                          <input type="text" class="form-control" aria-label="..." id="uang_sisa">
                          </div><!-- /input-group -->
                          <br>
                          Tanggal Batas :
                          <input  type="text" placeholder=""  name="i_tgl" id="i_tgl" class="form-control"/>
                          <input type="hidden" id="output" name="output"/>
                          <input type="hidden" id="output_sisa" name="output_sisa"/>
                          <input type="hidden" id="output_angsuran" name="output_angsuran"/>
                          <input type="hidden" id="ax_a" name="ax_a"/>
                          <br>
                        </div>
                          <table width="100%">
                            <tr>
                              <td colspan="5">
                                <button type="submit" class="btn button_save_payment btn-block">
                                  <i class="fa fa-save"></i> Simpan
                                </button>
                              </td>
                              <td colspan="5" align="right">
                                <a href="home.php" class="btn button_close_payment"><i class="fa fa-times-circle"></i> close</a>
                              </td>
                            </tr>
                          </table>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
            </div><!-- /.box -->
            <div class="col-md-3">
              <div class="payment_widget_frame">
                <div class="payment_widget_header">
                  <div style="margin-bottom:10px; font-size:20px;"><?= "No. Transaksi : " .$transaction_code?></div>
                </div>
                <div class="payment_widget_content">
                  <div class="form-group">
                    <div class="form-group">
                      <div class="row">
                        <strong>
                          <div class="col-md-12">
                            <table>
                              <tr>
                                <td>Nama</td><td>&nbsp;&nbsp;&nbsp;:&nbsp;</td><td><?= $row_member['member_name'] ?></td>
                              </tr>
                              <tr>
                                <td>Alamat</td><td>&nbsp;&nbsp;&nbsp;:&nbsp;</td><td><?= $row_member['member_alamat'] ?></td>
                              </tr>
                              <tr>
                                <td>Telepon</td><td>&nbsp;&nbsp;&nbsp;:&nbsp;</td><td><?= $row_member['member_phone'] ?></td>
                              </tr>
                              <tr>
                                <td>Email</td><td>&nbsp;&nbsp;&nbsp;:&nbsp;</td><td><?= $row_member['member_email'] ?></td>
                              </tr>
                            </table>
                            <input type="hidden" id="id_piutang" name="id_piutang"  value=""/>
                            <input type="hidden" id="i_diskon_member" name="i_diskon_member" value=""/>
                          </div>
                        </strong>
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
    $("#i_payment_currency").keyup(function(e){

        var price = $("#i_payment_currency").val();
        var str = price.toString().replace("Rp. ", "");
        var str = str.toString().replace(/[^0-9\.]+/g, "");
        var total = $('#i_grand_total').val();

        $("#i_payment").val(str);
        $(this).val(format($(this).val()));

        var kembali = str - total;
        $("#i_change_currency").val(format(kembali));
        $("#i_change").val(kembali);

    });
  });

    $(document).ready(function(){
    $("li a").on('click',function(){
      var sisa = $(uang_sisa).val();
      var ax = $(this).html();
      $('#uang_sisa').val(parseInt((sisa)/$(this).html()));
      document.getElementById('ax_a').value=ax;
		});
	});
  $(function() {
		window.methodpembayaran = 1;
           window.numberWithCommas = function(x) {
			return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		}
	$('#example_simple').dataTable({
            "bPaginate": false,
            "bLengthChange": false,
            "bFilter": false,
            "bSort": false,
            "bInfo": false,
            "bAutoWidth": false
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
        var voucher_frame = document.getElementById("voucher_frame");
        var angsuran_frame = document.getElementById("angsuran_frame");
        var penghitungan_frame = document.getElementById("penghitungan_frame");
        penghitungan_frame.style.display = 'block';
        if(id == 1){
          bank_frame.style.display = 'none';
          angsuran_frame.style.display = 'none';
          penghitungan_frame.style.display = 'block';
        }else if(id==2 || id==3){
          bank_frame.style.display = 'table';
          angsuran_frame.style.display = 'none';
          penghitungan_frame.style.display = 'block';
        }
      }


    function bank_to(){
      var bank_id = $('#i_bank_id_to').val();
      $.ajax({
        type:'POST',
        data:{bank_id:bank_id},
        url: 'angsuran.php?page=get_bank_name',
        dataType:'json',
      }).done(function (data) {
        $('#i_bank_account_to').val(data);
      })
    }

		function winBack(){
      var kredit_id = $('#kredit_id').val();
      var member_id = $('#i_member').val();
      var url = 'angsuran.php?page=kembali&id='+kredit_id+'&member_id='+member_id;
      window.location.href = url;
		}

  $(document).ready(function () {

			$('#i_tgl').datepicker({
					format: "yyyy-mm-dd"
			});

	});

  function change_nominal() {
    var x_cicilan = document.getElementById("x_cicilan").value;
    var i_payment = document.getElementById("i_payment").value;
    $('#i_payment').val(parseInt((x_cicilan)*(i_payment)));
    document.getElementById('i_grand_total').value=document.getElementById('i_payment').value;
  }
</script>
