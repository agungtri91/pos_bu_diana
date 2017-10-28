
<?php if(isset($_GET['did']) && $_GET['did'] == 1){ ?>
  <section class="content_new">
    <div class="alert alert-info alert-dismissable">
      <i class="fa fa-check"></i>
      <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
      <b>Sukses !</b>
      Simpan Berhasil
    </div>
  </section>
<?php } else if(isset($_GET['did']) && $_GET['did'] == 2){ ?>
  <section class="content_new">
    <div class="alert alert-info alert-dismissable">
      <i class="fa fa-check"></i>
      <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
      <b>Sukses !</b>
      Edit Berhasil
    </div>
  </section>
<?php } else if(isset($_GET['did']) && $_GET['did'] == 3){ ?>
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
          <div class="box">
            <div class="box-body2 table-responsive">
              <div class="title_page"> <?= $partner_name ?></div>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th width="5%" style="text-align:center;">No</th>
                    <th style="text-align:center;">Kode transaksi</th>
                    <th style="text-align:center;">Kode transaksi</th>
                    <th style="text-align:center;">Config</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  while ($row = mysql_fetch_array($q_partner_transaction)) {?>
                    <tr>
                      <td style="text-align:center;"><?= $no?></td>
                      <td><?= $row['transaction_code']?></td>
                      <td></td>
                      <td></td>
                    </tr>
                  <? $no++; } ?>
                </tbody>
                <tfoot>
                  <tr>
                      <?php if (strpos($permit, 'c') !== false): ?>
                    <?php endif; ?>
                    <td colspan="4"><a href="<?= $close_button ?>" class="btn btn-danger " >Kembali</a></td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
      </div>
    </div>
  </section>
