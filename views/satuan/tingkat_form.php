<!-- Content Header (Page header) -->
<!-- Main content -->
<section class="content">
  <div class="row">
  <!-- right column -->
    <div class="col-md-12">
    <!-- general form elements disabled -->
      <div class="title_page">TINGKAT SATUAN</div>
      <form id="form" method="post" enctype="multipart/form-data" role="form" novalidate>
        <div class="box box-cokelat">
          <div class="box-body">
            <div class="col-md-12">
              <div class="form-group">
                <label>Nama Tingkat</label>
                <input required type="text" name="i_name" id="i_name" class="form-control"
                placeholder="Masukkan nama ..." value="<?= $row_tingkat->tingkat_name?>"/>
              </div>
              <div class="form-group">

              </div>
            </div>
          <div style="clear:both;"></div>
          </div><!-- /.box-body -->
        <div class="box-footer">
          <?php if ($id): ?>
              <input class="btn btn-info" type="submit" onclick="submitForm('satuan.php?page=edit&tipe=1&id=<?= $id?>')" value="Simpan"/>
          <?php else: ?>
            <input class="btn btn-primary" type="button" onclick="check_nama()" value="Simpan"/>
          <?php endif; ?>
          <a href="<?= $close_button?>" class="btn btn-danger">Batal</a>
        </div>
        </div><!-- /.box -->
      </form>
    </div><!--/.col (right) -->
  </div>   <!-- /.row -->
</section><!-- /.content -->
<script type="text/javascript">
  function check_nama() {
    var i_name = $('#i_name').val();
    var url = 'satuan.php?page=save&tipe=1';
    $.ajax({
      type:'POST',
      data:{x:i_name,y:1},
      url: 'satuan.php?page=strcmp',
      dataType:'json',
    }).done(function(data){
        if (data !== null) {
          var a = confirm(i_name+" sudah ada, Simpan atau tidak ?");
          if(a==true){
            submitForm(url);
          }
        }else {
            submitForm(url);
          }
    });
  }

  function submitForm(action){
  document.getElementById('form').action = action;
  document.getElementById('form').submit();
  }
</script>
