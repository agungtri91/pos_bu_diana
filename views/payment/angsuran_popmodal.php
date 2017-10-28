<script type="text/javascript">
$('.selectpicker').selectpicker('refresh');
  $(document).ready(function(){
        $('#per_tanggal').daterangepicker({
          format: 'DD'
        });
  });
</script>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <div class="popmodal_title" style="font-size: 18px; margin-bottom:0;text-align:center;">Angsuran</div>
</div>
<form action="<?= $action?>" method="post" enctype="multipart/form-data">
<div class="modal-body">
  <div class="row">
    <div class="col-md-12">
        <div class="box-body">
          <div class="row">
            <div id="gambar_2"></div>
          </div>
          <div class="form-group">
            <br>
            <input type="hidden" id="transaction_id" name="transaction_id" value="<?= $transaction_id?>">
            <input type="hidden" id="payment_method_id" name="payment_method_id" value="<?= $payment_method_id?>">
            <input type="hidden" id="branch_id" name="branch_id" value="<?= $branch_id?>">
            <input type="hidden" id="member_id" name="member_id" value="<?= $i_member?>">
            <input type="hidden" id="i_item_id" name="i_item_id" value="<?= $item_id?>">
          </div>
          <div class="form-group">
            <label>Nama Barang </label>
            <input id="i_nama_barang" name="i_nama_barang" size="1" class="form-control" value="<?= $item_name?>" readonly/>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Jenis Barang </label>
                <input type="text" name="" class="form-control" value="<?= $r_kategori['kategori_name']?>" readonly="true">
                <input type="hidden" id="i_jenis_barang" name="i_jenis_barang" class="form-control"
                value="<?= $r_kategori['kategori_id']?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Merk / Model Barang </label>
                <input required type="text" name="merk_barang" class="form-control"
                placeholder="Masukkan Merk / Model Barang..."
                value="<?= $row_detail->item_merk?>" readonly/>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Tipe Barang </label>
                <input required type="text" name="i_tipe_barang" id="i_tipe_barang" class="form-control"
                placeholder="Masukkan Tipe Barang..."
                value="<?= $row_detail->item_tipe?>" readonly/>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Adminstrasi</label>
                <input required type="hidden" id="i_adminstrasi" name="i_adminstrasi" value="">
                <input type="" id="i_adminstrasi_currency" name="i_adminstrasi_currency" class="form-control " value=""/>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Harga Barang</label>
                <input type="hidden" id="i_harga_barang" name="i_harga_barang" value="<?= $row2->transaction_detail_total?>">
                <input required type="text" id="i_harga_barang_currency" name="" class="form-control"
                value="Rp.<?= format_rupiah($row2->transaction_detail_total)?>" readonly="true"/>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Uang Muka Barang </label>
                <input type="hidden" id="i_uang_muka_barang" name="i_uang_muka_barang" value="" onchange="uang_muka()">
                <input required type="text" id="i_uang_muka_barang_currency" name="i_uang_muka_barang_currency" class="form-control"
                placeholder="Masukkan Uang Muka Barang..."
                value=""/>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label>Cara Pembayaran </label>
                <select id="i_cara_pembayaran" name="i_cara_pembayaran" size="1" class="selectpicker show-tick form-control"
                data-live-search="true" onchange="cara_pembayaran()">
                <?php
                while ($r_payment_method = mysql_fetch_array($q_payment_method)) {?>
                  <option value="<?= $r_payment_method['payment_method_id']?>"><?= $r_payment_method['payment_method_name']?></option>
                <? } ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Nilai Pembiayaan  </label>
                <input type="hidden" id="i_nilai_pembiayaan" name="i_nilai_pembiayaan" class="form-control" value="" readonly="true">
                <input type="text" id="i_nilai_pembiayaan_currency" name="i_nilai_pembiayaan_currency" class="form-control" value="" readonly="true">
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="" id="bank_frame_pop" style="display:none;">
              <b> Bank</b>
              <br>
              <br>
              <label>Dari :</label>
              <div class="row">
                <div class="col-md-6" style="padding-left:0px; ">
                 <select id="i_bank_id_angsuran" name="i_bank_id_angsuran" size="1" class="selectpicker show-tick form-control"
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
                      <input type="text" name="i_bank_account_angsuran" id="i_bank_account_angsuran" class="form-control" value=""
                      placeholder="" style="text-align:right; font-size:20px;"/>
                   </div>
               </div>
               <br>
               <label>Menuju :</label>
               <div class="row">
                 <div class="col-md-6" style="padding-left:0px; ">
                  <select id="i_bank_id_to_angsuran" name="i_bank_id_to_angsuran" size="1" class="selectpicker show-tick form-control"
                  data-live-search="true" onchange="bank_milik_kita()">
                  <option value="0"></option>
                      <?php
                      $q_bank = mysql_query("select * from banks order by bank_id");
                      while($r_bank = mysql_fetch_array($q_bank)){
                       ?>
                        <option value="<?= $r_bank['bank_id'] ?>"><?= $r_bank['bank_name']?></option>
                        <?php }  ?>
                      </select>
                    </div>
                    <div class="col-md-6" style="padding-left:0px;" id="bank_account_to_angsuran">
                       <input type="text" name="i_bank_account_to_angsuran" id="i_bank_account_to_angsuran"
                       class="form-control" value="" placeholder=""
                       style="text-align:right; font-size:20px;" readonly/>
                    </div>
                </div>
              </div>
              <br>
              <br>
          </div>
          <div class="row">
            <div class="col-md-2">
              <div class="form-group">
                <label for="">Periode</label>
                <select id="i_periode_angsuran" name="i_periode_angsuran" size="1" class="form-control" onchange="lama_angsuran()">
                  <option value="0"></option>
                  <?php while ($r_periode = mysql_fetch_array($q_periode)) {
                    if ( $r_periode['periode_id'] != 1 && $r_periode['periode_id'] != 4 ) {?>
                      <option value="<?= $r_periode['periode_id']?>"><?= $r_periode['periode_name']?></option>
                    <? }
                  } ?>
                </select>
              </div>
            </div>
            <div class="col-md-2">
              <div class="form-group">
                <label for="">Lama Angsuran</label>
                <select id="i_lama_angsuran" name="i_lama_angsuran" size="1" class="form-control" onchange="angsuran_per_bulan()"/>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Angsuran Per Bulan</label>
                <input type="hidden" id="i_angsuran_per_bulan" name="i_angsuran_per_bulan" value="">
                <input required type="text" id="i_angsuran_per_bulan_currency" name="i_angsuran_per_bulan_currency"
                class="form-control" placeholder="Masukkan Angsuran..." value=""/>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <label>Pembayaran Per Tanggal </label>
                <input type="text" class="form-control pull-right" id="per_tanggal"
                name="i_date_pembayaran" value=""/>
              </div>
            </div>
          </div>
          <div style="clear:both"></div>
        </div>
    </div>
  </div>
