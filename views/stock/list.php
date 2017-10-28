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
                            	  <th style="text-align:center;" width="5%">No</th>
                                <th style="text-align:center;">Nama</th>
                                <th style="text-align:center;">Limit</th>
                                <th style="text-align:center;">Jumlah</th>
                                <th style="text-align:center;">Config</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
		                        while($row = mysql_fetch_array($query)){ ?>
                            <tr>
                              <td style="text-align:center;"><?= $no?></td>
                              <td><?= $row['item_name']?></td>
                              <td style="text-align:right;"><?= format_rupiah($row['item_limit'])?></td>
                              <td style="text-align:right;" <?php
                                $i_id=$row['item_id'];
                                if( get_stock($i_id,$s_cabang) <= $row['item_limit']){ ?>
                                  bgcolor="#d82827" style="color:#fff;"<?php  } ?>>
                                <?= format_rupiah(get_stock($row['item_id'],$s_cabang))?>
                              </td>
                              <td style="text-align:center;">
                                <a href="stock.php?page=form&id=<?= $row['item_id']?>"
                                  class="btn btn-default" ><i class="fa fa-pencil"></i>
                                </a>
                                <?php if (strpos($permit, 'd') !== false){ ?>
                                  <a href="javascript:void(0)"
                                  onclick="confirm_delete(<?= $row['item_id']; ?>,'stock.php?page=delete&id=')"
                                    class="btn btn-default" >
                                    <i class="fa fa-trash-o"></i>
                                  </a>
                                <?php } ?>
                              </td>
                            </tr>
                            <?php $no++; } ?>
                        </tbody>
                          <tfoot>
                            <tr>
                                <td colspan="5">
                                  <a href="<?= $add_button ?>"class="btn btn-danger " >Tambah</a>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section><!-- /.content -->
