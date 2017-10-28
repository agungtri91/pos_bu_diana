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
<form action="retur.php?page=save_tmp" enctype="multipart/form-data" method="post">
	<div class="modal-body">
		<input type="hidden" id="transaction_detail_id" name="transaction_detail_id" value="<?=$id?>"/>
		<input type="hidden" id="transaction_id" name="transaction_id" value="<?=$transaction_id?>"/>
		<input type="hidden" id="transaction_detail_qty" name="transaction_detail_qty" value="<?=$qty?>"/>
		<div class="row">
			<div class="col-md-6">
				<center>
					<div id="frame" class="">
						<label>Jumlah Item di Pembeli : </label>
						<div class="row">
							<input type="hidden" name="i_unit_jual" id="i_unit_jual" value="<?= $unit_id_jual?>">
							<input value="<?= $qty-1?>" type="" name="i_qty_retur" id="i_qty_retur" class="jumlah form-control" style="	" readonly/>
							<input type="hidden" id="i_stock_real" name="i_stock_real" value="<?= $qty?>"/>
						</div>
						<div class="row">
							<div class="input-group" style="float: left;">
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
							<div style="float: left; line-height: 53px; margin: 0px 0px -10px 30px;">
							</div>
						<input type="hidden" class="form-control" value="<?= $item_id ?>" name="i_item_id_popmodal" id="i_item_id_popmodal"/>
						</div>
					</div	>
					<div style="float: left; line-height: 53px; margin: 0px 0px -10px 30px;">
						<label style="font-size:40px;"></label>
					</div>
			</div>
		</center>
			<div class="col-md-6">
				<div class="form-group">
					<label>Satuan Jual</label>
					<h1 style="margin:5px;"><?= strtoupper($unit_jual_name)?></h1>
				</div>
				<div class="form-group" id="sisa_satuan_utama"></div>
				<div class="form-group">
					<label>Harga Jual</label>
					<input type="text" name="harga_konversi_currency" id="harga_konversi_currency" class="form-control"
					style="font-size:20px;" value="<?= format_rupiah($harga_jual)?>" readonly>
					<input type="hidden" name="harga_konversi" id="harga_konversi" class="form-control"
					style="font-size:20px;" value="<?= $harga_jual?>" readonly>
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
		<br>
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

	$(function(){
		var x = document.getElementById('i_qty_retur').value;
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
				$('#i_qty_popmodal').val(jumlah);
				$('input[name=i_qty_retur]').val(jml_yg_sudah_di_retur);
			}
			if (jumlah < 0 || jml_yg_sudah_di_retur < 0 ) {
				alert("Melebihi jumlah item");
				$('input[name=i_qty_popmodal]').val(x);
				$('input[name=i_qty_retur]').val(0);
			}
		}
	});

	function konversi_qty(){
		var a = $('#i_unit_jual').val();
		var x = $('#i_unit').val();
		var y = $('#i_stock_real').val();
		var z = $('#i_item_id_popmodal').val();
		$.ajax({
				type:'POST',
				data:{a:a,x:x,y:y,z:z},
				url:'retur.php?page=get_konversi',
				dataType:'json',
		}).done(function(data) {
				var i = $('#i_qty_popmodal').val();
				$('#i_qty_retur').val(data.qty-i);
				$('#transaction_detail_qty').val(data.harga_konversi);
		});
	}
	</script>
