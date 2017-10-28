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
                    <table id="example21" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                            	  <th width="5%">No</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th style="width:15%;text-align:center;">Config</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
		                        while($row = mysql_fetch_array($q_gudang)){ ?>
                            <tr>
                              <td><?= $no?></td>
                              <td><?= $row['gudang_name']?></td>
                              <td><?= $row['gudang_address']?></td>
                              <td style="text-align:center;">
                                <a href="gudang.php?page=form&id=<?= $row['gudang_id']?>" class="btn btn-default" ><i class="fa fa-pencil"></i></a>
                                <?php if ($row['gudang_id']!=1){ ?>
                                  <a href="javascript:void(0)" onclick="confirm_delete(<?= $row['gudang_id']; ?>,'gudang.php?page=delete')" class="btn btn-default" ><i class="fa fa-trash-o"></i></a>
                                <? } ?>
                                <a href="gudang.php?page=add_stock&id=<?= $row['gudang_id']?>" class="btn btn-default"><i class="fa fa-plus"></i></a>
                              </td>
                            </tr>
                            <?php $no++; } ?>
                        </tbody>
                          <tfoot>
                            <tr>
                                <td colspan="5"><a href="<?= $add_button ?>" class="btn btn-danger " >Add</a></td>
                            </tr>
                        </tfoot>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section><!-- /.content -->
