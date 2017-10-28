<style media="screen">
  .frame-diskon{
    border: 1px solid #b0b0b0;
    padding: 15px;
    padding-bottom: 30px;
  }
</style>
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
      <form action="<?= $action?>" method="post" enctype="multipart/form-data" role="form">
        <div class="box box-cokelat">
          <div class="box-body">
            <div class="title_page"> <?= $title ?></div>
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
                <label>Kategori Item</label>
                <input required type="text" name="kategori_name" id="kategori_name"
                class="form-control" placeholder="Masukkan nama kategori..." value="<?= $row->kategori_name ?>"/>
              </div>
            </div>
            <div style="clear:both;"></div>
          </div><!-- /.box-body -->
        <div class="box-footer">
          <?php if (strpos($permit, 'c') !== false || strpos($permit, 'u') !== false): ?>
            <input class="btn btn-primary" type="submit" value="Simpan"/>
          <?php endif; ?>
          <a href="<?= $close_button?>" class="btn btn-danger" >Batal</a>
        </div>
        </div><!-- /.box -->
      </form>
    </div><!--/.col (right) -->
  </div>   <!-- /.row -->
  <?php if ($id){?>
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-body2 table-responsive">
          <div class="title_page"> Sub Kategori</div>
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th width="5%">No</th>
                <th>Nama Bahan</th>
                <th>Config</th>
              </tr>
            </thead>
            <tbody>
            <?php
            $no = 1;
            while($r_sub_kategori = mysql_fetch_array($q_sub_kategori)){
            ?>
              <tr>
                <td><?= $no?></td>
                <td><?= $r_sub_kategori['sub_kategori_name']?></td>
                <td style="text-align:center;">
                  <a href="javascript:void(0)" onclick="sub_kategori_popmodal(<?= $r_sub_kategori['sub_kategori_id']?>,<?= $id?>,2)"
                    class="btn btn-default" ><i class="fa fa-pencil"></i>
                  </a>
                  <a href="javascript:void(0)"
                  onclick="confirm_delete(<?= $r_sub_kategori['sub_kategori_id']; ?>,'kategori.php?page=delete_sub_kategori&id=<?= $id?>&id2=')"
                    class="btn btn-default" ><i class="fa fa-trash-o"></i>
                  </a>
                </td>
              </tr>
            <?php $no++; } ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="3"><a href="javascript:void(0)" onclick="sub_kategori_popmodal(<?= $id?>,'',1)"
                  class="btn btn-primary " >Tambah Sub Kategori</a></td>
              </tr>
            </tfoot>
          </table>
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-body2 table-responsive">
          <div class="title_page">Tambah Keterangan</div>
          <table id="tb_ket" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th style="text-align:center;width:5%;">No.</th>
                <th style="text-align:center;">Nama</th>
                <th style="text-align:center;">Config.</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no=1;
              while ($r_kategori_ket = mysql_fetch_array($q_kategori_ket)) {?>
                <tr>
                  <td style="text-align:center;"><?= $no?></td>
                  <td style="text-align:center;">
                    <?= $r_kategori_ket['kategori_keterangan_name']?>
                  </td>
                  <td style="text-align:center;">
                    <a href="javascript:void(0);" class="btn btn-default"
                    onclick="tambah_keterangan(2,<?= $r_kategori_ket['kategori_keterangan_id']?>)">
                      <i class="fa fa-pencil"></i>
                    </a>
                    <a href="javascript:void(0);" class="btn btn-default"
                    onclick="confirm_delete(<?= $r_kategori_ket['kategori_keterangan_id']?>,
                    'kategori.php?page=delete_kategori_keterangan&kategori_id=<?= $r_kategori_ket['kategori_id']?>
                    &kategori_keterangan=')">
                      <i class="fa fa-trash-o"></i>
                    </a>
                  </td>
                </tr>
              <? $no++; } ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="3">
                  <button type="button" name="button" class="btn btn-primary" onclick="tambah_keterangan(1,'')">Tambah Keterangan</button>
                </td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?} ?>
</section><!-- /.content -->
<div id="sub_kategori_popmodal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content" id="sub_kategori_popmodal_content" style="border-radius:0;">

    </div>
  </div>
</div>
<script type="text/javascript">
function sub_kategori_popmodal(x,y,z) {
  $('#sub_kategori_popmodal').modal();
$(function(){
  if (z==1) {
    var url = "kategori.php?page=popmodal_sub_kategori&kategori_id="+x;
      $('#sub_kategori_popmodal_content').load(url,function(result){
    });
  }else {
    var url = "kategori.php?page=popmodal_sub_kategori&sub_kategori_id="+x+"&kategori_id="+y;
      $('#sub_kategori_popmodal_content').load(url,function(result){
          });
  }
})
}

$(document).ready(function() {
  $('#tb_ket').DataTable( {
    "paging": false,
    "lengthChange": false,
    "searching": false,
    "ordering": false,
    "info": false,
    "autoWidth": true,
    "sDom": 'lfrtip'
  } );
} );

function tambah_keterangan(param,kk_id){
  var y = <?php echo $id ?>;
  if (param==2) {
    var url = "kategori.php?page=popmodal_keterangan&id="+kk_id+"&kategori_id="+y;
  } else {
    var url = "kategori.php?page=popmodal_keterangan&kategori_id="+y;
  }
  $('#medium_modal').modal();
  $('#medium_modal_content').load(url,function(result){});
}
</script>
<script src="../js/capitalize.js"></script>
