<div class="box-body">
  <div class="row" id="payment_type2">
    <input type="hidden" id="item_status" name="item_status" value="2"/>
    <input type="hidden" id="i_gudang" name="i_gudang" value="<?= $gudang_id?>"/>
    <div id="cabang_tujuan">
      <label>Gudang Tujuan</label>
      <select id="basic" name="i_gudang_tujuan" size="1" class="selectpicker show-tick form-control" data-live-search="true">
        <option value="0"></option>
        <?php while($r_gudang_mutasi = mysql_fetch_array($q_gudang_mutasi)){ ?>
        <option value="<?= $r_gudang_mutasi['gudang_id']?>" <?php if($gudang_id==$r_gudang_mutasi['gudang_id']){?>disabled<?}?>><?= $r_gudang_mutasi['gudang_name']?></option>
        <?php } ?>
      </select>
    </div>
  </div>
</div>
