<!-- Main content -->
<!-- RETUR pembelian DETAIL -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="title_page"> <?= $title ?></div>
            <div class="box">
                <div class="box-body2 table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                              <th style="text-align:center;" width="5%">No</th>
                              <th style="text-align:center;">Id trans</th>
                              <th style="text-align:center;">Nama Supplier</th>
                              <th style="text-align:center;">Config</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                           $no = 1;
                            while($r_retur = mysql_fetch_array($q_retur_pembelian1)){ ?>
                            <tr>
                                <td style="text-align:center;"><?= $no?></td>
                                <td><?= $r_retur['purchases_code']?></td>
                                <td style="text-align:center;"><?= $r_retur['supplier_name']?></td>
                                <td class="text-center">
                                  <a href="retur_pembelian_detail.php?page=form&id=<?= $r_retur['purchase_id']?>"
                                    class="btn btn-default">
                                    <i class="fa fa-search"></i>
                                  </a>
                                </td>
                            </tr>
                            <?php $no++; } ?>
                        </tbody>
                          <tfoot>
                            <!-- <tr>
                                <td colspan="7"><a href="<?= $add_button ?>" class="btn btn-danger " >Add</a></td>
                            </tr> -->
                        </tfoot>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section><!-- /.content -->
