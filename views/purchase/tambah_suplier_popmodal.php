<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <div class="popmodal_title" style="font-size: 18px; margin-bottom:0;text-align:center;">Tambah Supplier</div>
</div>
<form action="<?= $action?>" method="post" enctype="multipart/form-data" role="form" novalidate>
  <div class="modal-body">
    <div class="col-md-12">
      <div class="form-group">
        <label>Nama Supplier</label>
        <input required type="text" name="i_name" class="form-control" placeholder="Masukkan nama supplier..." value=""/>
      </div>
      <div class="form-group">
        <label>No Telp</label>
        <input required type="text" name="i_telp" id="i_telp" class="form-control" placeholder="Masukkan nomor telepon..." value=""/>
      </div>
      <div class="form-group">
        <label>Email</label>
        <input required type="email" name="i_email" id="i_email" class="form-control" placeholder="Masukkan email..." value=""/>
      </div>
      <div class="form-group">
        <label>Alamat</label>
        <textarea name="i_alamat" id="i_alamat" cols="45" rows="5" class="form-control"></textarea>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <?php if (strpos($permit, 'u') !== false){ ?>
      <input class="btn btn-primary" type="submit" value="Simpan"/>
    <?php } ?>
    <a href="<?= $close_button?>" class="btn btn-danger" >Keluar</a>
  </div>
</form>
