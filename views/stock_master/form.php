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
<?php }?>
<!-- Main content -->
<section class="content">
  <div class="row">
  <!-- right column -->
    <div class="col-md-12">
    <!-- general form elements disabled -->
      <form action="<?= $action?>" method="post" enctype="multipart/form-data" role="form" novalidate>
        <div class="box box-cokelat">
          <div class="title_page"> <?= $title ?></div>
          <div class="box-body">
            <div class="col-md-9">
              <div class="form-group">
                <input type="hidden" id="stock_id" name="stock_id" value="<?= $row2->stock_id?>"/>
                <label>Nama Item</label>
                <input required type="text" name="i_name" id="i_name"
                class="form-control" placeholder="Masukkan nama ..." value="<?= $row->item_name ?> " disabled/>
              </div>
              <div class="form-group">
                <label>Tanggal Beli Terakhir</label>
                <input required type="date" name="i_original_buy_price" id="i_original_buy_price"
                class="form-control" placeholder="Masukkan harga original ..." value="<?=$get_new_date?>" disabled/>
              </div>
              <div class="form-group">
                <label>Harga Beli Terakhir</label>
                <input required type="number" name="i_original_buy_price" id="i_original_buy_price"
                class="form-control" placeholder="Masukkan harga original ..." value="<?=$stock_buy?>" disabled/>
              </div>
              <div class="form-group">
                <label>HPP</label>
                <input type="hidden" id="item_type_id" name="item_type_id" value="<?= $row->item_type_id?>">
                <input required type="number" name="i_original_price" id="i_original_price" class="form-control" placeholder="Masukkan harga original ..."
                value="<?= $row2->item_original_price ?>"/>
              </div>
              <div class="form-group" style="display:none;">
                <label>Margin</label>
                <input required type="number" name="i_margin_price" class="form-control" placeholder="Masukkan margin ..."
                value="0"/>
              </div>
              <div class="form-group">
                <label>Harga Jual</label>
                <input required type="number" name="i_price" class="form-control" placeholder="Masukkan harga ..." value="<?= $row2->item_price ?>"/>
              </div>
            </div>
          <div style="clear:both;"></div>
          </div><!-- /.box-body -->
        <div class="box-footer">
        <input class="btn btn-primary" type="submit" value="Simpan"/>
        <a href="<?= $close_button?>" class="btn btn-danger" >Keluar</a>
        </div>
        </div><!-- /.box -->
      </form>
    </div><!--/.col (right) -->
  </div>   <!-- /.row -->
</section><!-- /.content -->
