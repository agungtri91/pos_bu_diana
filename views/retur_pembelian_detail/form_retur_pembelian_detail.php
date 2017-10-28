<!-- Content Header (Page header) -->
<!-- form pembelian detail -->
<!-- Main content -->
  <section class="content">
    <div class="row">
    <!-- right column -->
      <div class="col-md-12">
      <!-- general form elements disabled -->
        <div class="title_page"> <?= $title ?></div>
        <div class="box box-cokelat">
            <div class="box-body" style="padding:40px;">
              <!-- <div class="col-md-9"> -->
                <div class="form-group">
                  <table>
                    <?php
                    $r_retur_pembelian =  mysql_fetch_array($q_retur_pembelian); ?>
                    <tr>
                      <td>Id. transaksi </td>
                      <td><label> : <?= $r_retur_pembelian['purchases_code']?></label></td>
                    </tr>
                    <tr>
                      <td>Buyer Name </td>
                      <td><label> : <?= $r_retur_pembelian['supplier_name']?></label></td>
                    </tr>
                    <tr>
                      <td>Tanggal Membeli </td>
                      <td><label> : <?= format_date_only($r_retur_pembelian['purchases_date'])?></label></td>
                    </tr>
                  </table>
                </div>
                <div class="box-body2 table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                        <th width="5%">No</th>
                            <th>Nama Item</th>
                            <th>Jumlah Item Awal</th>
                            <th>Qty Retur</th>
                            <th>Harga Item</th>
                            <th>retur_date</th>
                            <th>Keterangan</th>
                        </tr>

                    </thead>
                    <tbody>
                      <?php
                      $no=1;
                      while($r_retur_pembelian = mysql_fetch_array($q_retur_pembelian2)){?>
                        <tr><td><?= $no?></td>
                          <td><?= $r_retur_pembelian['item_name']?></td>
                          <td><?= $r_retur_pembelian['purchase_qty']?>(<?= $r_retur_pembelian['unit_name']?>)</td>
                          <td><?= $r_retur_pembelian['item_qty']?>(<?= $r_retur_pembelian['unit_name']?>)</td>
                          <td><?= $r_retur_pembelian['item_price']?></td>
                          <td><?= $r_retur_pembelian['retur_date']?></td>
                          <td><?= $r_retur_pembelian['retur_desc']?></td>
                        </tr>
                      <?
                      $no++;
                    } ?>
                    </tbody>
                  </table>
                <!-- </div> -->
            </div>
            <div style="clear:both;"></div>
          </div><!-- /.box-body -->
        </div><!-- /.box -->

      </div><!--/.col (right) -->
    </div>   <!-- /.row -->
  </section><!-- /.content -->
