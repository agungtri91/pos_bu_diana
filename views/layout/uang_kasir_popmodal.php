
  <form class="" action="<?= $action_kasir?>" method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Uang Kasir</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Masukkan Jumlah Uang Kasir</label>
          <input type="text" id="uang_kasir_currency" name="uang_kasir_currency" class="form-control" value="">
          <input type="hidden" id="uang_kasir" name="uang_kasir" value="">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" name="button" class="btn btn-primary">Simpan</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Keluar</button>
      </div>
  </form>
<script type="text/javascript">
  $("#uang_kasir_currency").keyup(function(e){
    var price = $("#uang_kasir_currency").val();
    var str = price.toString().replace("Rp. ", "");
    var str = str.toString().replace(/[^0-9\.]+/g, "");

    $("#uang_kasir").val(str);
    $(this).val(format_rupiah($(this).val()));
  });
</script>
