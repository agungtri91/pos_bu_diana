<!-- Content Header (Page header) -->
<?php if(isset($_GET['did']) && $_GET['did'] == 1){ ?>
<section class="content_new">
<div class="alert alert-info alert-dismissable">
<i class="fa fa-check"></i>
<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
<b>Simpan gagal !</b>
Password dan confirm password tidak sama
</div>
</section>
<?php } ?>
<!-- Main content -->
<!-- stock form -->
<!-- Content Header (Page header) -->
<!-- Main content -->
<style>
.modal-backdrop {
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 88888;
  background-color: #000;
}
.modal{
  z-index: 888888;
}
.modal-content{
  width:
}
@media screen and (min-width: 768px) {

	#myModal .modal-dialog  {width:1400px;}

}
#payment_type2{
  height:auto;
}
#payment_type2 label span{
  text-align:center;
  padding:13px 13px;
  display:block;
  cursor: pointer;
  color: #000;
  width: 100px;
  margin-right: 5px;
  border: 2px;
  border-color: #418eb2;
  border-radius: 5px;
  height: 37px;
  padding-top: 9px;
}
.dialogModal .dialogModal_top {
  right: 15px;
}
</style>


<section class="content">
  <div class="row">
  <!-- right column -->
  <?php
    $get_all_item	= get_all_item($id);
  ?>
    <div <?php if($get_all_item == 0){ ?>class="col-md-12" <?php }else{ ?>class="col-md-8"<?php } ?>>
    <!-- general form elements disabled -->
    <div class="title_page"><?= $gudang_name?></div>
      <div class="box box-cokelat">
        <div class="box-header"></div>
        <div class="box-body" style="padding-bottom: 40px;">
            <form action="<?= $action?>" method="post" enctype="multipart/form-data" role="form">
              <div class="col-md-12">
                <div class="form-group">
                  <input type="hidden" name="i_gudang_id" id="i_gudang_id" value="<?= $id?>">
                  <label>Item</label>
                  <select id="i_item_id" name="i_item_id" size="1" class="selectpicker show-tick form-control" data-live-search="true" onchange="select_item()"/>
                    <option value="0"></option>
                    <?php while($r_item = mysql_fetch_array($q_item_gudang)){ ?>
                    <option value="<?= $r_item['item_id'] ?>"><?= $r_item['item_name']?></option>
                    <?php } ?>
                  </select>
                </div>
                <div id="stock_gudang"></div>
                <div class="form-group">
                  <label>Jumlah item yang dikirim</label>
                  <input required type="number" step="0.01" name="i_item_qty" id="i_item_qty" class="form-control" onchange="update_change()" placeholder="Masukkan jumlah item ..." />
                </div>
                <div class="box-footer">
                  <input class="btn btn-danger" type="submit" value="Simpan"/>
                  <a href="<?= $close_button?>" class="btn btn-danger" >Close</a>
                </div>
                <br><br>
              </div>
              <div style="clear:both;"></div>
            </form>
        <table id="example21" class="table table-bordered table-striped">
            <thead>
                <tr>
                	  <th width="5%">No</th>
                    <th width="25%">Nama Item</th>
                    <th style="text-align:center;">Tipe Item</th>
                    <th style="text-align:center;">Jumlah</th>
                    <th style="text-align:center;">Config.</th>
                </tr>
            </thead>
            <tbody>
                  <?php
                  $no=1;
                  while ($item_gudang=mysql_fetch_array($q_gudang)) { ?>
                    <tr>
                      <td><?= $no?></td>
                      <td><?= $item_gudang['item_name']?></td>
                      <td style="text-align:center;"><?= $item_gudang['item_type_name']?></td>
                      <td style="text-align:right;"><?= $item_gudang['tot_item']?></td>
                      <td style="text-align:center;"><a href="#" class="btn btn-default" onclick="detail_item('<?= $item_gudang['item_id']?>')">
                        <i class="fa fa-search"></i></a></td>
                    </tr>
                  <? $no++;} ?>
            </tbody>
        </table>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
  </div>

  <div class="col-md-4" id="table_widget" <?php if($get_all_item == 0){ ?>style="display:none"<?php } ?>>
    <?php include 'widget1.php'; ?>
  </div>
</div>
</section><!-- /.content -->

<div id="dialog_content" class="dialog_content" style="display:none">
	<div class="dialogModal_header"></div>
	<div class="dialogModal_content" style="padding-top:0;">

	</div>
	<div class="dialogModal_footer">
		<button type="button" class="btn btn-default"data-dialogmodal-but="cancel">Cancel</button>
	</div>
</div>
<script type="text/javascript">

// var item_id = document.getElementById('i_item_id').value;
// $(document).ready(function(){
  function detail_item(x){
    var gudang_id = document.getElementById('i_gudang_id').value;
    $('#dialog_content').dialogModal({
      topOffset: 0,
      onOkBut: function() {},
      onCancelBut: function() {},
      onLoad: function() {
        $(".dialogModal_content").load('gudang.php?page=detail_item&item_id='+x+'&gudang_id='+gudang_id);
      },
      onClose: function() {},
    });
  }


function select_item() {
  var i_item_id = document.getElementById('i_item_id').value;
  var gudang_id = document.getElementById('i_gudang_id').value;
  $.ajax({
    type:'POST',
    data:{i_item_id:i_item_id,gudang_id:gudang_id},
    url:'gudang.php?page=select_item',
    dataType:'json',
  }).done(function(data){
    $('#stock_gudang').html("");
    $('#stock_gudang').append('<div class="form-group">\
                  <label>Jumlah Item di gudang</label>\
                  <input type="number" name="i_item_gudang" step="0.1" id="i_item_gudang" class="form-control" value="'+data.data[0].item_qty.toFixed(2)+'" disabled/>\
                  <input type="hidden" name="i_item_gudang_2" step="0.1" id="i_item_gudang_2" class="form-control" value="'+data.data[0].item_qty.toFixed(2)+'" disabled/>\
                </div>');
  });
  var jml_gudang =  parseFloat($("#i_item_gudang").val());
  if (jml_gudang=0) {
    alert("STok gudang habis....");
  }
}

function update_change(){
 var jml_gudang =  parseFloat($("#i_item_gudang").val());
 var jml_gudang2 =  parseFloat($("#i_item_gudang_2").val());
 var jml_kirim =  parseFloat($("#i_item_qty").val());
 kembali = jml_gudang2 - jml_kirim;
   if(jml_kirim>jml_gudang){
     alert("Kelebihan");
     parseFloat($("#i_item_qty").val(jml_gudang));
     $("#i_item_gudang").val(0);
   }else {
     parseFloat($("#i_item_gudang").val(kembali));
   }
}
function confirm_delete_mutasi_tmp(x){
  // alert(x);
  var y = document.getElementById('i_gudang_id').value;
  var a = confirm("Anda yakin ingin menghapus order ini ?");
  if(a==true){
    window.location.href = 'gudang.php?page=delete_widget&id='+x+'&gudang_id='+y;
  }
}


</script>
