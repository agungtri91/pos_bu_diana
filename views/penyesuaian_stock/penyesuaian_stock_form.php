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
  <div class="row">

  </div>
          <div class="col-md-6">
            <div class="form-group">
              <?php
              if (isset($_SESSION['tanggal']) && $_SESSION['tanggal']==true) {
                $date = $_SESSION['tanggal'];
              }else {
                $date = $date;
              }
               ?>
              <label>Tanggal : </label>
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                  <input type="text" required class="form-control pull-right" id="date_picker1"
                  name="i_date" value="<?= $date?>"/>
              </div><!-- /.input group -->
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
            <label>User :</label>
                     <?php
                    $user_data = get_user_data(); ?>
                    <div class="col-md-12">
                      <input type="text" class="form-control" value="<?=$user_data[0];?>" readonly>
                    </div>
                  </div>
          </div>  
    <div class="col-md-12">

    <!-- general form elements disabled -->
      <div class="title_page"> <?= $title ?> <?= $row->branch_name?></div>
      <form action="<?= $action?>" method="post" enctype="multipart/form-data" role="form" novalidate>
        <div class="box box-cokelat">
          <div class="box-body">
            <div class="row">
              <div class="col-md-2">
                <div id="i_member" class="form-group">
                  <label>Cabang :</label>
                  <select name="i_branch_id" id="i_branch_id" class="selectpicker show-tick form-control" data-live-search="true" value="0">
                    <option value="0"></option>
                    <?php
                    if ($_SESSION['branch_id_1']) {
                      $type = $_SESSION['branch_id_1'];
                    }
                      else {
                        $type = $_SESSION['branch_id'];
                      }
                    $query=mysql_query("select * from branches order by branch_name");
                    while($row_branch=mysql_fetch_array($query)){
                      ?><option value="<?= $row_branch['branch_id']?>"<?php if($type == $row_branch['branch_id']){echo "Selected";} ?>>
                        <?= $row_branch['branch_name']; ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-md-12">
                <input required type="hidden" name="i_branch_id" id="i_branch_id" class="form-control" value="<?= $row->branch_id?> "/>

                <div class="form-group">
                  <input type="hidden" id="i_item_id" name="i_item_id" value="<?= $id?>"/>
                  <!-- <input type="hidden" id="i_rak_id" name="i_rak_id" value="<?= $rak_id?>"/> -->
                  <label>Nama Item</label>
                  <input required type="text" name="i_name" id="i_name" class="form-control"
                  placeholder="Masukkan nama ..." value="<?= $row->item_name ?> " disabled/>
                </div>
                <div class="form-group">
                  <label>Kategori Item</label>
                  <input required type="text" name="" id="" class="form-control"
                  placeholder="Masukkan kategori buku ..." value="<?= $row->kategori_name?> " disabled/>
                </div>
                <div class="form-group">
                  <label>Jumlah Stock</label>
                  <input required type="" name="i_item_qty" id="i_item_qty" class="form-control"
                  placeholder="Masukkan jumlah ..." value="<?= $row->item_stock_qty?> " disabled/>
                  <input type="hidden" required name="item_qty_lama" id="item_qty_lama" class="form-control"
                  placeholder="Masukkan jumlah ..." value="<?= $row->item_stock_qty?>"/>
                </div>
                <label>Jumlah Stock</label>
                <input required type="number" name="edit_item_qty" id="edit_item_qty" class="form-control"
                placeholder="Masukkan jumlah ..."/>
              </div>
<div class="col-md-12">
              <div class="form-group">
                <label>Keterangan</label>
                <textarea name="i_journal_desc" cols="5" rows="5" class="form-control"></textarea>
              </div>
            </div>
              </div>
            </div>
          <div style="clear:both;"></div>
          <div class="box-footer">
            <?php if (strpos($permit, 'u') !== false ): ?>
              <input class="btn btn-primary" type="submit" value="Simpan"/>
            <?php endif; ?>
            <a href="<?= $close_button?>" class="btn btn-danger">Keluar</a>
          </div>
          </div><!-- /.box-body -->
        </div><!-- /.box -->
      </form>
    </div><!--/.col (right) -->
  </div>   <!-- /.row -->
</section><!-- /.content -->
