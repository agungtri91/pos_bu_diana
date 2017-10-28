<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
  <h4 class="modal-title" id="myModalLabel">Tambah Sub Kategori</h4>
</div>
<form class="" action="<?= $action?>" method="post">
  <div class="modal-body">
    <div class="form-group">
      <input type="hidden" id="tipe_pembeli" name="tipe_pembeli"
      value="<?= $tipe_pembeli?>">
      <input type="hidden" id="tipe_pembeli_diskon_id" name="tipe_pembeli_diskon_id"
      value="<?= $r_tipe_item->tipe_pembeli_diskon_id?>">
      <label>Kategori Item</label>
      <select class="selectpicker show-tick form-control"
       data-live-search="true" name="kategori">
        <option value="0"></option>
        <?php
        $kategori_id = $r_tipe_item->kategori_item;
        while ($row = mysql_fetch_array($q_tipe_item)) {?>
          <option value="<?= $row['kategori_id']?>"
          <?php if($row['kategori_id'] == $kategori_id){echo "Selected";} ?>>
            <?= $row['kategori_name']?>
          </option>
        <?}?>
      </select>
    </div>
    <div class="form-group">
      <label>Diskon ( % )</label>
      <input type="hidden" name="branch_id" value="<?= $branch_id?>">
      <input type="hidden" name="tipe_pembeli" value="<?= $tipe_pembeli?>">
      <input type="number" id="nilai_diskon"
      name="nilai_diskon" class="form-control" value="<?= $r_tipe_item->nilai_diskon?>">
    </div>
    <div class="form-group">
      <label>Diskon Nominal</label>
      <input type="number" id="nominal_diskon" name="nominal_diskon" class="form-control" value="<?= $r_tipe_item->nominal_diskon?>">
    </div>
  </div>
  <div class="modal-footer">
    <button type="submit" name="button" class="btn btn-primary">Simpan</button>
    <button type="button" name="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
  </div>
</form>
<script type="text/javascript">
  $(document).ready(function(){
    $('.selectpicker').selectpicker('refresh');
  })
</script>
