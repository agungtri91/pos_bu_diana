<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="title_page"> <?= $title ?></div>
      <form action="<?= $action?>" method="post" enctype="multipart/form-data" role="form">
        <div class="box box-cokelat">
          <div class="box-body">
            <div class="col-md-12">
              <div class="form-group">
                <label>Nama </label>
                <input required type="text" id="i_name" name="i_name" class="form-control"
                placeholder="Masukkan nama partner..." value="<?= $row->partner_name ?>"/>
              </div>
              <div class="form-group">
                <label>Telepon </label>
                <input required type="text" id="i_phone" name="i_phone" class="form-control"
                placeholder="Masukkan Telepon partner..." value="<?= $row->partner_phone?>"/>
              </div>
              <div class="form-group">
                <label>Email </label>
                <input required type="text" id="i_email" name="i_email" class="form-control"
                placeholder="Masukkan Telepon partner..." value="<?= $row->partner_phone?>"/>
              </div>
              <div class="form-group">
                <label>Alamat </label>
                <input required type="text" id="i_alamat" name="i_alamat" class="form-control"
                placeholder="Masukkan Telepon partner..." value="<?= $row->partner_phone?>"/>
              </div>
              <div class="form-group">
                <label>Deskripsi </label>
                <textarea id="i_desk" name="i_desk" class="form-control" rows="5" cols="80"><?= $row->partner_deskripsi?></textarea>
              </div>
            </div>
          <div style="clear:both;"></div>
        </div><!-- /.box-body -->
        <div class="box-footer">
          <button type="submit" name="button" class="btn btn-primary">Simpan</button>
          <a href="<?= $close_button?>" class="btn btn-danger" >Keluar</a>
        </div>
        </div><!-- /.box -->
      </form>
    </div><!--/.col (right) -->
  </div>   <!-- /.row -->
</section><!-- /.content -->
