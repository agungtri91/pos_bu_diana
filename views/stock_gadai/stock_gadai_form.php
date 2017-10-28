<!-- Content Header (Page header) -->
<!-- Main content -->
<style media="screen">
  .daterangepicker.dropdown-menu{
  	padding-top : 30px;
  }
  .daterangepicker thead{
    display: none;
  }
  .table-condensed td.available.off,
  .table-condensed td.off.disabled{
    display: none;
  }
  .slide-arrow{
    font-size: 100px;
  }
  .mySlides{
    margin-left: auto;
    margin-right: auto;
  }
  .mySlides {display:none}
  .demo {cursor:pointer}

  .box-content{
    height:400px;
    background-color:#f5f5f5;
    padding-left:5px;
    padding-right:5px;
  }

  .opacity-off{
    opacity: 0.5;
    filter: alpha(opacity=50);
  }

</style>
<section class="content">
  <div class="row">
  <!-- right column -->
    <div class="col-md-12">
    <!-- general form elements disabled -->
      <form action="<?= $action?>" method="post" enctype="multipart/form-data" role="form" novalidate>
        <div class="box box-cokelat">
          <div class="box-body">
            <div class="title_page"> <?= $title ?></div>
            <div class="col-md-12">
              <div class="form-group">
                <div class="box-content">
                  <div class="row">
                    <table style="width:100%;">
                      <tr style="height:300px">
                        <td style="text-align:center;">
                          <a class="slide-arrow" onclick="plusDivs(-1)">
                            <i class="fa fa-angle-left"></i>
                          </a>
                        </td>
                        <td>
                          <?php
                          while ($r_img = mysql_fetch_array($q_item_details)) {?>
                            <img class="mySlides" src="<?= $path.$r_img['item_image']?>" style="min-width:300px;max-width:500px;max-height:300px;">
                          <?}?>
                        </td>
                        <td style="text-align:center;">
                          <a class="slide-arrow" onclick="plusDivs(1)">
                            <i class="fa fa-angle-right"></i>
                          </a>
                        </td>
                      </tr>
                      <tr>
                        <td></td>
                        <td style="text-align:center;margin:15px;padding:5px;">
                        <?php
                        $no = 1;
                        while ($r_img_2 = mysql_fetch_array($q_item_details_2)) {?>
                            <img class="demo" src="<?= $path.$r_img_2['item_image']?>" style="min-width:50px;max-width:100px;max-height:100px;"
                            onclick="currentDiv(<?= $no?>)">
                        <? $no++; }?>
                        <td></td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label>Nama</label>
                <input required type="text" name="i_name" class="form-control" placeholder="Masukkan nama ..."
                value="<?= strtoupper($row->nama_item)?>"/>
              </div>
              <div class="form-group">
                <label>Jenis Barang</label>
                <select class="selectpicker show-thick form-control" name="kategori" data-live-search="true">
                  <option value="0"></option>
                  <?php
                  while ($r_jenis = mysql_fetch_array($q_jenis)) {?>
                    <option value="<?= $r_jenis['kategori_id']?>" <?php if ($r_jenis['kategori_id'] == $row->kategori){
                      echo "Selected";
                    }?>><?= $r_jenis['kategori_name']?></option>
                  <? } ?>
                </select>
              </div>
              <div class="form-group">
                <label for="">Merk</label>
                <input type="text" name="merk_item" class="form-control" value="<?= $row->merk_item?>">
              </div>
              <div class="form-group">
                <label for="">Tipe Barang</label>
                <input type="text" name="tipe_item" class="form-control" value="<?= $row->tipe_item?>">
              </div>
              <div class="form-group">
                <label for="">Tanggal Gadai</label>
                <input type="text" id="gadai_date" name="gadai_date" class="form-control"
                value="<?= format_date_only($row->gadai_date)?>" readonly/>
              </div>
              <div class="form-group">
                <label for="">Biaya Administrasi</label>
                <input type="text" id="administrasi_currency" name="administrasi_currency" class="form-control"
                value="Rp. <?= format_rupiah($row->administrasi)?>" onkeyup="nilai_currency(this);">
                <input type="hidden" id="administrasi" name="administrasi" value="<?= $row->administrasi?>">
              </div>
              <div class="form-group">
                <label for="">Nilai Pembiayaan</label>
                <input type="text" id="nilai_pembiayaan_currency" name="nilai_pembiayaan_currency"
                class="form-control" value="Rp. <?= format_rupiah($row->nilai_pembiayaan)?>" onkeyup="nilai_currency(this);">
                <input type="hidden" id="nilai_pembiayaan" name="nilai_pembiayaan" class="form-control"
                value="<?= $row->nilai_pembiayaan?>">
              </div>
              <div class="form-group">
                <label for="">Lama Angsuran</label>
                <div class="row">
                  <div class="col-md-6">
                    <div class="input-group">
                      <select class="selectpicker show-tick form-control" id="lama_angsuran"
                      name="lama_angsuran" data-live-search="true" onchange="lama_angsuran_()">
                      </select>
                      <div class="input-group-btn">
                        <select class="selectpicker show-tick form-control" id="periode" name="periode"
                        data-live-search="true" onchange="periode_angsuran()">
                          <option value="0"></option>
                          <?php
                          while ($r_periode = mysql_fetch_array($q_periode)) {
                            if ($r_periode['periode_id'] == 2 || $r_periode['periode_id'] == 3) {?>
                              <option value="<?= $r_periode['periode_id']?>"
                                <?php if ($row->periode_id == $r_periode['periode_id']){ echo "Selected";}?>>
                                  <?= $r_periode['periode_name']?>
                                </option>
                            <? }
                            } ?>
                        </select>
                      </div><!-- /btn-group -->
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="">Angsuran</label>
                <input type="text" id="angsuran_per_bulan_currency" name="angsuran_per_bulan_currency" class="form-control"
                value="Rp. <?= format_rupiah($row->angsuran_per_bulan)?>" readonly>
                <input type="hidden" id="angsuran_per_bulan" name="angsuran_per_bulan" value="<?= $row->angsuran_per_bulan?>">
              </div>
              <div class="form-group">
                <label for="">Pembayaran Per Tanggal</label>
                <input type="text" id="per_tanggal" name="per_tanggal" class="form-control pull-right"
                value="<?= $row->pembayaran_per_tanggal_1 .'-'. $row->pembayaran_per_tanggal_2?>">
              </div>
              <div class="">
                <div class="row">
                  <label for="">Nama Penggadai</label>
                  <div class="input-group">
                    <input required type="text" name="i_name_member" class="form-control" placeholder="Masukkan nama penggadai..."
                    value="<?= strtoupper($row->member_name)?>" readonly/>
                    <div class="input-group-btn">
                      <a href="member.php?page=form&id=<?= $row->member_id?>&gadai_id=<?= $row->gadai_id?>" type="button" name="" class="btn btn-default">
                        <i class="fa fa-search"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div style="clear:both;"></div>
            <?php if ($sudah_dimutasi): ?>
              <div class="alert alert-info alert-dismissable">
                <b>Barang Sudah Dimutasi Ke Stock Jual !</b>
              </div>
            <?php endif; ?>
          </div><!-- /.box-body -->
          <div class="box-footer">
            <?php if (strpos($permit, 'c') !== false || strpos($permit, 'u') !== false): ?>
              <input class="btn btn-primary" type="submit" value="Simpan"/>
            <?php endif; ?>
            <a href="<?= $close_button?>" class="btn btn-danger">Keluar</a>
            <a href="javascript:void(0);" class="btn btn-success" onclick="mutasi_gadai()">Mutasi</a>
          </div>
        </div><!-- /.box -->
      </form>
    </div><!--/.col (right) -->
  </div>   <!-- /.row -->
