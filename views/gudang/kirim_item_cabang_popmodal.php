<div class="box-body">
  <div class="row" id="payment_type2">
    <input type="hidden" id="item_status" name="item_status" value="1"/>
    <input type="hidden" id="i_gudang" name="i_gudang" value="<?= $gudang_id?>"/>
      <label>Cabang Tujuan</label>
      <select id="basic" name="i_cabang_tujuan" size="1" class="selectpicker show-tick form-control" data-live-search="true">
        <option value="0"></option>
        <?php while($r_cabang_mutasi = mysql_fetch_array($q_branch_mutasi)){ ?>
        <option value="<?= $r_cabang_mutasi['branch_id'] ?>"><?= $r_cabang_mutasi['branch_name']?></option>
        <?php } ?>
      </select>
    </div>
  </div>
</div>
