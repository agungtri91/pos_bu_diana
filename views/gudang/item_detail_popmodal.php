<div class="box-body">
  <div class="box-body2 table-responsive">
    <table id="example24" class="table table-bordered table-striped"
      <thead>
          <tr>
              <th width="5%">No</th>
              <th>Nama Item</th>
              <th>Supplier</th>
              <th>Tanggal</th>
              <th style="width:15%;">Jumlah Item</th>
          </tr>
      </thead>
      <tbody>
            <?php
            $no=1;
             while ($r_gudang_detail_item=mysql_fetch_array($q_gudang_detail_item)) {?>
              <tr>
                <td><?= $no?></td>
                <td><?= $r_gudang_detail_item['item_name']?></td>
                <td><?= $r_gudang_detail_item['supplier_name']?></td>
                <td><?= $r_gudang_detail_item['purchases_date']?></td>
                <td style="text-align:right;padding-left:5px;"><?= $r_gudang_detail_item['purchase_qty']?></td>
              </tr>
            <?
          $no++;
        } ?>
      </tbody>
    </table>
  </div>
</div>
