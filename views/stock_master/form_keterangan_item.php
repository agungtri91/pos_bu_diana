<style media="screen">
  .btn-bullet{
    border-radius:18px;
  }
  .field-on-tb{
    width: 100%;
    height: 35px;
    padding-left: 5px;
    padding-right: 5px;
    background-color: transparent;
  }
</style>
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <form class="" action="<? $action?>" method="post">
        <div class="box">
          <div class="box-body2 table-responsive">
            <div class="title_page">Keterangan Tiap Unit</div>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style="text-align:center;width:5%;">No.</th>
                <?php
                $col = 1;
                while ($r_kategori_keterangan = mysql_fetch_array($q_kategori_keterangan)) {?>
                  <th style="text-align:center;"><?= $r_kategori_keterangan['kategori_keterangan_name']?></th>
                <? $col++; }?>
                  <th style="text-align:center;">Id Pembelian</th>
                  <th style="text-align:center;">Tanggal Beli</th>
                  <th style="text-align:center;">Supplier</th>
                  <th style="text-align:center;">Config.</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no=1;
                for ($i=0; $i < $item_qty; $i++) { ?>
                  <tr>
                    <td style="text-align:center;"><?= $no?></td>
                    <?php
                    $row = $r_kategori_keterangan.$no;
                    $query = $q_kategori_keterangan.$no;
                    $query = select_config('kategori_keterangan', $where);
                    while ($row = mysql_fetch_array($query)) {?>
                      <td style="text-align:center;">
                        <?php
                        $where_kategori_keterangan_id = "WHERE kategori_keterangan_id = '".$row['kategori_keterangan_id']."'";
                        $supplier_id = select_config_by('item_keterangan_details', 'supplier', $where_kategori_keterangan_id);
                        $purchase_id = select_config_by('item_keterangan_details', 'purchase_id', $where_kategori_keterangan_id);
                        $where_purchase_id = "WHERE purchases_id = '$purchase_id'";
                        $purchase_date = select_config_by('purchases', 'purchases_date', $where_purchase_id);
                        $purchase_code = select_config_by('purchases', 'purchases_code', $where_purchase_id);
                        ?>
                          <input type="text" name="field_keterangan_<?= $i?>[<?= $row['kategori_keterangan_id']?>]"
                          class="no-border field-on-tb" value="">
                      </td>
                    <? } ?>
                    <td><?= $purchase_code?></td>
                    <td><?= format_date_only($purchase_date)?></td>
                    <td>
                      <?php
                      $supplier_name = select_config_by('suppliers', 'supplier_name', "where supplier_id = '$supplier_id'");
                      echo $supplier_name;
                      ?>
                    </td>
                    <td style="text-align:center;">
                      <input type="checkbox" id="checkbox_<?= $i?>" name="checkbox_<?= $i?>" value="1" style="display:none">
                      <a type="button" id="button_submit_<?= $i?>" class="btn btn-default" onclick="checked_simpan(<?= $i?>)">
                        <i class="fa fa-save"></i>
                      </a>
                    </td>
                  </tr>
                 <? $no++;} ?>
              </tbody>
            </table>
          </div>
          <div class="box-footer">
            <button type="submit" class="btn btn-primary" >Simpan</button>
            <a href="<?= $close_button?>" class="btn btn-danger" >Keluar</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
<script type="text/javascript">
  function tambah_keterangan(id){
    $('#medium_modal').modal();
    $(function(){
      var url = "stock_master.php?page=kategori_keterangan_details&id="+id;
        $('#medium_modal_content').load(url,function(result){
      });
    })
  }
  function checked_simpan(id) {
    var button_submit = $('#button_submit_'+id);
    var check_box = $('#checkbox_'+id);
    if (!check_box.is(":checked")) {
      check_box.prop('checked',true);
      button_submit.removeClass('btn-default');
      button_submit.addClass('btn-primary');
    } else {
      check_box.prop('checked',false);
      button_submit.removeClass('btn-primary');
      button_submit.addClass('btn-default');
    }
  }
</script>
