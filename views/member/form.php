<form action="<?= $action?>" method="post" enctype="multipart/form-data" role="form">
<!-- Main content -->
  <section class="content">
    <div class="row">
    <!-- right column -->
      <div class="col-md-12">
      <!-- general form elements disabled -->
        <div class="box">
          <div class="col-md-12">
            <div class="box-body">

              <div class="title_page"> <?= $title ?></div>
                                  <?php
            $user_data = get_user_data(); ?>
                        <div class="col-md-6">
              <input type="text" class="form-control" value="<?=date('Y-m-d');?>" readonly>
            </div>
            <div class="col-md-6">
              <input type="text" class="form-control" value="<?=$user_data[0];?>" readonly>
            </div>
              <div class="form-group">
                <label>Nama</label>
                <input required type="text" name="member_name" class="form-control" placeholder="Masukkan nama customer..."
                value="<?= $row->member_name ?>"/>
              </div>
                <div class="form-group">
                  <label>Alamat</label>
                  <input required type="text" name="member_alamat" class="form-control" placeholder="Masukkan alamat..."
                  value="<?= $row->member_alamat ?>"/>
                </div>
                <div class="form-group">
                  <label>Telepon</label>
                  <input required type="text" name="member_phone" class="form-control" placeholder="Masukkan nomer telepon..."
                  value="<?= $row->member_phone ?>"/>
                </div>
                <div class="form-group">
                  <label>Email</label>
                  <input required type="email" name="member_email" class="form-control" placeholder="Masukkan email..."
                  value="<?= $row->member_email ?>"/>
                </div>
                <div class="form-group">
                  <label>Tipe Customer</label>
                  <select class="selectpicker show-tick form-control" data-live-search="true" name="tipe_pembeli">
                    <option value="0"></option>
                    <?php
                    while ($r_tipe_pembeli = mysql_fetch_array($q_tipe_pembeli)) {?>
                      <option value="<?= $r_tipe_pembeli['type_id_pembeli']?>"
                        <?php if ($row->tipe_pembeli == $r_tipe_pembeli['type_id_pembeli']){echo "Selected";}?>>
                        <?= $r_tipe_pembeli['type_pembeli_name']?>
                      </option>
                    <?}?>
                  </select>
                </div>
            </div><!-- /.box-body -->
          </div>
          <div class="box-footer">
            <?php if (strpos($permit, "c") !== false){ ?>
              <input class="btn btn-primary" type="submit" value="Simpan"/>
            <?php } ?>
            <a href="<?= $close_button?>" class="btn btn-danger" >Keluar</a>
          </div>
        </div><!-- /.box -->
      </div><!--/.col (right) -->
    </div>   <!-- /.row -->
  </section><!-- /.content -->
</form>
<script src="../js/capitalize.js"></script>
