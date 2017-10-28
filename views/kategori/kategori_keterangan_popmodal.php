<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
</div>
<form class="" action="<?= $action?>" method="post">
  <div class="modal-body">
    <div class="form-group">
      <label for="">Nama</label>
      <input type="text" name="ket_name" class="form-control" value="<?= $row->kategori_keterangan_name?>">
    </div>
  </div>
  <div class="modal-footer">
    <button type="submit" name="button" class="btn btn-primary">Simpan</button>
    <button type="button" class="btn btn-danger">Batal</button>
  </div>
</form>
