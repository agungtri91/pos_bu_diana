<!-- Main content -->
<!-- RETUR pembelian DETAIL -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <br>
                <br>
                <div class="title_page"> <?= $title ?></div>
                <div class="box-body2 table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                              <th style="text-align:center;" width="5%">No</th>
                              <th style="text-align:center;">Nama Item</th>
                              <th style="text-align:center;">Jumlah Retur</th>
                              <th style="text-align:center;">Satuan</th>
                              <th style="text-align:center;">Config</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                           $no = 1;
                            while($r_stock_retur = mysql_fetch_array($query)){ ?>
                            <tr>
                                <td style="text-align:center;"><?= $no?></td>
                                <td><?= $r_stock_retur['item_name']?></td>
                                <td style="text-align:center;">
                                  <?= $r_stock_retur['item_stock_qty']?>
                                </td>
                                <td style="text-align:center;">
                                  <?= get_unit_name(get_unit_id($r_stock_retur['item_id']))?>
                                </td>
                                <td class="text-center">
                                  <a href="stock_retur.php?page=form&id=<?= $r_stock_retur['item_id']?>"
                                    class="btn btn-default">
                                    <i class="fa fa-search"></i>
                                  </a>
                                </td>
                            </tr>
                            <?php $no++; } ?>
                        </tbody>
                          <tfoot>
                        </tfoot>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section><!-- /.content -->
