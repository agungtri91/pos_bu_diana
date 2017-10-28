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
                    <table id="uang_kasir_tb" class="table table-bordered table-striped">
                        <thead>
                          <tr>
                        	  <th width="5%" style="text-align:center;">No</th>
                            <th>Nama User</th>
                            <th style="text-align:center;">Tanggal Input</th>
                            <th style="text-align:center;">Jam Awal - Jam Akhir</th>
                            <th style="text-align:center;">Uang Awal</th>
                            <th style="text-align:center;">Uang Akhir</th>
                            <th style="text-align:center;">Uang Selisih</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $no = 1;
                          while ($row = mysql_fetch_array($query)) {?>
                            <tr style="text-align:center;">
                              <td><?= $no;?></td>
                              <td style="text-align:left;"><?= strtoupper($row['user_name']);?></td>
                              <td><?= format_back_date4($row['tanggal_input'])?></td>
                              <td><?= $row['jam_awal']?> - <?= $row['jam_akhir']?></td>
                              <td><?= format_rupiah(get_uang_kasir($row['tanggal_awal']))?></td>
                              <td><?= format_rupiah(get_uang_kasir($row['tanggal_akhir']))?></td>
                              <td>
                                <?= format_rupiah(get_uang_kasir($row['tanggal_awal']) - get_uang_kasir($row['tanggal_akhir']))?>
                              </td>
                            </tr>
                          <?$no++;}?>
                        </tbody>
                          <!-- <tfoot>
                            <tr>
                                <td colspan="6"><a href="<?= $add_button ?>" class="btn btn-danger " >Add</a></td>
                            </tr>
                        </tfoot> -->
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section><!-- /.content -->
<script type="text/javascript">
$(document).ready(function() {
  $('#uang_kasir_tb').DataTable( {
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