</section><!-- /.content -->
<script type="text/javascript">
    var slideIndex = 1;
    showDivs(slideIndex);

    function plusDivs(n) {
      showDivs(slideIndex += n);
    }

    function currentDiv(n) {
      showDivs(slideIndex = n);
    }

    function showDivs(n) {
      var i;
      var x = document.getElementsByClassName("mySlides");
      var dots = document.getElementsByClassName("demo");
      if (n > x.length) {slideIndex = 1}
      if (n < 1) {slideIndex = x.length}
      for (i = 0; i < x.length; i++) {
         x[i].style.display = "none";
      }
      for (i = 0; i < dots.length; i++) {
         dots[i].className = dots[i].className.replace("opacity-off", "");
      }
      x[slideIndex-1].style.display = "block";
      dots[slideIndex-1].className += " opacity-off";
    }

  $(document).ready(function(){
    $('#per_tanggal').daterangepicker({
				format: 'DD'
			});
  });

$(document).ready(function(){
  var periode = <?php echo $row->lama_angsuran ?>;
  var i_periode = $('#periode');
  $('#lama_angsuran').empty('');
  $('#lama_angsuran').append('<option value="0"></option>');
  if (i_periode.val() == 2) {
    for (var i = 0; i <= 56 ; i++) {
      var str = '';
      if (periode==i) {str="selected"}
      $('#lama_angsuran').append('<option value="'+i+'" '+str+'>'+i+'</option>');
    }
  } else if (i_periode.val() == 3) {
    for (var i = 0; i <= 12; i++) {
      var str = '';
      if (periode==i) {str="selected"}
      $('#lama_angsuran').append('<option value="'+i+'" '+str+'>'+i+'</option>');
    }
  }
  $('.selectpicker').selectpicker('refresh');
});

function periode_angsuran(){
  var i_periode = $('#periode');
  $('#lama_angsuran').empty('');
  $('#lama_angsuran').append('<option value="0"></option>');
  if (i_periode.val() == 2) {
    for (var i = 0; i <= 56 ; i++) {
      $('#lama_angsuran').append('<option value="'+i+'">'+i+'</option>');
    }
  } else if (i_periode.val() == 3) {
    for (var i = 0; i <= 12; i++) {
      $('#lama_angsuran').append('<option value="'+i+'">'+i+'</option>');
    }
  }
  $('.selectpicker').selectpicker('refresh');
}

function lama_angsuran_(){
  var nilai_pembiayaan = $('#nilai_pembiayaan');
  var lama_angsuran = $('#lama_angsuran');
  var nilai_pembiayaan_val = nilai_pembiayaan.val();
  var lama_angsuran_val = lama_angsuran.val();

  var angsuran = parseInt(nilai_pembiayaan_val)/parseInt(lama_angsuran_val);
  var angsuran_bulat = pembulatan(angsuran.toFixed(0));
  var angsuran_per_bulan_currency = $('#angsuran_per_bulan_currency');
  var angsuran_per_bulan = $('#angsuran_per_bulan');
  angsuran_per_bulan_currency.val(format_rupiah(angsuran_bulat));
  angsuran_per_bulan.val(angsuran_bulat);
}

function mutasi_gadai(){
  var id = <?php echo $id ?>;
  $('#large_modal').modal();
  var url = 'stock_gadai.php?page=mutasi_gadai_modal&id='+id;
    $('#large_modal_content').load(url,function(result){
  });
}

</script>
