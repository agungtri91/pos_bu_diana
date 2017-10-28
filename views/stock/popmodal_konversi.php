<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <h4 class="modal-title" id="myModalLabel"><?= $item_name?></h4>
</div>
<div class="modal-body">
  <form class="" action="<?= $action?>" method="post">
    <input type="hidden" name="item_id" value="<?= $item_id?>">
    <input type="hidden" name="unit_id" value="<?= $unit_id?>">
    <input type="hidden" name="unit_konversi_id" value="<?= $r_unit->unit_konversi_id?>">
    <div class="form-group">
      <div class="form-group">
        <label>Harga Jual Satuan ( <?= $unit_name?> )</label>
        <h4>Rp. <?= number_format($item_price)?></h4>
      </div>
      <label>Satuan Acuan</label>
      <select class="selectpicker show-tick form-control" name="unit_acuan">
        <option value="0"></option>
        <?php
        while ($r_u = mysql_fetch_array($q_unit)) {?>
          <option value="<?= $r_u['unit_id']?>" <?php if ($unit_id == $r_u['unit_id']){
            echo "Selected";
          }?>><?= $r_u['unit_name']?></option>
        <?}?>
      </select>
      <label>Jumlah Satuan Acuan</label>
      <input type="" id="i_jumlah_acuan_currency" name="i_jumlah_acuan_currency"
      value="<?=number_format($r_unit->unit_konversi_jml)?>" class="form-control"
      onkeyup="number_currency(this);"/>
      <input type="hidden" id="i_jumlah_acuan" name="i_jumlah_acuan"
      value="<?=$r_unit->unit_konversi_jml?>" class="form-control"/>
    </div>
    <div class="form-group">
      <label>Konversi Satuan :</label>
      <?php $unit_id = $r_unit->unit_id ?>
      <select id="i_unit_2" name="i_unit_2" class="selectpicker show-tick form-control"
      data-live-search="true" value="0">
        <option value="0"></option>
        <?php
        while ($row = mysql_fetch_array($query)) {?>
          <option value="<?= $row['unit_id']?>">
            <?= $row['unit_name']?>
          </option>
        <?}?>
      </select>
        <label>Jumlah Satuan Konversi</label>
        <input type="" id="i_jumlah_turunan_currency" name="i_jumlah_turunan_currency"
        value="<?=number_format($r_unit->unit_konversi_jml)?>" class="form-control"
        onkeyup="number_currency(this);" onchange="get_harga_konversi()"/>
        <input type="hidden" id="i_jumlah_turunan" name="i_jumlah_turunan"
        value="<?=$r_unit->unit_konversi_jml?>" class="form-control"/>
    </div>
    <div class="form-group">
      <label>Harga / Satuan Konversi</label>
      <input type="" id="i_harga_konversi_currency" name="i_harga_konversi"
      value="Rp. <?=$r_unit->harga_konversi?>" class="form-control" onkeyup="nilai_currency(this);"/>
      <input type="" id="i_harga_konversi" name="i_harga_konversi"
      value="<?=$r_unit->harga_konversi?>" class="form-control"/>
    </div>
    <div class="modal-footer">
      <input class="btn btn-primary" href="<?= $action?>" type="submit" value="Simpan"/>
      <a data-dismiss="modal"class="btn btn-danger" >Batal</a>
    </div>
  </form>
</div>
<script type="text/javascript">
  $('.selectpicker').selectpicker('refresh');

  function get_harga_konversi(){
    var i_harga_konversi_currency = $('#i_harga_konversi_currency');
    var i_harga_konversi          = $('#i_harga_konversi');
    // var i_harga_konversi_currency = i_harga_konversi_currency.val();
    // var i_harga_konversi          = i_harga_konversi.val();

    var i_jumlah_turunan  = $('#i_jumlah_turunan');
    var i_jumlah_acuan    = $('#i_jumlah_acuan');

    var harga_satuan = <?php echo $item_price ? $item_price : 0?>;

    if (i_jumlah_turunan.val()>i_jumlah_acuan.val()) {
      i_harga_konversi_val = parseInt(harga_satuan)*parseInt(i_jumlah_acuan.val())||0;
    } else {
      i_harga_konversi_val = parseInt(harga_satuan)/parseInt(i_jumlah_turunan.val())||0;
    }
    $('#i_harga_konversi').val(i_harga_konversi_val);
  }
</script>
