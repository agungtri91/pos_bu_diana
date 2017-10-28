
<div class="modal-header" style="border-radius:0px">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">Tambah Sub Kategori</h4>
</div>
<form action="<?= $action?>" method="post" enctype="multipart/form-data" role="form">
  <div class="modal-body">
    <div class="form-group">
      <label>Kategori Item</label>
      <input required type="text" name="sub_kategori_name" id="sub_kategori_name" class="form-control"
      placeholder="Masukkan nama sub kategori..." value="<?= $row_sub_kategori->sub_kategori_name ?>"/>
    </div>
  </div><!-- /.box-body -->
    <div class="modal-footer">
      <input class="btn btn-primary" type="submit" value="Simpan"/>
      <a data-dismiss="modal"class="btn btn-danger" >Batal</a>
    </div>
  </div>
</form>
