<!-- user -->
<!-- Content Header (Page header) -->
<?php if(isset($_GET['did']) && $_GET['did'] == 1){ ?>
<section class="content_new">
  <div class="alert alert-info alert-dismissable">
    <i class="fa fa-check"></i>
    <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
    <b>Simpan gagal !</b>
    Password dan confirm password tidak sama
  </div>
</section>
<?php } ?>
<!-- Main content -->
<section class="content">
  <div class="row">
  <!-- right column -->
    <div class="col-md-12">
    <!-- general form elements disabled -->
      <div class="title_page"> <?= $title ?></div>
      <form action="<?= $action?>" method="post" enctype="multipart/form-data" role="form">
        <div class="box box-cokelat">
          <div class="box-body">
            <div class="col-md-12">
              <div class="form-group">
                <label>Nama</label>
                <input required type="text" name="i_name" class="form-control"
                placeholder="Enter name ..." value="<?= $row->user_name ?>"/>
              </div>
              <div class="form-group">
                <label>Telepon</label>
                <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-phone"></i>
                </div>
                <input required class="form-control" type="text" name="i_phone"
                placeholder="Enter Telepon ..." value="<?= $row->user_phone?>">
                </div>
              </div>
            <div class="form-group">
              <label>Tipe</label>
              <select id="basic" name="i_type" size="1" class="selectpicker show-tick form-control" data-live-search="true" />
                <?php while($r_type = mysql_fetch_array($query_type)){ ?>
                <option value="<?= $r_type['user_type_id'] ?>" <?php if($row->user_type_id == $r_type['user_type_id']){ ?>
                   selected="selected"<?php } ?>>
                   <?= $r_type['user_type_name']?>
                 </option>
                <?php } ?>
              </select>
            </div>
              <div class="form-group">
                <label>Cabang</label>
                <select id="basic" name="i_branch_id" size="1"
                class="selectpicker show-tick form-control" data-live-search="true" />
                  <?php while($r_branch = mysql_fetch_array($query_branch)){ ?>
                  <option value="<?= $r_branch['branch_id'] ?>"
                    <?php if($row->branch_id == $r_branch['branch_id']){ ?> selected="selected"<?php } ?>>
                    <?= $r_branch['branch_name']?>
                  </option>
                <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label>Nama Login</label>
                <input required type="text" name="i_login" class="form-control"
                placeholder="Enter user login ..." value="<?= $row->user_login ?>"/>
              </div>
              <div class="form-group">
                <label>Password</label>
                <input required type="password" name="i_password" class="form-control"
                placeholder="Enter password ..." value=""/>
              </div>
              <div class="form-group">
                <label>Konfirmasi Password</label>
                <input required type="password" name="i_confirm_password" class="form-control"
                placeholder="Enter confirm password ..." value=""/>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Gambar</label>
                  <?php if($id){
                  $gambar = ($row->user_img) ? $row->user_img : "default.jpg"; ?>
                  <br />
                  <img src="<?= "../img/user/".$gambar ?>" style="width:100%;"/>
                  <?php } ?>
                  <input type="file" name="i_img" id="i_img" />
                </div>
              </div>
            </div>
          <div style="clear:both;"></div>
          </div><!-- /.box-body -->
        <div class="box-footer">
        <input class="btn btn-primary" type="submit" value="Simpan"/>
        <a href="<?= $close_button?>" class="btn btn-danger">Keluar</a>
        </div>
        </div><!-- /.box -->
      </form>
    </div><!--/.col (right) -->
  </div>   <!-- /.row -->
</section><!-- /.content -->
