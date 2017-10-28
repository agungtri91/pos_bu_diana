                <?php if(isset($_GET['did']) && $_GET['did'] == 1){ ?>
                <section class="content_new">
                  <div class="alert alert-info alert-dismissable">
                    <i class="fa fa-check"></i>
                    <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                    <b>Sukses !</b>
                    Simpan Berhasil
                  </div>
                </section>
                <?php }else if(isset($_GET['did']) && $_GET['did'] == 2){ ?>
                <section class="content_new">
                  <div class="alert alert-info alert-dismissable">
                    <i class="fa fa-check"></i>
                    <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                    <b>Sukses !</b>
                    Edit Berhasil
                  </div>
                </section>
                <?php }else if(isset($_GET['did']) && $_GET['did'] == 3){ ?>
                <section class="content_new">
                  <div class="alert alert-info alert-dismissable">
                    <i class="fa fa-check"></i>
                    <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
                    <b>Sukses !</b>
                    Delete Berhasil
                  </div>
                </section>
                <?php } ?>
                <!-- Main content -->
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
                                                <th>Utang</th>
                                                <th>Cicilan</th>
                                                <th>Config</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                           $no = 1;
                                            while($row = mysql_fetch_array($query)){ ?>
                                            <tr>
                                                <td><?= $no?></td>
                                                <td><?= $row['id_piutang']?></td>
                                                 <td><?= $row['member_name']?></td>
                                                 <td><?= $row['uang_sisa']?></td>
                                                 <td><?= $row['cicilan']?>x</td>
                                                <td style="text-align:center; width:100px;">
                                                 <a href="utang.php?page=form&id=<?= $row['piutang_id']?>" class="btn btn-default" ><i class="fa fa-pencil"></i></a>
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
