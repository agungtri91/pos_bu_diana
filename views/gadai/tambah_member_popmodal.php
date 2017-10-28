<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title" id="myModalLabel">Tambah Member</h4>
</div>
<form action="<?= $action?>" method="post" novalidate>
  <div class="modal-body">
  <!-- Main content -->
    <div class="row">
      <div class="col-md-12">
        <div class="col-md-12">
          <input type="hidden" name="kredit_id" value="<?= $kredit?>">
        <div class="form-group">
          <label>Nama </label>
          <input required type="text" name="i_name" class="form-control" placeholder="Masukkan nama member..."
          value=""/>
        </div>
          <div class="form-group">
            <label>Telepon</label>
            <input required type="text" name="i_phone" class="form-control" placeholder="Masukkan telepon member..."
            value=""/>
          </div>
          <div class="form-group">
            <label>Alamat</label>
            <input required type="text" name="i_alamat" class="form-control" placeholder="Masukkan alamat member..."
            value=""/>
          </div>
          <div class="form-group">
            <label>Email</label>
            <input required type="email" name="i_email" class="form-control" placeholder="Masukkan email member..."
            value=""/>
          </div>
            <div class="form-group">
              <label>Tipe Pembeli</label>
              <br>
              <select id="tipe_pembeli" name="tipe_pembeli" size="1" class="selectpicker show-tick form-control"
              data-live-search="true">
                <option value="0"></option>
                <?php while($r_tipe_pembeli = mysql_fetch_array($q_tipe_pembeli)){ ?>
                  <option value="<?= $r_tipe_pembeli['type_id_pembeli'] ?>">
                    <?= $r_tipe_pembeli['type_pembeli_name'] ?>
                  </option>
                <?php } ?>
              </select>
            </div>
        </div>
      </div><!--/.col (right) -->
    </div>   <!-- /.row -->
  </div>
  <div class="modal-footer">
    <?php
    if (strpos($permit, "u")!==false){ ?>
      <input class="btn btn-primary" type="submit" value="Simpan"/>
    <?php } ?>
    <a data-dismiss="modal"class="btn btn-danger" >Batal</a>
  </div>
</form>
<script type="text/javascript">
  $('.selectpicker').selectpicker('refresh');
</script>
