<style media="screen">
  .btn-bullet{
    border-radius:18px;
  }
  .field-on-tb{
    width: 100%;
    height: 35px;
    padding-left: 5px;
    padding-right: 5px;
    background-color:#f3f5f9;
  }
  .field-on-tb:hover{
    background-color:#f2ef95;
  }
</style>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<form class="" action="index.html" method="post">
  <div class="modal-body">
    <div id="field_keterangan">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th style="text-align:center;width:5%;">No</th>
      <?php
      $no=1;
      while ($r_kategori_keterangan = mysql_fetch_array($q_kategori_keterangan)) {?>
              <th style="width:50%;"><?= $r_kategori_keterangan['kategori_keterangan_name']?></th>
      <? $no++; } ?>
          </tr>
        </thead>
        <tbody id="field_tbody">
          <tr id="field_col">
            <td style="text-align:center;">1</td>
            <?php
            for ($i=1; $i < $no ; $i++) { ?>
              <td style="padding:2px 2px 2px 2px;">
                <input type="text" name="field_keterangan_<?= $i?>_[]" class="no-border field-on-tb" value="">
              </td>
            <? } ?>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="form-group" style="text-align:right;">
      <button type="button" class="btn btn-primary btn-bullet" onclick="button_tambah_field()">
        <i class="fa fa-plus"></i>
      </button>
    </div>
  </div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-primary">Simpan</button>
    <button type="button" class="btn btn-primary" data-dismiss="modal">Batal</button>
  </div>
</form>
<script type="text/javascript">
  function button_tambah_field(){
    $('#field_col').clone().prependTo( "#field_tbody" );;
  }
</script>
