<script type="text/javascript">
	function get_quantity(type){
		var i_qty_popmodal = document.getElementById("i_qty_popmodal").value;
		if(type == 1){
			new_data = parseFloat(i_qty_popmodal) + 1;
		}else{
			if(i_qty_popmodal != 1){
				new_data = i_qty_popmodal - 1;
			}else{
				new_data = 1;
			}
		}
		document.getElementByName("i_qty_popmodal").value = "99";
		//alert(new_data);
	}
</script>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<div class="popmodal_title" style="font-size: 18px; margin-bottom:0;text-align:center;"><?= $item_name ?></div>
</div>
<form class="" action="<?= $action?>" method="post">
	<div class="modal-body">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-4" style="top:43px;">
			    <div class="input-group" style="float: left; width: 200px;">
						<input type="hidden" name="tanggal" value="<?= $tanggal?>">
			      <span class="input-group-btn">
			        <button class="btn btn-default text_popmodal" type="button" style="color:white; background-color:black"
							onclick="addmin('min')">-</button>
			      </span>
			      <input type="text" class="form-control text_popmodal" value="1" name="i_qty" id="i_qty"/>
				  	<span class="input-group-btn">
			        <button class="btn btn-default text_popmodal" type="button" style="color:white; background-color:black"
							onclick="addmin('plus')">+</button>
			      </span>
			    </div>
					<div style="float: left; line-height: 53px; margin: 0px 0px -10px 30px;">
						<label style="font-size:40px;"></label>
					</div>
				</div>
		      <input type="hidden" id="item_id" name="item_id" value="<?=$item_id?>"/>
		      <input type="hidden" id="purchase_id" name="purchase_id" value="<?=$purchase_id?>"/>
					<input type="hidden" id="i_supplier" name="i_supplier" value="<?=$supplier_id?>"/>
		      <input type="hidden" id="i_branch_id" name="i_branch_id" value="<?=$branch_id?>"/>
				<div class="col-md-8">
					<label>Harga</label>
					<input required type="text" id="i_harga_curency" name="i_harga_curency" class="form-control" placeholder="Masukkan harga..."/>
					<input required type="hidden" id="i_harga" name="i_harga"/>
					<label>Satuan</label>
					<select id="i_unit" name="i_unit" size="1" class="selectpicker show-tick form-control" data-live-search="true">
		        <option value="0"></option>
		        <?php
						while($r_unit_item = mysql_fetch_array($q_unit_item)){ ?>
		        	<option value="<?= $r_unit_item['unit_id'] ?>"><?= $r_unit_item['unit_name']?></option>
		        <?}?>
		      </select>
				</div>
			</div>
		</div>
		<br>
		<div style="clear:both;"></div>
		<div class="modal-footer">
			<button type="Submit" name="button" class="btn btn-primary">Simpan</button>
      <a data-dismiss="modal"class="btn btn-danger" >Batal</a>
		</div>
</form>
<script type="text/javascript">
	$(function(){
		addmin = function(operation){
				var jumlah =  $("#i_qty").val();
				jumlah = parseInt(jumlah);
				if(operation == "min"){
					jumlah = jumlah-1;
				}else{
					jumlah = jumlah+1;
				}
				if(jumlah>0){
					// jumlah = String(jumlah);
					$('input[name=i_qty]').val(jumlah);
				}
			}
		});
	$('.selectpicker').selectpicker('refresh');

	$(function(){
		$('#i_harga_curency').keyup(function(e){
			  var price = $("#i_harga_curency").val();
				var str = remove_rupiah(price);
				var str = remove_currency(str);
        $("#i_harga").val(str);
        $(this).val(format_rupiah($(this).val()));
		})
	});
</script>
