<!-- stock form -->
<!-- Content Header (Page header) -->
<!-- Main content -->
<section class="content">
    <div class="row">
        <!-- right column -->
        <div class="col-md-12">
            <!-- general form elements disabled -->
          <div class="title_page"> <?= $title ?> <?= $cabang_active?></div>
          <form action="<?= $action?>" method="post" enctype="multipart/form-data" role="form" novalidate>
            <div class="box box-cokelat">
              <!-- <div class="box-body"> -->
                <div class="col-md-12">
                  <br>
                  <br>
                    <div class="form-group">
                        <label>Nama</label>
                        <input required type="text" name="i_name" class="form-control"
                        placeholder="Masukkan nama barang..." value="<?= $row->gudang_name ?>"/>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input required type="text" name="i_address" class="form-control"
                        placeholder="Masukkan nama alamat..." value="<?= $row->gudang_address ?>"/>
                    </div>
                    <div class="form-group">
                        <label>Telepon</label>
                        <input required type="text" name="i_phone" class="form-control"
                        placeholder="Masukkan nomor telepon..." value="<?= $row->gudang_phone ?>"/>
                    </div>
                    <div style="clear:both;"></div>
                </div>
              <!-- </div><!-- /.box-body -->
              <div class="box-footer">
                <input class="btn btn-danger" type="submit" value="Save"/>
                <a href="<?= $close_button?>" class="btn btn-danger" >Close</a>
              </div>
            </div><!-- /.box -->
       </form>
        </div><!--/.col (right) -->
    </div>   <!-- /.row -->
</section><!-- /.content -->
