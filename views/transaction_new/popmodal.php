
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
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<div class="popmodal_title" style="font-size: 18px; margin-bottom:0;text-align:center;"><?= $item_name ?></div>
</div>
<div class="modal-body">
	<form class="" action="<?= $action?>" method="post" enctype="multipart/form-data" role="form">
		<div class="row">
			<div class="col-md-12">
				<input type="hidden" id="test1" name="test1" value="<?=$member_id?>"/>
				<input type="hidden" id="branch_id" name="branch_id" value="<?= $branch_id?>"/>
				<input type="hidden" id="item_id" name="item_id" value="<?= $item_id?>"/>
				<input type="hidden" name="transaction_id" value="<?= $transaction_id?>"/>
				<input type="hidden" name="tanggal" value="<?= $tanggal?>"/>
				<input type="hidden" id="i_partner" name="i_partner" value="<?= $i_partner?>"/>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<center>
					<label>Jumlah Item Saat Ini:</label>
					<div  id="frame" class="" style="width:80%;">
						<div class="row">
							<input type="text" name="i_stock_currency" id="i_stock_currency" class="jumlah form-control"
							style="width: 80%;"  value="<?= format_rupiah($qty-1)?>">
							<input type="hidden" id="i_stock" name="i_stock" value="<?= $qty-1?>">
							<input type="hidden" id="i_stock_real" name="i_stock_real" value="<?= $qty?>">
						</div>
						<div class="row" style="text-align: center;">
							<center>
								<div class="input-group" style="width: 80%;">
									<span class="input-group-btn">
										<button id="min" class="btn btn-default text_popmodal" type="button"
										style="color:white; background-color:black" onclick="addmin('min')">
											-
										</button>
									</span>
									<input type="text" class="form-control text_popmodal" value="1" name="i_qty_popmodal" id="i_qty_popmodal"/>
									<span class="input-group-btn">
										<button id="plus" class="btn btn-default text_popmodal" type="button"
										style="color:white; background-color:black" onclick="addmin('plus')">
											+
										</button>
									</span>
								</div>
							</center>
							<!-- <div style="float: left; line-height: 53px; margin: 0px 0px -10px 30px;">
							</div> -->
						<input type="hidden" class="form-control" value="<?= $item_id ?>" name="i_item_id_popmodal" id="i_item_id_popmodal"/>
						</div>
					</div>
				</center>
				<div class="" style="display:;">
					<div class="form-group">
						<label>Satuan Utama</label>
						<h1 style="margin:5px;"><?= strtoupper($unit_utama_name)?></h1>
					</div>
					<div class="form-group" id="sisa_satuan_utama"></div>
					<div class="form-group">
						<label>Satuan</label>
						<select id="i_unit" name="i_unit" class="selectpicker show-tick form-control"
						data-live-search="true" onchange="konversi_qty()">
							<option value="0"></option>
							<?php
							while ($r_satuan = mysql_fetch_array($q_item_satuan)) {?>
								<option value="<?= $r_satuan['unit_id']?>"><?= $r_satuan['unit_name']?></option>
							<?}?>
						</select>
					</div>
				</div>
				<br>
			</div>
		</div>
		<div class="modal-footer">
			<button type="Submit" name="button" class="btn btn-primary">Simpan</button>
      <a data-dismiss="modal"class="btn btn-danger" >Batal</a>
		</div>
	</div>
	</form>
<script>
var x = document.getElementById('i_stock').value;
var y = document.getElementById('i_stock_real').value;
var item_harga =  $("#i_stock").val();
$(function(){
	addmin = function(operation){
		var stock =  $("#i_stock").val();
		var jumlah =  $("#i_qty_popmodal").val();
		jumlah = parseFloat(jumlah);
		stock = parseFloat(stock);
		if(operation == "min"){
			jumlah = jumlah-1;
			stock = stock + 1;
		}else{
			jumlah = jumlah+1;
			stock = stock - 1;
		}
		if(jumlah>0){
			// jumlah = String(jumlah);
			$('input[name=i_qty_popmodal]').val(jumlah);
		}
		if(jumlah>0){
			// jumlah = String(jumlah);
			$('input[name=i_qty_popmodal]').val(jumlah);
			$('input[name=i_stock]').val(stock);
		}
		if (jumlah > x) {
			alert("Melebihi jumlah item");
			// document.getElementById('i_save').disabled = true;
			$('input[name=i_qty_popmodal]').val(x);
			$('input[name=i_stock]').val(0);
		}
		if (stock <= 0) {
			$('#plus').prop('disabled', true);
		}else {
			$('#plus').removeProp('disabled');
		}
		var angka_currency = toRp(stock);
		$('#i_stock_currency').val(angka_currency);
	}
});

	$(document).ready(function(){
		$('.selectpicker').selectpicker('refresh');
	});

function konversi_qty(){
	var x = $('#i_unit').val();
	var y = $('#i_stock_real').val();
	var z = $('#item_id').val();
	$.ajax({
			type:'POST',
			data:{x:x,y:y,z:z},
			url:'transaction_new.php?page=get_konversi',
			dataType:'json',
	}).done(function(data) {
		$('#i_stock').empty();
		$('#i_qty_popmodal').val(1);
		var i = $('#i_qty_popmodal').val();
		$('#sisa_satuan_utama').empty();
		$('#i_stock').val(data.qty-i);
		$('#i_stock_currency').val(toRp(data.qty-i));
		$('#sisa_satuan_utama').append('\
			<label>Sisa dalam satuan utama</label>\
			<h1 id="qty_sisa">'+data.sisa+'</h1>\
			<input type="hidden" id="qty_sisa" name="qty_sisa" value="'+data.sisa+'"></input>\
		');
	});
}

</script>
