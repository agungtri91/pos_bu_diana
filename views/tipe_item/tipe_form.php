<style media="screen">
  .frame-diskon{
    border: 1px solid #b0b0b0;
    padding: 15px;
    padding-bottom: 30px;
  }
</style>
<script type="text/javascript">
  function grand_total(){
    var harga = parseFloat(document.getElementById("i_harga").value);
    var qty = parseFloat(document.getElementById("i_qty").value);
    var	total = harga * qty;
    document.getElementById("i_total").value = total;
  }
</script>
<!-- Content Header (Page header) -->
<!-- Main content -->
<section class="content">
  <div class="row">
  <!-- right column -->
    <div class="col-md-12">
    <!-- general form elements disabled -->
      <div class="title_page"> <?= $title ?></div>
      <form action="<?= $action?>" method="post" enctype="multipart/form-data" role="form" novalidate>
        <div class="box box-cokelat">
          <div class="box-body">
            <div class="col-md-12">
              <div class="form-group">
                <label>Tipe Item</label>
                <input required type="text" name="item_type_name" id="item_type_name" class="form-control" placeholder="Masukkan nama item..." value="<?= $row->item_type_name ?>"/>
              </div>
              <div class="form-group" id="barang_stok" style="display:none;">
                <label>Diskon Tipe Pembeli</label>
                <div class="frame-diskon">
                  <?php while($r_type_pembeli = mysql_fetch_array($q_type_pembeli)){ ?>
                  <label><?= $r_type_pembeli['type_pembeli_name']?></label>
                  <input required type="number" name="diskon[<?= $r_type_pembeli['type_id_pembeli']?>]" id="diskon" class="form-control" placeholder="Masukkan nama diskon..." value="<?= $row2[$r_type_pembeli['type_id_pembeli']]->diskon?>"/>
                  <?php }?>
                </div>
              </div>
            </div>
            <div style="clear:both;"></div>
          </div><!-- /.box-body -->
        <div class="box-footer">
          <input class="btn btn-danger" type="submit" value="Save"/>
          <a href="<?= $close_button?>" class="btn btn-danger" >Close</a>
        </div>
        </div><!-- /.box -->
      </form>
    </div><!--/.col (right) -->
  </div>   <!-- /.row -->
</section><!-- /.content -->
