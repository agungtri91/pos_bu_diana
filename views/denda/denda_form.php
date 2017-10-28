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
                <label>Nama Denda</label>
                <input required type="text" id="i_name" name="i_name" class="form-control"
                placeholder="Masukkan nama denda ..." value="<?= $row->denda_name?>"/>
              </div>
              <div class="form-group">
                <label>Jenis Denda</label>
                <select id="i_jenis" name="i_jenis" class="selectpicker show-tick form-control" data-live-search="true">
                  <option value="0"></option>
                  <?php while ($r_periode = mysql_fetch_array($q_periode)) { ?>
                    <option value="<?= $r_periode['periode_id']?>" <?php if ($row->jenis_denda == $r_periode['periode_id']){
                      echo "Selected";
                    } ?>>
                      <?= $r_periode['periode_name']?>an
                    </option>
                  <? } ?>
                </select>
              </div>
              <!-- <div class="form-group">
                <label>Denda Nominal</label>
                <input required type="text" id="i_nominal_currency" name="i_nominal_currency" class="form-control"
                placeholder="Masukkan denda nominal..." value="<?= 'Rp.'.format_rupiah($row->denda_nominal).',00' ?>"/>
                <input required type="hidden" id="i_nominal" name="i_nominal" class="form-control"
                value="<?= $row->denda_nominal ?>"/>
              </div> -->
              <div class="form-group">
                <label>Denda Persen</label>
                <input required type="text" id="i_persen" name="i_persen" class="form-control"
                value="<?= $row->denda_persen ?>"/>
              </div>
              <div class="form-group">
                <label>Deskripsi</label>
                <textarea id="i_desc" name="i_desc" class="form-control" rows="5"><?= $row->denda_desc ?></textarea>
              </div>
            </div>
          <div style="clear:both;"></div>
          </div><!-- /.box-body -->
        <div class="box-footer">
          <?php if (strpos($permit, 'c') !== false || strpos($permit, 'u') !== false): ?>
            <input class="btn btn-primary" type="submit" value="Simpan"/>
          <?php endif; ?>
        <a href="<?= $close_button?>" class="btn btn-danger" >Keluar</a>
        </div>
        </div><!-- /.box -->
      </form>
    </div><!--/.col (right) -->
  </div>   <!-- /.row -->
</section><!-- /.content -->
<script type="text/javascript">
$(function(){
  $("#i_nominal_currency").keyup(function(e){

      var price = $("#i_nominal_currency").val();
      var str = price.toString().replace("Rp. ", "");
      var str = str.toString().replace(/[^0-9\.]+/g, "");

      $("#i_nominal").val(str);

      $(this).val(format_rupiah($(this).val()));
  });
})
</script>
