
<style media="screen">
  .form-input{
    height: 35px;
    padding: 10px;
    margin: 10px;
  }
  .col-md-6{
    top:30px;
    padding-bottom: 30px;
  }

  #konversi_list_body td{
    vertical-align: middle;
    text-align: center;
    padding: 2px 10px 2px 10px;
  }

  #konversi_list_body td input {
    padding-right: 10px !important;
    margin-right: 10px !important;
  }

  #konversi_list_body .selectpicker,
  #konversi_list_body .bootstrap-select > .btn{
    width: 80px;
  }

  select {
    width: 100%;
    height: 100%;
    padding-left: 10px;
    padding-top: 10px;
    padding-bottom: 10px;
  }

</style>
<section class="content">
	<div class="row">
	<!-- right column -->
		<div class="col-md-12">
		<!-- general form elements disabled -->
			<div class="title_page"> <?= $title ?></div>
			<form id="form" method="post" enctype="multipart/form-data" role="form" novalidate>
				<div class="box box-cokelat">
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

              <div class="col-md-6">
                <div class="form-group">
                  <label>Nama</label>
                  <input type="hidden" name="id" id="id" value="<?= $id?>">
                  <input required type="text" name="i_name" class="form-control"
                  placeholder="Masukkan nama item..." value="<?= $row->item_name ?>"/>
                </div>
                <div class="form-group">
                  <label>Kode Item</label>
                  <input required type="text" name="kode_item" id="kode_item" class="form-control"
                  placeholder="Masukkan kode item..." value="<?= $row->kode_barang ?>"/>
                </div>
                <div class="form-group" style="display:none">
                  <label>Penerbit</label>
                  <input required type="" name="item_penerbit" id="item_penerbit" class="form-control"
                  placeholder="Masukkan penerbit..." value="<?= $row2->item_penerbit?>"/>
                </div>
                <div class="form-group" style="display:none;">
                  <div style="width:250px;width: 250px;left: 0px;top: 30px;">
                      <label>Gambar</label>
                      <?php if($id){
                      $gambar = ($row->stock_img) ? $row->stock_img : "default.jpg"; ?>
                      <br />
                      <img src="<?= "../img/menu/".$gambar ?>" id="output_1" style="width:200px;"/>
                      <?php } ?>
                      <img id="output" style="width:200px;">
                    <input type="file" name="i_img" id="i_img" accept="image/*"  onchange="loadFile(event)"/>
                  </div>
                </div>
                <div class="form-group">
                  <label>Merk Item</label>
                  <input required type="text" name="merk_item" id="merk_item" class="form-control"
                  placeholder="Masukkan merk item..." value="<?= $row2->item_merk?>"/>
                </div>
                <div class="form-group">
                  <label>Tipe Item</label>
                  <input required type="text" name="tipe_item" id="tipe_item" class="form-control"
                  placeholder="Masukkan tipe item..." value="<?= $row2->item_tipe?>"/>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Panjang </label>
                      <input required type="number" name="item_p" id="item_p" class="form-control"
                      placeholder="cm..." value="<?= $row2->item_p?>"/>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Lebar </label>
                      <input required type="number" name="item_l" id="item_" class="form-control"
                      placeholder="cm..." value="<?= $row2->item_l?>"/>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Tinggi </label>
                      <input required type="number" name="item_t" id="item_t" class="form-control"
                      placeholder="cm..." value="<?= $row2->item_t?>"/>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Berat </label>
                      <input required type="number" name="item_berat" id="item_berat" class="form-control"
                      placeholder="gr..." value="<?= $row2->item_berat?>"/>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label>keterangan</label>
                  <br>
                  <textarea name="item_desc" rows="4" cols="40"><?= $row2->item_desc?></textarea>
                </div>
                <div style="clear:both;"></div>
                <div class="form-group" id="barang_stok">
                  <label>Kategori Item</label>
                    <select name="kategori_id" id="kategori_id" class="selectpicker show-tick form-control"
                    data-live-search="true"
                    value="0" onchange="kategori_item()">
                      <option value="0"></option>
                      <?php while($r_kategori_id = mysql_fetch_array($q_kategori_id)){ ?>
                      <option value="<?= $r_kategori_id['kategori_id'] ?>"
                      <?php if($row->kategori_id == $r_kategori_id['kategori_id']){ ?> selected="selected"<?php } ?>>
                      <?= $r_kategori_id['kategori_name'] ?>
                      </option>
                    <?php } ?>
                    </select>
                </div>
                <div class="form-group" id="sub_kategori">
                  <label>Sub Kategori Item</label>
                  <select id="sub_kategori_item" name="sub_kategori_item" size="1"
                  class="selectpicker show-tick form-control" data-live-search="true" />
                  </select>
                  <div id="abs"></div>
                </div>
                <div class="form-group" id="barang_stok" style="display:none;">
                  <label>Tipe Item</label>
                  <select id="i_item_type" name="i_item_type" size="1" class="selectpicker show-tick form-control"
                  data-live-search="true" />
                    <option value="0"></option>
                    <?php while($r_item_type = mysql_fetch_array($query_item_type)){ ?>
                    <option value="<?= $r_item_type['item_type_id'] ?>" <?php
                    if($row->item_type == $r_item_type['item_type_id']){ ?> selected="selected"<?php } ?>>
                    <?= $r_item_type['item_type_name'] ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Batas Jumlah</label>
                  <input required type="text" name="i_item_limit" class="form-control"
                  placeholder="Masukkan limit stok..." value="<?= $row->item_limit ?>"/>
                </div>
              </div>
              <div class="col-md-6" style="display:;">
                <div class="form-group">
                  <label>Tanggal Beli Terakhir</label>
                  <input required type="date" name="" id=""
                  class="form-control" value="<?=$get_new_date?>" disabled/>
                </div>
                <div class="form-group">
                  <label>Harga Beli Terakhir ( <?=  strtoupper($unit_id_new_buy_name)?> )</label>
                  <div class="input-group">
                  <span class="input-group-addon"><font size="3">Rp</font></span>
                  <input name="i_original_buy_price" id="i_original_buy_price"
                  class="form-control" value="<?= format_rupiah($stock_buy)?>" readonly/>
                  </div>
                </div>
                <div class="form-group">
                  <label>Harga Pokok Produksi</label>
                  <div class="input-group">
                  <span class="input-group-addon"><font size="3">Rp</font></span>
                  <input type="text" id="i_hpp_currency" name="i_hpp_currency" class="form-control number"
                  value="<?= format_rupiah($row->item_hpp_price)?>">
                  <input type="hidden" id="i_hpp" name="i_hpp" class="form-control"
                  value="<?= $row->item_hpp_price?>">
                  </div>
                </div>
                <div class="form-group">
                  <label>Satuan Utama</label>
                  <select id="i_unit" name="i_unit" size="1" class="selectpicker show-tick form-control"
                  data-live-search="true" onchange="konversi()"/>
                    <option value="0"></option>
                    <?php
                    if ($_SESSION['unit_id']) {
                      $unit_id_old = $_SESSION['unit_id'];
                    }else {
                      $unit_id_old = $row->unit_id;
                    }
                    while ($r_unit = mysql_fetch_array($q_unit)) {?>
                      <option value="<?= $r_unit['unit_id']?>"
                        <?php if ($unit_id_old == $r_unit['unit_id']){echo "Selected";}?>
                        ><?= strtoupper($r_unit['unit_name'])?></option>
                    <?}?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Harga Jual Dalam Satuan Utama</label>
                  <div class="input-group">
                  <span class="input-group-addon"><font size="3">Rp</font></span>
                  <input type="text" id="i_harga_jual_currency" name="i_harga_jual_currency" class="form-control number"
                  value="<?= format_rupiah($row->item_price)?>">
                  <input type="hidden" id="i_harga_jual" name="i_harga_jual" class="form-control"
                  value="<?= $row->item_price?>">
                  </div>
                </div>
              </div>
            </div>
            <div style="clear:both;"></div>
					</div><!-- /.box-body -->
					<div class="box-footer">
            <?php if (strpos($permit, 'c') !== false || strpos($permit, 'u') !== false){ ?>
						<button type="button" class="btn btn-primary" onclick="check_nama()">
              Simpan
            </button>
            <?php } ?>
						<a href="<?= $close_button?>" class="btn btn-danger" >Keluar</a>
					</div>
				</div><!-- /.box -->
			</form>
		</div><!--/.col (right) -->
	</div>   <!-- /.row -->
</section><!-- /.content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-body table-responsive">
          <div class="" id="mytable">
            <input type="hidden" id="param_list" name="xx" value="0">
            <table id="" class="konversi_list table table-bordered table-striped">
              <thead>
                <tr>
                  <th style="width:5%;" align="center">No.</th>
                  <th>Jumlah</th>
                  <th>Satuan</th>
                  <th>Konversi</th>
                  <th>Satuan</th>
                  <th>Harga</th>
                  <th style="text-align:center;">Config.</th>
                </tr>
              </thead>
              <tbody id="konversi_list_body">
              </tbody>
              <tfoot>
                <tr>
                  <?php if (strpos($permit, 'c') !== false): ?>
                    <td colspan="7">
                      <a href="javascript:void(0)" onclick="add_konversi()"
                      class="btn btn-success">
                        Tambah
                      </a>
                      <button type="button" id="btn_simpan_konversi"
                      class="btn btn-primary">
                        Simpan
                      </button>
                    </td>
                  <?php endif; ?>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script type="text/javascript">

  $('input.number').keyup(function(event) {
  
  //If input 0
  if (this.value.length < 2 && event.which == 48 ){
      $(this).val('');
   }

   var tb = $(this).val();

   if (tb.charAt(0)== 0) {
    tb = tb.substring(1);
    $(this).val(tb);
   }
  // skip for arrow keys
  if(event.which >= 37 && event.which <= 40) return;
  // format number
  $(this).val(function(index, value) {
    return value
    .replace(/\D/g, "")
    .replace(/\B(?=(\d{3})+(?!\d))/g, ".")
    ;
  });
});

  $('input.number').blur(function(event) {
    
    if (!this.value){
        $(this).val('0');
     }
  });

// $(function(){


//     $("#i_hpp_currency").keyup(function(e){

//         var price = $("#i_hpp_currency").val();
//         var str = price.toString().replace("Rp. ", "");
//         var str = str.toString().replace(/[^0-9\.]+/g, "");

//         $("#i_hpp").val(str);

//         $(this).val(format_rupiah($(this).val()));
//     });

//     $("#i_harga_jual_currency").keyup(function(e){

//         var price = $("#i_harga_jual_currency").val();
//         var str = price.toString().replace("Rp. ", "");
//         var str = str.toString().replace(/[^0-9\.]+/g, "");

//         $("#i_harga_jual").val(str);

//         $(this).val(format_rupiah($(this).val()));
//     });

//   });



  function kategori_item(){
    var x = $('#kategori_id').val();
    var y = $('#id').val();
    var select = $('#sub_kategori_item');
    var z = '';
    $.ajax({
      type:'POST',
      data:{x:x,y:y},
      url:'stock.php?page=sub_kategori_item',
      dataType:'json',
    }).done(function(data){
      select.html("");
      select.append('<option value="0"></option>');
      for (var i = 0; i < data.length; i++) {
        var str = '';
      if (data[i].sub_kategori_id == data[i].id) {
        str = 'selected';
      }
        select.append('<option value="'+data[i].sub_kategori_id+'"'+str+'>'+data[i].sub_kategori_name+'</option>');
      }
        $('.selectpicker').selectpicker('refresh');
    });
  }

  $(document).ready(function() {
      var x = $('#kategori_id').val();
      var y = $('#id').val();
      var select = $('#sub_kategori_item');
      var z = '';
      $.ajax({
        type:'POST',
        data:{x:x,y:y},
        url:'stock.php?page=sub_kategori_item',
        dataType:'json',
      }).done(function(data){
        select.html("");
        select.append('<option value="0"></option>');
        for (var i = 0; i < data.length; i++) {
          var str = '';
        if (data[i].sub_kategori_id == data[i].id) {
          str = 'selected';
        }
          select.append('<option value="'+data[i].sub_kategori_id+'"'+str+'>'+data[i].sub_kategori_name+'</option>');
        }
          $('.selectpicker').selectpicker('refresh');
      });
    });

    $(document).ready(function() {
    $('#konversi_list').DataTable( {
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "sDom": 'lfrtip'
      } );
    } );

    var loadFile = function(event) {
      var reader = new FileReader();
      reader.onload = function(){
        var output = document.getElementById('output');
        $('#output_1').empty();
        output.src = reader.result;
      };
      reader.readAsDataURL(event.target.files[0]);
    };

function delete_diskon(x,y) {
  var url = "stock.php?page=delete_diskon&id="+x+"&item_id="+y;
  window.location.href = url;
}

//BTN SIMPAN
function check_nama() {
  var kode_item = $('#kode_item').val();
  var item_id = $('#id').val();

    if (item_id == false) {
      var url = 'stock.php?page=save';
    } else {
      var url = 'stock.php?page=edit&id='+item_id;
    }
  $.ajax({
    type:'POST',
    data:{x:kode_item,item_id:item_id},
    url: 'stock.php?page=strcmp',
    dataType:'json',
  }).done(function(data){
      if (data !== null) {
        var a = confirm(kode_item+" sudah ada, Simpan atau tidak ?");
        if(a==true){
          submitForm(url);
        }
      }else {
          submitForm(url);
        }
  });
}

function add_konversi(){
  var konversi_list_body = $('#konversi_list_body');
  var param_list_val = $('#param_list').val();
  if (param_list_val==0) {konversi_list_body.empty();}
  param_list_val++;
  konversi_list_body.append('\
    <tr id="konversi_row_'+param_list_val+'">\
      <td>'+param_list_val+'</td>\
      <td><input class="form-control" id="jumlah_acuan_'+param_list_val+'" name="jumlah_acuan[]" value="" /></td>\
      <td><select class="" id="unit_1_'+param_list_val+'" name="unit_1[]"></select></td>\
      <td><input class="form-control" id="jumlah_konversi_'+param_list_val+'" name="jumlah_konversi[]" value="" /></td>\
      <td><select class="" id="unit_2_'+param_list_val+'" name="unit_2[]" onchange="get_harga_konversi('+param_list_val+')"></select></td>\
      <td>\
        <input class="form-control" id="harga_konversi_currency_'+param_list_val+'" value=""\
          onkeyup="nilai_currency(this);"\
        />\
        <input type="hidden" class="form-control" id="harga_konversi_'+param_list_val+'" name="harga_konversi[]" value="" />\
      </td>\
      <td>\
        <a class="btn btn-danger" onclick="hapus_konversi('+param_list_val+')"><i class="fa fa-trash-o"></i></a>\
      </td>\
    </tr>\
  ');
  open_select(param_list_val);
  $('.selectpicker').selectpicker('refresh');
  $('#param_list').val(param_list_val);
}

$(function(){
  var item_id = $('#id').val();
  var konversi_list_body = $('#konversi_list_body');
  var no = 1;
  if (item_id) {
    $.ajax({
      type:'POST',
      data:{item_id:item_id},
      url:'stock.php?page=table_konversi',
      dataType:'json',
    }).done(function(data) {
      for (var i = 0; i < data.length; i++) {
        $('#param_list').val(no);
        konversi_list_body.append('\
          <tr id="konversi_row_'+no+'">\
            <td>'+no+'</td>\
            <td><input class="form-control" id="jumlah_acuan_'+no+'" name="jumlah_acuan[]" value="'+data[i].jumlah_acuan+'" /></td>\
            <td><select class="" id="unit_1_'+no+'" name="unit_1[]"></select></td>\
            <td><input class="form-control" id="jumlah_konversi_'+no+'" name="jumlah_konversi[]" value="'+data[i].jumlah_konversi+'" /></td>\
            <td><select class="" id="unit_2_'+no+'" name="unit_2[]" onchange="get_harga_konversi('+no+')"></select></td>\
            <td>\
              <input class="form-control" id="harga_konversi_currency_'+no+'" value="'+format_rupiah(data[i].harga_konversi)+'"\
                onkeyup="nilai_currency(this);"\
              />\
              <input type="hidden" class="form-control" id="harga_konversi_'+no+'" name ="harga_konversi[]"value="'+data[i].harga_konversi+'" />\
            </td>\
            <td>\
              <a class="btn btn-danger" onclick="hapus_konversi('+data[i].unit_konversi_id+','+no+')"><i class="fa fa-trash-o"></i></a>\
            </td>\
          </tr>\
        ');
        open_select(no, data[i].unit_1, data[i].unit_2);
      no++; }
    })
  }
});

function open_select(id, unit_1, unit_2){
  var unit_acuan_1 = $('#unit_1_'+id);
  var unit_acuan_2 = $('#unit_2_'+id);
  $.ajax({
    type  :'GET',
    url   :'stock.php?page=konversi_list',
    dataType:'json',
  }).done(function(data){
    unit_acuan_1.empty();
    unit_acuan_2.empty();

    unit_acuan_1.append('<option value="0"></option>');

    for (var i = 0; i < data.length; i++) {
      var str_1 = '';
      if (unit_1==data[i].unit_id) {str_1="selected"};
      unit_acuan_1.append('\
        <option '+str_1+' value="'+data[i].unit_id+'">'+data[i].unit_name+'</option>\
      ');
    }

    unit_acuan_2.append('<option value="0"></option>');

    for (var i = 0; i < data.length; i++) {
      var str_2 = '';
      if (unit_2==data[i].unit_id) {str_2="selected"};
      unit_acuan_2.append('\
        <option '+str_2+' value="'+data[i].unit_id+'">'+data[i].unit_name+'</option>\
      ');
    }

    $('.selectpicker').selectpicker('refresh');
  })
}

function get_harga_konversi(id){
  var unit_1 = $('#unit_1_'+id);
  var unit_2 = $('#unit_2_'+id);

  var unit_utama = $('#i_unit').val();
  var i_harga_jual = $('#i_harga_jual').val();

  var jumlah_acuan    = $('#jumlah_acuan_'+id);
  var jumlah_konversi = $('#jumlah_konversi_'+id);

  var harga_konversi_ = 0;

  var harga_konversi = $('#harga_konversi_'+id);
  var harga_konversi_currency = $('#harga_konversi_currency_'+id);

  if (unit_1.val() == unit_utama) {
    if (jumlah_acuan.val()>jumlah_konversi.val()) {
      harga_konversi_ = parseInt(i_harga_jual)*parseInt(jumlah_acuan.val());
    } else {
      harga_konversi_ = parseInt(i_harga_jual)/parseInt(jumlah_acuan.val());
    }
  }
  harga_konversi.val(harga_konversi_);
  harga_konversi_currency.val(format_rupiah(harga_konversi_));
}

function hapus_konversi(id, no){
  var konversi_row = $('#konversi_row_'+no);
  url = "stock.php?page=delete_unit_konversi";
  $.ajax({
             type   : "POST",
             url    : url,
             data   : {unit_konversi_id:id}, // serializes the form's elements.
             success: function(data)
             {
                alert("Hapus Sukses");
             },
             error: function() {
               alert("Hapus Konversi Gagal !!");
             }
           });

  konversi_row.empty();
}


$(function(){
  var item_id = $('#id').val();

  $('#btn_simpan_konversi').on('click', function(){
    var url = "stock.php?page=simpan_konversi&item_id="+item_id; // the script where you handle the form input.

    $.ajax({
               type   : "POST",
               url    : url,
               data   : $('#mytable :input').serialize(), // serializes the form's elements.
               success: function(data)
               {
                  alert("Penyimpanan Sukses");
               },
               error: function() {
                 alert("Simpan Konversi Gagal !!");
               }
             });

  })
});

function submitForm(action){
  document.getElementById('form').action = action;
  document.getElementById('form').submit();
}
</script>
<script src="../js/capitalize.js"></script>
