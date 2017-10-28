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
                                <th>Nama Satuan</th>
                                <th style="text-align:center;">Config</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php
                          $no = 1;
                          while ($row = mysql_fetch_array($query)) {?>
                            <tr>
                              <td><?= $no;?></td>
                              <td><?= strtoupper($row['unit_name']);?></td>
                              <td style="text-align:center;">
                                <?php if (strpos($permit, 'u') !== false): ?>
                                <a href="satuan.php?page=form&id=<?= $row['unit_id']?>" class="btn btn-default" >
                                  <i class="fa fa-pencil"></i>
                                </a>
                                <?php endif; ?>
                                <?php if (strpos($permit, 'd') !== false): ?>
                                <a href="javascript:void(0)"
                                onclick="confirm_delete(<?= $row['unit_id']; ?>,'satuan.php?page=delete&tipe=2&id=')" class="btn btn-default" >
                                  <i class="fa fa-trash-o"></i>
                                </a>
                                <?php endif; ?>
                              </td>
                            </tr>
                          <?$no++;}?>
                        </tbody>
                        <?php if (strpos($permit, "c") !== false) :?>
                            <tfoot>
                              <tr>
                                  <td colspan="3"><a href="<?= $add_button ?>" class="btn btn-danger " >Tambah</a></td>
                              </tr>
                            </tfoot>
                      <?php endif; ?>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section><!-- /.content -->
<script type="text/javascript">
$(document).ready(function() {
  $('#tingkat_satuan').DataTable( {
      dom: 'Bfrtip',
      buttons: [
            {
                extend: 'pageLength'
            }
    ,
            {
                extend: 'copy'
            },
            {
                extend: 'excel'
            },
            {
                extend: 'pdf'
            }
        ],
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ]
    } );
} );
</script>
