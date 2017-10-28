<!-- Main content -->
<!-- Retur Penjualan Detail -->
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="title_page"> <?= $title ?></div>
            <div class="box">
                <div class="box-body2 table-responsive">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                            <th width="5%">No</th>
                                <th>Id trans</th>
                                <th>Nama</th>
                                <th>Total Barang Retur</th>
                                <th>Total Uang Retur</th>
                                <th>Config</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                           $no = 1;
                            while($r_retur = mysql_fetch_array($q_retur)){ ?>
                            <tr>
                                <td><?= $no?></td>
                                <td><?= $r_retur['transaction_code']?></td>
                                <td><?= $r_retur['member_name']?></td>
                                <td><?= $r_retur['total_retur']?></td>
                                <td><?= $r_retur['tot_price']?></td>
                                <td class="text-center">
                                  <a href="returdetail.php?page=form&id=<?= $r_retur['transaction_id']?>"><i class="fa fa-search"></i></a>
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
