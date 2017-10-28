
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
        <div class="title_page"> <?= $title ?></div>
          <div class="box">
            <div class="box-body2 table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th width="5%" style="text-align:center;">No</th>
                    <th style="text-align:center;">Nama Partner</th>
                    <th style="text-align:center;">Config</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  while($row = mysql_fetch_array($query)){ ?>
                    <tr>
                      <td  style="text-align:center;"><?= $no?></td>
                      <td><?= $row['partner_name']?></td>
                      <td style="text-align:center;">
                      <?php if (strpos($permit, 'r') !== false): ?>
                        <a href="partner.php?page=form_partner_history&id=<?= $row['partner_id']?>"
                          class="btn btn-default" >
                          <i class="fa fa-search"></i>
                        </a>
                      <?php endif; ?>
                      <?php if (strpos($permit, 'u') !== false): ?>
                        <a href="partner.php?page=form&id=<?= $row['partner_id']?>"
                          class="btn btn-default" >
                          <i class="fa fa-pencil"></i>
                        </a>
                      <?php endif; ?>
                      <?php if (strpos($permit, 'd') !== false): ?>
                        <a href="javascript:void(0)" onclick="confirm_delete(<?= $row['partner_id']; ?>,'partner.php?page=delete&id=')"
                          class="btn btn-default" >
                          <i class="fa fa-trash-o"></i>
                        </a>
                      <?php endif;?>
                      </td>
                    </tr>
                  <?php $no++; } ?>
                </tbody>
                <tfoot>
                  <tr>
                      <?php if (strpos($permit, 'c') !== false): ?>
                      <td colspan="3"><a href="<?= $add_button ?>" class="btn btn-danger " >Tambah</a></td>
                    <?php endif; ?>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
      </div>
    </div>
  </section>
