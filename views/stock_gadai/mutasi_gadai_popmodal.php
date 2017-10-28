
<style media="screen">
    .img-responsive {
      padding-top: 0px;
      cursor:pointer;
      height:200px;
      max-width: 100%;
      text-align: center;
      margin-left: auto;
      margin-right: auto;
      vertical-align: middle;
    }
    /*span{display: none;}*/
    .checked-img{
      width: 120px;
      z-index: 20;
    }

    .gambar_checked{
      position: absolute;
      height: 100px;
      top: 15px;
      left: 55px;
      margin-left: auto;
      margin-right: auto;
      display: none;
    }

    .panel-default{
      background-color:#f5f5f5;
    }
    .panel-body{
      position: relative;
      padding: 0;
    }
</style>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<form class="" action="<?= $action?>" method="post">
  <div class="col-md-12">
    <div class="row">

    </div>
  </div>
  <div class="modal-body">
    <div class="form-group">
      <input type="hidden" id="gadai_id" name="gadai_id" value="<?= $id?>">
      <label for="">Nama</label>
      <input type="text" name="nama_item" class="form-control" value="<?= $nama_item?>">
    </div>
    <label for="">Pilih Gambar</label>
    <div class="row">
      <?php
      $no = 1;
      $checked = "../img/Check-icon.png";
      while ($r_img_pop = mysql_fetch_array($q_item_details)) {
        $col = 12;
        $col = $col/$count_item_details;?>
        <div class="col-md-<?= $col?>">
          <div id="panel_<?= $no?>" class="panel panel-default" style="height:200px;" onclick="panel_yg_dipilih(<?= $no?>);">
            <div class="panel-body panel-img">
              <div class="img-container">
                <img id="gambar_yg_dipilih_<?= $no?>" name="gambar_yg_dipilih_<?= $no?>"
                class="img-responsive" src="<?= $path.$r_img_pop['item_image']?>" alt="">
              </div>
              <input type="checkbox" id="input_checked_<?= $no?>" name="input_checked[]"
              value="<?= $r_img_pop['item_image']?>" style="display:none;">
              <span id="gambar_checked_<?= $no?>" class="gambar_checked">
                <img class="checked-img" src="<?= $checked?>" alt="">
              </span>
            </div>
          </div>
        </div>
      <? $no++; }?>
    </div>
  </div>
  <div class="modal-footer">
    <?php if ($sudah_dimutasi==null): ?>
    <button type="submit" name="button" class="btn btn-primary">Simpan</button>
    <?php endif; ?>
    <a data-dismiss="modal"class="btn btn-danger" >Batal</a>
  </div>
</form>
<script type="text/javascript">
  $('.selectpicker').selectpicker('refresh');
  function panel_yg_dipilih(id){
    var elem = <?php echo $no ?>;
    for (var i = 1; i <= elem; i++) {
      if (i != id) {
        $('#gambar_checked_'+i).fadeOut("slow");
        $('#input_checked_'+i).prop('checked',false);
      } else {
        $('#gambar_checked_'+id).fadeIn("slow");
        $('#input_checked_'+id).prop('checked',true);
      }
    }
  }
</script>
