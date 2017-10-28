<script type="text/javascript">
  function grand_total(){
    var harga = parseFloat(document.getElementById("i_harga").value);
    var qty = parseFloat(document.getElementById("i_qty").value);
    var	total = harga * qty;
    document.getElementById("i_total").value = total;
  }
</script>
<!-- Content Header (Page header) -->
<!-- Main content -->
<section class="content">
  <div class="row">
  <!-- right column -->
    <div class="col-md-12">
    <!-- general form elements disabled -->
      <div class="title_page"> <?= $title ?></div>
      <div class="box box-cokelat">
        <form id="form" method="post" enctype="multipart/form-data" role="form">
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
                <label>Tipe Customer</label>
                <input required type="text" name="tipe_pembeli_name" id="i_name"
                class="form-control" placeholder="Masukkan tipe customer..."
                value="<?= strtoupper($row->type_pembeli_name)?>"/>
              </div>
                <div class="form-group" style="display:none;">
                  <label>Diskon Berlaku</label>
                  <select class="selectpicker show-tick form-control"
                   data-live-search="true" name="tipe_diskon">
                   <option value="0"></option>
                    <?php
                    $tipe_diskon_berlaku = $row->tipe_diskon_berlaku;
                    while ($r_diskon_brlk = mysql_fetch_array($q_diskon_brlk)) {?>
                      <option value="<?= $r_diskon_brlk['tipe_diskon_id']?>"
                      <?php if ($tipe_diskon_berlaku == $r_diskon_brlk['tipe_diskon_id']){echo "selected";}?>>
                        <?= $r_diskon_brlk['tipe_diskon_name']?>
                      </option>
                    <?}?>
                  </select>
                </div>
            </div>
            <div style="clear:both;"></div>
          </div><!-- /.box-body -->
          <div class="box-footer">
            <?php if ($id): ?>
              <?php if (strpos($permit, 'c') !== false || strpos($permit, 'u') !== false): ?>
                <button id="simpan" class="btn btn-primary" type="submit"
                onclick="submitForm('tipe_pembeli.php?page=edit&id=<?=$id?>&branch_id=<?=$s_cabang?>')">
                  Simpan
                </button>
            <?php endif; ?>
            <?php else: ?>
              <?php if (strpos($permit, 'c') !== false || strpos($permit, 'u') !== false): ?>
                <button id="simpan" class="btn btn-primary" type="button" onclick="check_nama()">
                  Simpan
                </button>
              <?php endif; ?>
            <?php endif; ?>
            <a href="<?= $close_button?>" class="btn btn-danger">Batal</a>
          </div>
        </form>
        <?php if ($id):include '../views/tipe_pembeli/tipe_form_diskon_pembeli.php';endif; ?>
      </div><!-- /.box -->
    </div><!--/.col (right) -->
  </div>   <!-- /.row -->
</section><!-- /.content -->
<script type="text/javascript">
$("#simpan").keyup(function(event){
    if(event.keyCode == 13){
        check_nama();
    }
});
  function check_nama() {
    var i_name = $('#i_name').val();
    var url = 'tipe_pembeli.php?page=save';
    $.ajax({
      type:'POST',
      data:{x:i_name},
      url: 'tipe_pembeli.php?page=strcmp',
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
<script src="../js/capitalize.js"></script>
