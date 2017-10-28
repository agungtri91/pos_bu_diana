
                <?php
                if(isset($_GET['did']) && $_GET['did'] == 1){
                ?>
                <section class="content_new">

                <div class="alert alert-info alert-dismissable">
                <i class="fa fa-check"></i>
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                <b>Sukses !</b>
               Simpan Berhasil
                </div>

                </section>
                <?php
                }else if(isset($_GET['did']) && $_GET['did'] == 2){
                ?>
                <section class="content_new">

                <div class="alert alert-info alert-dismissable">
                <i class="fa fa-check"></i>
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                <b>Sukses !</b>
               Edit Berhasil
                </div>

                </section>
                <?php
                }else if(isset($_GET['did']) && $_GET['did'] == 3){
                ?>
                <section class="content_new">

                <div class="alert alert-info alert-dismissable">
                <i class="fa fa-check"></i>
                <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                <b>Sukses !</b>
               Delete Berhasil
                </div>

                </section>
                <?php
                }
                ?>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">



                            <div class="box">

                                <div class="box-body2 table-responsive">
                                 <div class="box-header" style="cursor: move;">
<h3 class="box-title"><strong>List Transaksi Terhapus</strong></h3>
</div>
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="5%">No</th>
                                                <th>Tanggal</th>
                                                   <th>Meja</th>
                                                   <th>Total</th>
                                                   <th>Bayar</th>
                                                   <th>Kembali</th>
                                                   <th>Config</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                           $no_tr = 1;
                                           while($row_tr = mysql_fetch_array($query)){
                                            ?>
                                            <tr>
                                            <td><?= $no_tr?></td>
                                               <td><?= $row_tr['transaction_date']?></td>
                                               <td><?php
                                               $building = ($row_tr['table_id']!=0) ? " (".$row_tr['building_name'].")" : "";
                                               echo $row_tr['table_name'].$building; ?></td>
                                               <td><?= tool_format_number($row_tr['transaction_total'])?></td>
                                               <td><?= tool_format_number($row_tr['transaction_payment'])?></td>
                                               <td><?= tool_format_number($row_tr['transaction_change'])?></td>
                                               <td style="text-align:center;">

                                                  <a href="transaction_detail.php?page=form&id=<?= $row_tr['transaction_id']?>" class="btn btn-default" ><i class="fa fa-pencil"></i></a>

                                                </td>
                                            </tr>
                                            <?php
                                            $no_tr++;
                                            }
                                            ?>



                                        </tbody>

                                    </table>

                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>

                </section><!-- /.content -->
