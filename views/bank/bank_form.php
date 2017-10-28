<!-- Bank form -->
<?php if(isset($_GET['did']) && $_GET['did'] == 1){ ?>
<section class="content_new">
  <div class="alert alert-info alert-dismissable">
    <i class="fa fa-check"></i>
    <button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
    <b>Sukses !</b>
    Simpan Berhasil
  </div>
</section>
<?php } ?><!-- Content Header (Page header) -->
<script>
function add_menu(id) {
  if(id!=0){
    window.location.href = 'member.php?page=add_menu&menu_id='+id+'&member_id=<?php echo $id ?>'; }
   }
</script>
<form action="<?= $action?>" method="post" enctype="multipart/form-data" role="form">
<!-- Main content -->
  <section class="content">
    <div class="row">
    <!-- right column -->
      <div class="col-md-12">
      <!-- general form elements disabled -->
        <div class="title_page"> <?= $title ?></div>
        <div class="box box-cokelat">
          <div class="box-body">
                                            <?php
            $user_data = get_user_data(); ?>
                        <div class="col-md-6">
              <input type="text" class="form-control" value="<?=date('Y-m-d');?>" readonly>
            </div>
            <div class="col-md-6">
              <input type="text" class="form-control" value="<?=$user_data[0];?>" readonly>
            </div>
            <div class="col-md-12">
            <div class="form-group">
              <label>Nama Bank</label>
              <input required type="text" name="bank_name" class="form-control" placeholder="Masukkan nama bank..." value="<?= $row->bank_name ?>"/>
            </div>
              <div class="form-group">
                <label>No. Rekening</label>
                <input required type="text" name="bank_account_number" class="form-control" placeholder="Masukkan nomer rekening..." value="<?= $row->bank_account_number ?>"/>
              </div>
            </div>
          <div style="clear:both;"></div>
        </div><!-- /.box-body -->
          <div class="box-footer">
            <?php if (strpos($permit, "c") !== false){ ?>
              <input class="btn btn-danger" type="submit" value="Simpan"/>
            <?php } ?>
            <a href="<?= $close_button?>" class="btn btn-danger" >Keluar</a>
          </div>
        </div><!-- /.box -->
      </div><!--/.col (right) -->
    </div>   <!-- /.row -->
</form>
<script src="../js/capitalize.js"></script>
