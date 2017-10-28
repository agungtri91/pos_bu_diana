<!-- Content Header (Page header) -->
<!-- list hutang -->
<!-- Main content -->
  <section class="content">
    <div class="row">
    <!-- right column -->
      <div class="col-md-12">
      <!-- general form elements disabled -->
        <div class="title_page"> <?= $title ?></div>

          <div class="box box-cokelat">
              <div class="box-body" style="padding:40px;">
                <div class="col-md-9">
                  <div class="form-group">
                    <table>
                      <?php
                      $r_hutang =  mysql_fetch_array($query); ?>
                      <tr>
                        <td>Suplier </td>
                        <td> : <?= $r_hutang['supplier_name']?></td>
                      </tr>
                      <tr>
                        <td>Tanggal Hutang </td>
                        <td> : <?= format_date_only($r_hutang['purchases_date'])?></td>
                      </tr>
                      <tr>
                        <td>Batas Tanggal </td>
                        <td> : <?= $r_hutang['batas_tanggal']?></td>
                      </tr>
                    </table>
                  </div>
              </div>
              <div style="clear:both;"></div>
            </div><!-- /.box-body -->
          </div><!-- /.box -->

      </div><!--/.col (right) -->
    </div>   <!-- /.row -->
    <div class="box">
        <div class="box-body2 table-responsive">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                <th width="5%">No</th>
                    <th>Nama Barang</th>
                    <th>Harga barang</th>
                    <th>Qty</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                </tr>
                <tbody>
                  <?php
                     $no = 1;
                    $query2= mysql_query("SELECT a.*, b.purchases_date, c.item_name, b.* FROM purchases_details a
                                          JOIN purchases b ON b.purchases_id = a.purchase_id
                                          JOIN items c ON c.item_id = a.item_id
                                          WHERE b.supplier_id = '".$supplier_id."' AND lunas != 0");
                    $r_tot = mysql_fetch_array($query3);
                    while($r_stok = mysql_fetch_array($query2)){ ?>
                  <tr>
                    <td><?= $no?></td>
                    <td><?= $r_stok['item_name']?></td>
                    <td><?= $r_stok['purchase_price']?></td>
                    <td><?= $r_stok['purchase_qty']?></td>
                    <td><?= format_date_only($r_stok['purchases_date'])?></td>
                    <?php if ($r_stok['lunas']!=1) {?>
                        <td>Sudah lunas</td>
                    <? } else { ?>
                        <td>Belum Lunas</td>
                    <? } ?>
                  </tr>
                  <?php
                   $no++; }
                   $total = mysql_query('SELECT SUM() FROM $query2');;
                   ?>
                </tbody>
                <tfoot>
                  <tr class="totalColumn" style="font-size:22px; font-weight:bold;">
                    <td colspan="3" class="text-center">TOTAL HUTANG SAAT INI : </td>
                    <td colspan="2" class="colTotal">
                      <?= $r_tot['total_hutang'] ?>
                    </td>
                  </tr>
                </tfoot>
            </thead>
          </table>
        </div>
    </div>
  </section><!-- /.content -->
