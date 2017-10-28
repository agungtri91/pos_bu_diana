<!-- Main content -->
<!-- RETUR pembelian DETAIL -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
              <br>
              <br>
              <div class="title_page"> <?= $item_name ?></div>
                <div class="box-body2 table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                              <th style="text-align:center;" width="5%">No</th>
                              <th style="text-align:center;">Kode Penjualan</th>
                              <th style="text-align:center;">Nama Pembeli</th>
                              <th style="text-align:center;">Jumlah Retur</th>
                              <th style="text-align:center;">Satuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = mysql_fetch_array($q_item_retur_detail)) { ?>
                              <tr>
                                <td style="text-align:center;"><?= $no?></td>
                                <td style="text-align:center;"><?= $row['transaction_code']?></td>
                                <td style="text-align:center;"><?= $row['member_name']?></td>
                                <td style="text-align:center;"><?= $row['item_stock_qty']?></td>
                                <td style="text-align:center;"><?= $row['unit_name']?></td>
                              </tr>
                            <? $no++;} ?>
                        </tbody>
                          <tfoot>
                        </tfoot>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section><!-- /.content -->
