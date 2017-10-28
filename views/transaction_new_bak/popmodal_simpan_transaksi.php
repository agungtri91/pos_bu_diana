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
<?php var_dump($_SESSION);
echo "<br>";
echo "$transaction_id"; ?>

<form name="myform" id="form_bayar" action="transaction_new.php?page=save_payment" method="post">
  <div class="modal-body">
    <input type="hidden" id="transaction_id" name="transaction_id" value="<?= $transaction_id?>">
    <div class="form-group">
      <label for=""><h2>Total</h2></label>
      <div class="input-group">
      <span class="input-group-addon"><font size="5">Rp</font></span>
      <input type="" id="" name="" class="form-control nominal" value="<?= format_rupiah($totalkedua)?>" readonly>
      <input type="hidden" id="i_total" name="i_total" class="form-control nominal" value="<?= $totalkedua?>" readonly>
    </div>
    </div>

    <div class="form-group">
      <label for="">Diskon Nominal</label>
      <div class="input-group">
      <span class="input-group-addon"><font size="5">Rp</font></span>
      <input type="text" name="i_diskon_persen" class="form-control nominal" value="<?= format_rupiah($diskon_tot)?>" readonly>
    </div>
    </div>

    <div class="form-group">
      <label for=""><h2>Grand Total</h2></label>
      <div class="input-group">
      <span class="input-group-addon"><font size="5">Rp</font></span>
      <input type="" id="" name="" class="form-control nominal" value="<?= format_rupiah($totalkedua-$total_diskon)?>" readonly>
      <input type="hidden" id="i_grand_total" name="i_grand_total" class="form-control nominal" value="<?= $totalkedua-$total_diskon?>" readonly>
      </div>
    </div>
<!--     <div class="form-group">
      <label for="">Diskon Nominal</label>
      <input type="text" name="i_diskon_nominal" class="form-control nominal" value="<?= format_rupiah($nominal_diskon_tot)?>" readonly>
    </div> -->
    
    <div class="form-group">
      <label for=""><h2>Bayar</h2></label>
      <div class="input-group">
      <span class="input-group-addon"><font size="5">Rp</font></span>
      <input type="text" id="i_payment_currency" name="i_payment" class="form-control nominal number" value="<?= format_rupiah($totalkedua-$total_diskon)?>"  onchange="get_change()"/> 
      <!-- onkeypress="nilai_currency(this)";" -->
      <input type="hidden" id="i_payment" name="i_payment" class="form-control nominal" value="<?= $totalkedua-$total_diskon?>">
    </div>
    </div>
    <div class="form-group">
      <label for=""><h2>Kembalian</h2></label>
      <div class="input-group">
      <span class="input-group-addon"><font size="5">Rp</font></span>
      <input type="text" id="i_change_currency" name="i_change_currency" class="form-control nominal number" value="0" readonly/>
      <input type="hidden" id="i_change" name="i_change" class="form-control nominal" value="">
    </div>
    </div>
    <div class="form-group">
      <label>Cara Pembayaran</label>
      <select class="selectpicker show-tick form-control" id="i_payment_method" name="i_payment_method" onchange="tenggang_waktu()">
        <?php  while ($r_payment_method = mysql_fetch_array($q_payment_method)) {?>
          <option value="<?= $r_payment_method['payment_method_id']?>"><?= $r_payment_method['payment_method_name']?></option>
        <?}?>
      </select>
    </div>
    <div class="form-group" id="tenggang_waktu" style="display:;">
      <label>Pilih Tanggal Akhir</label>
      <div class="input-group">

  <div class="col-md-5">
      
      <input type="text" class="form-control pull-right nominal" id="i_date_pembayaran" name="i_date_pembayaran" value=""/>
      </div>

    <div class="col-md-5">
      <input type="button" id="t30" class="btn btn-lg btn-warning" onClick="fill_tanggal_bayar(30)" value="+30">
      <input type="button" id="t30" class="btn btn-lg btn-warning" onClick="fill_tanggal_bayar(45)" value="+45">
      <input type="button" id="t30" class="btn btn-lg btn-warning" onClick="fill_tanggal_bayar(60)" value="+60">

    </div>

  </div>



    </div>
    <div class="form-group" id="sisa_pembayaran" style="display:;">
      <label>Sisa Pembayaran</label>
      <div class="input-group">
      <span class="input-group-addon"><font size="5">Rp</font></span>
      <input type="text" class="form-control nominal" id="i_sisa_pembayaran_currency" name="i_sisa_pembayaran" value="" readonly/>
      <input type="hidden" class="form-control nominal" id="i_sisa_pembayaran" name="i_sisa_pembayaran" value=""/>
    </div>
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
    <button type="button" id="keluar" name="button" class="btn btn-danger">
      Keluar
    </button>
  </div>
</form>
<script type="text/javascript">

$("#i_payment_currency").on('keyup',function(){
        var bayar = $("#i_payment_currency").val().split('.').join("");
        $("#i_payment").val(bayar);        

        var kembalian = $("#i_payment").val() - $("#i_grand_total").val();
        if (toRp(kembalian).charAt(0)=='-') {
          $("#i_change_currency").val('-');
          $("#i_sisa_pembayaran_currency").val(toRp(kembalian*-1));
        }else{
          $("#i_change_currency").val(toRp(kembalian));
          $("#i_sisa_pembayaran_currency").val('-');
        }
})

function fill_tanggal_bayar(pl) {
  var someDate = new Date();
  someDate.setDate(someDate.getDate() + pl); 
  var dd = ("0" + someDate.getDate()).slice(-2);
  var mm = ("0" + (someDate.getMonth() + 1)).slice(-2);
  var y = someDate.getFullYear();
  
  var someFormattedDate = dd + '/'+ mm + '/'+ y;
  document.getElementById('i_date_pembayaran').value = someFormattedDate;
//   $("#i_date_pembayaran").val(someFormattedDate);

}

$('input.number').keyup(function(event) {
  
  //If input 0
  if (this.value.length < 2 && event.which == 48 ){
      $(this).val('');
   }

   var tb = $(this).val();

   if (tb.charAt(0)== 0) {
    tb = tb.substring(1);
    $(this).val(tb);
   }
  // skip for arrow keys
  if(event.which >= 37 && event.which <= 40) return;
  // format number
  $(this).val(function(index, value) {
    return value
    .replace(/\D/g, "")
    .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
    ;
  });
});

  $('input.number').blur(function(event) {
    
    if (!this.value){
        $(this).val('0');
     }
  });







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
  $('#i_date_pembayaran').datepicker({
    format: "dd/mm/yyyy"
});
});

function get_change(){
  var grand_total = parseInt($('#i_grand_total').val());
  var i_payment   = parseInt($('#i_payment').val());
  var i_payment_method = document.getElementById('i_payment_method').value;
  switch (i_payment_method) {
    case '5':
      var kembalian     = parseInt(grand_total)-parseInt(i_payment);
      $('#i_sisa_pembayaran').val();
      // $('#i_sisa_pembayaran_currency').val(toRp(kembalian));
      break;

    default:
      if (grand_total<i_payment) {
          var kembalian   = parseInt(i_payment)-parseInt(grand_total);
        } else {
          alert('error');
        }
        $('#i_change').val(kembalian);
        // $('#i_change_currency').val(toRp(kembalian));
  }
  // alert(i_payment);
}

</script>
