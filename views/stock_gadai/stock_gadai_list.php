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
                                <th style="text-align:center;">Jenis Barang</th>
                                <th style="text-align:center;">Nama Penggadai</th>
                                <th style="text-align:center;">Tanggal Gadai</th>
                                <th style="text-align:center;">Keterangan</th>
                                <th style="text-align:center;">Config</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php
                          $no = 1;
                          while ($row = mysql_fetch_array($query)) {?>
                            <tr>
                              <td style="text-align:center;" width="5%"><?= $no?></td>
                              <td><?= $row['nama_item']?></td>
                              <td style="text-align:center;"><?= $row['kategori_name']?></td>
                              <td style="text-align:center;"><?= $row['member_name']?></td>
                              <td style="text-align:center;"><?= format_date_only($row['gadai_date'])?></td>
                              <td style="text-align:center;">
                              <?php if ($row['mutasi_barang']==1): ?>
                                SUDAH DIMUTASI
                              <?php endif; ?>
                              </td>
                              <td style="text-align:center;">
                                <?php if (strpos($permit, 'u') !== false): ?>
                                <a href="stock_gadai.php?page=form&id=<?= $row['gadai_id']?>" class="btn btn-default">
                                  <i class="fa fa-search"></i>
                                </a>
                              <?php endif;?>
                              </td>
                            </tr>
                          <? $no++; } ?>
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section><!-- /.content -->
