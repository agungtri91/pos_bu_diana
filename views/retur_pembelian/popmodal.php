<style media="screen">
.jumlah{
	width: 198.66666px;
	max-width: auto;
  height: 60px;
	font-size: 50px;
	color: #000;
	text-align: center;
	background-color: #fff !important;
	font-family: inherit;
}
.col-md-6{
	padding: 0;
}
#frame{
	padding: 15px
	border: 1px solid;
	width: 231.66666px;
}
</style>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
	<div class="popmodal_title" style="font-size: 18px; margin-bottom:0;text-align:center;"><?= $item_name ?></div>
</div>
<form action="retur_pembelian.php?page=save_tmp" enctype="multipart/form-data" method="post">
	<div class="modal-body">
		<input type="hidden" id="purchase_detail_id" name="purchase_detail_id" value="<?=$id?>"/>
		<input type="hidden" id="purchase_id" name="purchase_id" value="<?=$purchase_id?>"/>
		<input type="hidden" id="purchase_qty" name="purchase_qty" value="<?=$qty?>"/>
		<!-- <input value="<?= $qty - 1?>" name="i_qty_retur" id="i_qty_retur" style="border:none;background:none;"/> -->
		<div class="row">
				<div class="col-md-4">
					<center>
						<div id="frame" class="" style="width:50%;">
							<label>Jumlah Item : </label>
							<div class="row">
								<input type="hidden" name="i_unit_beli" id="i_unit_beli" value="<?= $unit_id_beli?>">
								<input value="<?= $qty-1?>" type="" name="i_qty_retur" id="i_qty_retur"
								class="jumlah form-control" style="	" readonly/>
								<input type="hidden" id="i_stock_real" name="i_stock_real" value="<?= $qty?>"/>
							</div>
					    <div class="input-group" style="float: left; width: 200px;">
					      <span class="input-group-btn">
					        <button class="btn btn-default text_popmodal" type="button"
									style="color:white; background-color:black" onclick="addmin('min')">-</button>
					      </span>
					      <input type="text" class="form-control text_popmodal" value="1"
								name="i_qty_popmodal" id="i_qty_popmodal"/>
						  	<span class="input-group-btn">
					        <button class="btn btn-default text_popmodal" type="button"
									style="color:white; background-color:black" onclick="addmin('plus')">+</button>
					      </span>
					    </div>
							<div style="float: left; line-height: 53px; margin: 0px 0px -10px 30px;">
							</div>
						<input type="hidden" class="form-control" value="<?= $item_id ?>"
						name="i_item_id_popmodal" id="i_item_id_popmodal"/>
						</div>
					</center>
				</div>
			<div class="col-md-8">
				<div class="form-group">
					<label>Satuan Beli</label>
					<h1 style="margin:5px;"><?= strtoupper($unit_beli_name)?></h1>
				</div>
				<div class="form-group" id="sisa_satuan_utama"></div>
				<label>Harga Beli</label>
				<div class="form-group">
					<input type="number" name="harga_beli" id="harga_beli" value="<?= $harga_beli?>"
					class="form-control" style="font-size:20px;" readonly>
				</div>
				<label>Harga Beli Retur</label>
				<div class="form-group">
					<input type="number" name="harga_beli_retur" id="harga_beli_retur" class="form-control" style="font-size:20px;">
				</div>
				<div class="form-group">
					<label>Satuan</label>
					<select id="i_unit" name="i_unit" class="selectpicker show-tick form-control"
					data-live-search="true" onchange="konversi_qty()">
						<option value="0"></option>
						<?php
						while ($r_satuan = mysql_fetch_array($q_item_satuan)) {?>
							<option value="<?= $r_satuan['unit']?>"><?= get_unit_name($r_satuan['unit'])?></option>
						<?}?>
					</select>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<label>Keterangan Retur</label>
					<div class="form-group">
						<textarea class="form-control" rows="5" name="i_desc" ></textarea>
					</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="Submit" name="button" class="btn btn-primary">Simpan</button>
		<a data-dismiss="modal"class="btn btn-danger" >Batal</a>
	</div>
</form>
<script>

$(document).ready(function(){
	$('.selectpicker').selectpicker('refresh');
});

var x = document.getElementById('purchase_qty').value;
$(function(){
	addmin = function(operation){
		var jumlah =  $("#i_qty_popmodal").val();
		var jml_yg_sudah_di_retur =  $("#i_qty_retur").val();
		jumlah = parseInt(jumlah);
		jml_yg_sudah_di_retur = parseInt(jml_yg_sudah_di_retur);
		if(operation == "min"){
			jumlah = jumlah-1;
			jml_yg_sudah_di_retur = jml_yg_sudah_di_retur + 1;
		}else{
			jumlah = jumlah+1;
			jml_yg_sudah_di_retur = jml_yg_sudah_di_retur - 1;
		}
		if(jumlah>0){
			// jumlah = String(jumlah);
			$('input[name=i_qty_popmodal]').val(jumlah);
			$('input[name=i_qty_retur]').val(jml_yg_sudah_di_retur);
		}
		if (jumlah > x) {
			alert("Melebihi jumlah item");
			$('input[name=i_qty_popmodal]').val(x);
			$('input[name=i_qty_retur]').val(0);
		}
	}
});

function konversi_qty(){
	var a = $('#i_unit_beli').val();
	var x = $('#i_unit').val();
	var y = $('#i_stock_real').val();
	var z = $('#i_item_id_popmodal').val();
	$.ajax({
			type:'POST',
			data:{a:a,x:x,y:y,z:z},
			url:'retur_pembelian.php?page=get_konversi',
			dataType:'json',
	}).done(function(data) {
			var i = $('#i_qty_popmodal').val();
			$('#i_qty_retur').val(data.qty-i);
			$('#purchase_qty').val(data.harga_konversi);
	});
}
</script>
