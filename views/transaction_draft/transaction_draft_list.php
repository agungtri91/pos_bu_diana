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
                                <th>Waktu</th>
                                <th>Total Belanja</th>
                                <th style="text-align:center;">Config</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php
                          $no = 1;
                          while ($row = mysql_fetch_array($query)) {?>
                            <tr>
                              <td><?= $no;?></td>
                              <td><?= $row['created_at'];?></td>
                              <td><?= strtoupper($row['total']);?></td>
                              <td style="text-align:center;">
                                <a href="transaction_draft.php?page=lanjutkan&transaction_id=<?=$row['transaction_id'];?>" class="btn btn-primary">Lanjutkan</a>
                              </td>
                            </tr>
                          <?$no++;}?>
                        </tbody>
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