</div>
<div class="modal-footer">
  <div style="float:right;">
    <button type="submit" class="btn btn-primary">Simpan</button>
    <button class="btn btn-danger">Batal</button>
  </div>
</div>
</form>
<script type="text/javascript">

  function lama_angsuran(){
    var i_periode_angsuran = $('#i_periode_angsuran');
    $('#i_lama_angsuran').empty();
    if (i_periode_angsuran.val() == 2) {
      for (var i = 0; i <= 56 ; i++) {
        $('#i_lama_angsuran').append('<option value="'+i+'">'+i+'</option>');
      }
      document.getElementById('per_tanggal').style.display = 'none';
    } else if (i_periode_angsuran.val() == 3) {
      for (var i = 0; i <= 12; i++) {
        $('#i_lama_angsuran').append('<option value="'+i+'">'+i+'</option>');
      }
      document.getElementById('per_tanggal').style.display = 'block';
    }
  }

function angsuran_per_bulan(){
    var i_nilai_pembiayaan = $("#i_nilai_pembiayaan").val();
    var i_lama_angsuran = $("#i_lama_angsuran").val();
    var i_angsuran_per_bulan = Math.ceil(parseInt(i_nilai_pembiayaan)/parseInt(i_lama_angsuran));
    var i_angsuran_per_bulan_currency = format(i_angsuran_per_bulan);

    var i_angsuran_per_bulan_string = i_angsuran_per_bulan.toString();
    var tiga_akhir = i_angsuran_per_bulan_string.substr(i_angsuran_per_bulan_string.length - 2);
    if (tiga_akhir !== '00') {
      var pembulatan = 100 - parseInt(tiga_akhir);
      i_angsuran_per_bulan = parseInt(i_angsuran_per_bulan) + parseInt(pembulatan);
    }
    if (i_nilai_pembiayaan > 0) {
      $('#i_angsuran_per_bulan').val(i_angsuran_per_bulan);
      $('#i_angsuran_per_bulan_currency').val(format(i_angsuran_per_bulan));
    }
}

  function cara_pembayaran(){
    var cara_pembayaran = $('#i_cara_pembayaran').val();
    var bank_frame_pop = document.getElementById('bank_frame_pop');
    if (cara_pembayaran == 3) {
      bank_frame_pop.style.display = 'block';
    }
  }

  function bank_milik_kita(){
    var x = document.getElementById('i_bank_id_to_angsuran').value;
    $.ajax({
      type:'POST',
      data:{x:x},
      url:'transaction_new.php?page=bank_to',
      dataType:'json',
    }).done(function(data){
      $('#bank_account_to_angsuran').html("");
      $('#bank_account_to_angsuran').append('<input type="text" name="i_bank_account_to_angsuran" id="i_bank_account_to_angsuran"\
       class="form-control" value='+data.data[0].bank_account_number+' placeholder="" style="text-align:right;\
        font-size:20px;" disabled/>\
      ');
      });
  }

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
        return("Rp. " + formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
  };
  $(function(){
      $("#i_adminstrasi_currency").keyup(function(e){

          var price = $("#i_adminstrasi_currency").val();
          var str = price.toString().replace("Rp. ", "");
          var str = str.toString().replace(/[^0-9\.]+/g, "");

          $("#i_adminstrasi").val(str);

          $(this).val(format($(this).val()));
      });

      $("#i_uang_muka_barang_currency").keyup(function(e){
          var harga_barang = $("#i_harga_barang").val();
          var price = $("#i_uang_muka_barang_currency").val();
          var str = price.toString().replace("Rp. ", "");
          var str = str.toString().replace(/[^0-9\.]+/g, "");

          $("#i_uang_muka_barang").val(str);
          var i_nilai_pembiayaan = parseInt(harga_barang) - parseInt(str)
          $("#i_nilai_pembiayaan").val(i_nilai_pembiayaan);
          $("#i_nilai_pembiayaan_currency").val(format(i_nilai_pembiayaan));
          $(this).val(format($(this).val()));
      });


      $("#i_angsuran_per_bulan_currency").keyup(function(e){

          var price = $("#i_angsuran_per_bulan_currency").val();
          var str = price.toString().replace("Rp. ", "");
          var str = str.toString().replace(/[^0-9\.]+/g, "");

          $("#i_angsuran_per_bulan").val(str);

          $(this).val(format($(this).val()));
      });
  });

function uang_muka() {
  var harga_barang = parseInt($('#i_harga_barang').val());
  var uang_muka = parseInt($('#i_uang_muka_barang').val());
  if ( harga_barang < uang_muka ) {
    alert("Kelebihan");
    $('#i_uang_muka_barang').val(0);
    $('#i_uang_muka_barang_currency').val(0);
    $("#i_nilai_pembiayaan").val(harga_barang);
    $("#i_nilai_pembiayaan_currency").val(format(harga_barang));
  }
}
</script>
