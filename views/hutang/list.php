<!-- Main content -->
<!-- LIST HUTANG -->
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
                              <th style="text-align:center;">Nama</th>
                              <th style="text-align:center;">Total Hutang</th>
                              <th style="text-align:center;">Config</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                           $no = 1;
                            while($row = mysql_fetch_array($query)){ ?>
                            <tr>
                              <td style="text-align:center;"><?= $no?></td>
                              <td style="text-align:center;"><?= $row['supplier_name']?></td>
                              <td style="text-align:center;"><?= $row['purchase_total'] - $row['purchase_payment'] ?></td>
                              <td style="text-align:center; width:100px;">
                                <a href="utang.php?page=form&id=<?= $row['hutang_id']?>" class="btn btn-default" ><i class="fa fa-pencil"></i></a>
                              </td>
                            </tr>
                            <?php $no++; } ?>
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section><!-- /.content -->
