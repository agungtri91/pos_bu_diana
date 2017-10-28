<style media="screen">
  .nominal{
    text-align: right;
    font-size: 40px;
    height: 45px;
  }

  #slide_down{
    height: 0;
    display: none;
    -webkit-transition:height, 1.5s linear;
    -moz-transition: height, 1.5s linear;
    -ms-transition: height, 1.5s linear;
    -o-transition: height, 1.5s linear;
    transition: height, 1.5s linear;
  }

  #slide_down.open {
    height:200px;
    display: block;
    -webkit-transition:height, 1.5s linear;
    -moz-transition: height, 1.5s linear;
    -ms-transition: height, 1.5s linear;
    -o-transition: height, 1.5s linear;
    transition: height, 1.5s linear;
   }

</style>
<form id="form_bayar" action="transaction_new.php?page=save_payment" method="post">
  <div class="modal-body">
    <input type="hidden" id="transaction_id" name="transaction_id" value="<?= $transaction_id?>">
    <div class="form-group">
      <label for=""><h2>Total</h2></label>
      <input type="" id="" name="" class="form-control nominal" value="<?= format_rupiah($totalkedua)?>" readonly>
      <input type="hidden" id="i_total" name="i_total" class="form-control nominal" value="<?= $totalkedua?>" readonly>
    </div>
    <div class="form-group">
      <label for=""><h2>Grand Total</h2></label>
      <input type="" id="" name="" class="form-control nominal" value="<?= format_rupiah($totalkedua-$total_diskon)?>" readonly>
      <input type="hidden" id="i_grand_total" name="i_grand_total" class="form-control nominal" value="<?= $totalkedua-$total_diskon?>" readonly>
    </div>
    <div class="form-group">
      <label for="">Diskon Nominal</label>
      <input type="text" name="i_diskon_nominal" class="form-control nominal" value="<?= format_rupiah($nominal_diskon_tot)?>" readonly>
    </div>
    <div class="form-group">
      <label for="">Diskon Persen</label>
      <input type="text" name="i_diskon_persen" class="form-control nominal" value="<?= format_rupiah($diskon_tot)?>" readonly>
    </div>
    <div class="form-group">
      <label for=""><h2>Bayar</h2></label>
      <input type="text" id="i_payment_currency" name="i_payment" class="form-control nominal" value="Rp. <?= format_rupiah($totalkedua-$total_diskon)?>"
      onkeypress="nilai_currency(this);" onchange="get_change()"/>
      <input type="hidden" id="i_payment" name="i_payment" class="form-control nominal" value="<?= $totalkedua-$total_diskon?>">
    </div>
    <div class="form-group">
      <label for=""><h2>Kembalian</h2></label>
      <input type="text" id="i_change_currency" name="i_change_currency" class="form-control nominal" value="" readonly/>
      <input type="hidden" id="i_change" name="i_change" class="form-control nominal" value="">
    </div>
    <div class="form-group">
      <label>Cara Pembayaran</label>
      <select class="selectpicker show-tick form-control" id="i_payment_method" name="i_payment_method" onchange="tenggang_waktu()">
        <?php  while ($r_payment_method = mysql_fetch_array($q_payment_method)) {?>
          <option value="<?= $r_payment_method['payment_method_id']?>"><?= $r_payment_method['payment_method_name']?></option>
        <?}?>
        <option value=""></option>
      </select>
    </div>
    <div class="form-group" id="tenggang_waktu" style="display:;">
      <label>Pilih Tanggal Akhir</label>
      <input type="text" required class="form-control pull-right" id="i_date_pembayaran" name="i_date_pembayaran" value=""/>
    </div>
    <div class="form-group" id="sisa_pembayaran" style="display:;">
      <label>Sisa Pembayaran</label>
      <input type="text" class="form-control nominal" id="i_sisa_pembayaran_currency" name="i_sisa_pembayaran" value="" readonly/>
      <input type="hidden" class="form-control nominal" id="i_sisa_pembayaran" name="i_sisa_pembayaran" value=""/>
    </div>
    <div class="form-group">
      <label for="">Catatan :</label>
      <textarea name="transaction_desc" rows="8" cols="80" class="form-control"></textarea>
    </div>
  </div>
  </div>
  <div class="modal-footer">
    <button type="submit" id="submit" name="button" class="btn btn-primary" >
      Bayar
    </button>
    <button type="button" id="keluar" name="button" onclick="keluar()" class="btn btn-danger">
      Keluar
    </button>
  </div>
</form>
<script type="text/javascript">

function tenggang_waktu(){
  var tenggang_waktu = document.getElementById('tenggang_waktu');
  var i_sisa_pembayaran = document.getElementById('sisa_pembayaran');
  var i_payment_method = document.getElementById('i_payment_method').value;
  if (i_payment_method==5) {
      tenggang_waktu.style.display='block';
      i_sisa_pembayaran.style.display ='block';
  } else {
      tenggang_waktu.style.display='none';
      i_sisa_pembayaran.style.display ='none';
  }
}


$('#keluar').on('click', function(){
  var transaction_id = $('#transaction_id').val();
  url = 'transaction_new.php?page=close';
  $.ajax({
    type      : "POST",
    url       : url,
    data      : {transaction_id:transaction_id},
    success   : function()
      { $('#large_modal').modal('hide');},
    error     :  function()
      {alert('Pembatalan Gagal !!')}
  });
});

$(function(){
  $('.selectpicker').selectpicker('refresh');
});

$(function(){
  $('#i_date_pembayaran').datepicker();
});

function get_change(){
  var grand_total = parseInt($('#i_grand_total').val());
  var i_payment   = parseInt($('#i_payment').val());
  var i_payment_method = document.getElementById('i_payment_method').value;
  switch (i_payment_method) {
    case '5':
      var kembalian     = parseInt(grand_total)-parseInt(i_payment);
      $('#i_sisa_pembayaran').val();
      $('#i_sisa_pembayaran_currency').val(toRp(kembalian));
      break;

    default:
      if (grand_total<i_payment) {
          var kembalian   = parseInt(i_payment)-parseInt(grand_total);
        } else {
          alert('error');
        }
        $('#i_change').val(kembalian);
        $('#i_change_currency').val(toRp(kembalian));
  }
  // alert(i_payment);
}

</script>
