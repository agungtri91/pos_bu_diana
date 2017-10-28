<!-- transaksi penjualan -->
<script type="text/javascript" src="../js/search2/jcfilter.min.js"></script>
<script type="text/javascript" src="../js/shortcut.js"></script>
<script type="text/javascript">
	function filter_cat(){
		alert("test");
	}

	function CurrencyFormat(number){
	   var decimalplaces = 0;
	   var decimalcharacter = "";
	   var thousandseparater = ",";
	   number = parseFloat(number);
	   var sign = number < 0 ? "-" : "";
	   var formatted = new String(number.toFixed(decimalplaces));
	   if( decimalcharacter.length && decimalcharacter != "." ) { formatted = formatted.replace(/\./,decimalcharacter); }
	   var integer = "";
	   var fraction = "";
	   var strnumber = new String(formatted);
	   var dotpos = decimalcharacter.length ? strnumber.indexOf(decimalcharacter) : -1;
	   if( dotpos > -1 )
	   {
	      if( dotpos ) { integer = strnumber.substr(0,dotpos); }
	      fraction = strnumber.substr(dotpos+1);
	   }
	   else { integer = strnumber; }
	   if( integer ) { integer = String(Math.abs(integer)); }
	   while( fraction.length < decimalplaces ) { fraction += "0"; }
	   temparray = new Array();
	   while( integer.length > 3 )
	   {
	      temparray.unshift(integer.substr(-3));
	      integer = integer.substr(0,integer.length-3);
	   }
	   temparray.unshift(integer);
	   integer = temparray.join(thousandseparater);
	   return sign + integer + decimalcharacter + fraction;
	}

	function get_total_price(){
		var total_harga = 0;

		document.getElementById("i_total_harga").value = total_harga;
		document.getElementById("i_total_harga_rupiah").value = CurrencyFormat(total_harga);
	}

	function confirm_delete_history(id){
		var a = confirm("Anda yakin ingin menghapus order ini ?");
		var transaction_id = document.getElementById("i_transaction_id").value;

		if(a==true){
			window.location.href = 'transaction_new.php?page=delete_history&transaction_id=' + transaction_id + '&id=' + id;
		}
	}
</script>
<link rel="stylesheet" href="../css/transaction_new.css">
<?php if(isset($_GET['did']) && $_GET['did'] == 1){ ?>
<section class="content_new">
	<div class="alert alert-info alert-dismissable">
		<i class="fa fa-check"></i>
		<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
		<b>Sukses !</b>
		Simpan Berhasil
	</div>
</section>
<?php }else if(isset($_GET['err']) && $_GET['err'] == 1){ ?>
<section class="content_new">
	<div class="alert alert-warning alert-dismissable">
		<i class="fa fa-check"></i>
		<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
		<b>Simpan Gagal !</b>
		Harga masih kosong, Pilih terlebih dahulu !
	</div>
</section>
<?php } ?>
	<form id="form" method="post" enctype="multipart/form-data" role="form">
	<!-- Main content -->
		<section class="content" style="padding-top: 0">
			<div class="row">
			<div class="row">
				<div class="col-md-4">
					<?php
							$transaction_id = get_last_id("transactions","transaction_id");
							if($transaction_id)
								{
									$transaction_id = $transaction_id + 1;
								}
								else {
									$transaction_id = 1;
								}
								?>
						<br>
						<div class="input-group">
							<input type="hidden" required class="form-control pull-right" name="i_transaction_id" id="i_transaction_id"value="<?= $transaction_id?>"/>
						</div>
				</div>
			</div>
					<?php
						$get_all_jumlah = get_all_jumlah($transaction_id);
						$get_all_item	= get_all_item($transaction_id);
					?>
				<div class="col-md-12" id="table_menu">
					<div class="box box-cokelat">
						<div class="box-body">
							<div class="container">
							<!-- Top Navigation -->
								<section class="color-2">
									<div class="row">
										<div class="col-md-2">
											<div class="form-group">
												<label>Tanggal :</label>
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</div>
													<?php
													if (isset($_SESSION['tanggal']) && $_SESSION['tanggal']==true) {
														$date = $_SESSION['tanggal'];
													}else {
														$date = $date;
													}
													 ?>
														<input type="text" required class="form-control pull-right"
														id="date_picker1" name="i_date" value="<?= $date ?>"/>
												</div><!-- /.input group -->
											</div>
										</div>
										<!-- <?php echo $_SESSION['member_id'] ?> -->
										<div class="col-md-2">
											<div id="i_member" class="form-group">
												<label>Nama Pembeli:</label>
												<select name="i_member_id" id="i_member_id" class="selectpicker show-tick form-control"
												data-live-search="true" value="0" onchange="tambah_pembeli()">
													<option value="0"></option>
													<?php
													$member_id = isset($_SESSION['member_id']) ? $_SESSION['member_id'] : null;
													while ($r_member = mysql_fetch_array($q_member)) {
														$xx = get_member_tanggungan($r_member['member_id']);?>
														<?php if ($xx==0): ?>
														<option value="<?= $r_member['member_id']?>"
															<?php if ($member_id == $r_member['member_id']){echo "Selected";}?>>
																<?= $r_member['member_name']?>
														</option>
														<?php endif; ?>
													<? } ?>
													<option type="button" id="tambah_pembeli" class="btn btn-default" value="+">
														- - - Tambah Pembeli - - -
													</option>
												</select>
											</div>
										</div>
										<div class="col-md-2">
											<div id="i_member" class="form-group">
												<label>Cabang :</label>
												<select name="i_branch_id" id="i_branch_id" class="selectpicker show-tick form-control" data-live-search="true" value="0">
													<option value="0"></option>
													<?php
													if ($_SESSION['branch_id_1']) {
														$type = $_SESSION['branch_id_1'];
													}
														else {
															$type = $_SESSION['branch_id'];
														}
													$query=mysql_query("select * from branches order by branch_name");
													while($row_branch=mysql_fetch_array($query)){
														?><option value="<?= $row_branch['branch_id']?>"<?php if($type == $row_branch['branch_id']){echo "Selected";} ?>>
															<?= $row_branch['branch_name']; ?>
														</option>
													<?php } ?>
												</select>
											</div>
										</div>
										<div class="col-md-2">
											<div class="form-group">
												<label>Partner</label>
												<select class="selectpicker show-tick form-control" id="i_partner" name="i_partner" data-live-search="true" value="0">
													<option value="0"></option>
													<?php
													if ($_SESSION['partner_id']) {
															$type = $_SESSION['partner_id'];
														}?>
													<?php while ($r_partner = mysql_fetch_array($q_partner)) {?>
														<option value="<?= $r_partner['partner_id']?>" <?php if ($type == $r_partner['partner_id']){echo "Selected";}?>>
														<?= $r_partner['partner_name']?>
														</option>
													<?} ?>
												</select>
											</div>
										</div>
									</div><!-- row -->
									<div id="table_history"></div>
										<div class="row">
										<br>
											<div class="col-md-3" style="padding-left:0px;">
												<div class="form-group">
													<div class="btn btn-block btn_cat_button" id="menu" onclick="menu()"> All Categories</div>
												</div>
											</div>
											<div class="row">
												<?php
												$query=mysql_query("select * from kategori");
												while($m_kategori = mysql_fetch_array($query)){?>
													<div class="col-md-3" style="padding-left:0px;">
														<div class="form-group">
															<div class="btn btn-block btn_cat_button sub_btn" id="menu_type_id<?= $m_kategori['kategori_id']?>"
																onclick="sub_menu('<?= $m_kategori['kategori_id']?>')">
																<?= $m_kategori['kategori_name']?>
															</div>
														</div>
													</div>
												<?php }?>
											</div>
										<!-- sub menu select -->
										<input type="hidden" id="param_id" name="param_id" value="1">
										<div id="sub_menu_v" style="margin-top: 13px;"><!-- menu.css --></div>
										<!-- end sub menu select2 -->
										<div style="clear:both"></div>
										<div id="all_menu" class="all_menu"></div>
										<div id="all_menu_list">
											<div class="">
												<table id="menu_list_tb" class="table table-bordered" style="display:;">
													<thead id="menu_list_head_tb">
														<tr>
															<th style="width:5%;" align="center">No.</th>
															<th>Nama Item</th>
															<th>Jumlah Stock</th>
															<th style="text-align:center;">Harga</th>
															<th>Order</th>
															<th>Satuan</th>
															<th style="text-align:center;">Pilih</th>
														</tr>
													</thead>
													<tbody id="menu_list_body_tb">
													</tbody>
												</table>
											</div>
										</div>
										<div style="clear:both"></div>
										</div>
							</div>
						</div><!-- /container -->
						<div style="height:100px; width:100%;"></div>
					</div>
				</div>
						</section>
			</div>
		</section><!-- /.content -->
		<section class="content_checkout">
			<div class="row">
				<div class="col-md-6">
					<div class="col-xs-8">
						<div class="form-group">
							<input required type="hidden" readonly="readonly" name="i_total_harga"
							id="i_total_harga" class="form-control total_checkout" value="<?= $get_all_jumlah ?>"/>
							<input required type="text" readonly="readonly" name="i_total_harga_rupiah"
							id="i_total_harga_rupiah" class="form-control total_checkout" value="<?= format_rupiah($get_all_jumlah)?>"/>
						</div>
					</div>
					<div class="col-xs-4">
						<div class="form-group">
							<input class="btn btn-danger button_checkout" onclick="simpan_form()" value="Simpan"/>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="col-xs-10">
						<div class="form-group">
							<input type="text" name="searchText" id="filter" class="form-control cari_checkout"
							value="" onkeypress="check_filter()" placeholder="Cari item..."/>
						</div>
					</div>
					<div class="col-xs-2">
						<button type="button"  id="bullet-btn" 	name="new_stock" class="btn btn-danger btn_cat_button" onclick="table_widget()">
							<i class="fa fa-shopping-cart" aria-hidden="true" style="font-size:30px;color:#fff;" ></i>
						</button>
					</div>
				</div>
			</div>
		</section>
</form>
 <!-- start popmodal -->
<div id="item_popmodal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
aria-labelledby="myLargeModalLabel" style="z-index:3;">
 <div class="modal-dialog modal-lg" role="document"  style="width:600px;">
	 <div class="modal-content" id="item_popmodal_content" style="border-radius:0px;">

	 </div>
 </div>
</div>

<div id="tambah_pembeli_popmodal" class="modal fade bs-example-modal-lg" tabindex="-1"
role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document" style="width:1200px;">
    <div class="modal-content" id="tambah_pembeli_popmodal_content" style="border-radius:0;">

    </div>
  </div>
</div>
<!-- end popmodal -->

<script type="text/javascript">
	function table_widget(){
		var transaction_id = document.getElementById('i_transaction_id').value;
		$('#large_modal').modal();
		var url = 'transaction_new.php?page=popmodal_widget&id='+transaction_id;
      $('#large_modal_content').load(url,function(result){
    });
	}

   jQuery(document).ready(function(){
      jQuery("#filter").jcOnPageFilter({animateHideNShow: true,
                focusOnLoad:true,
                highlightColor:'#E9F0F5',
                textColorForHighlights:'#E9F0F5',
                caseSensitive:false,
                hideNegatives:true,
                parentLookupClass:'jcorgFilterTextParent',
                childBlockClass:'jcorgFilterTextChild'});

   });


	function dialogModal(x){
		var a = document.getElementById('date_picker1').value;
		var b = document.getElementById('i_member_id').value;
		var c = document.getElementById('i_transaction_id').value;
		var d = document.getElementById('i_branch_id').value;
		var i_partner = document.getElementById('i_partner').value;
		$('#item_popmodal').modal();
		var url = 'transaction_new.php?page=popmodal&item_id='+x+'&member_id='+b+'&transaction_id='+c+'&branch_id='+d+'&tanggal='+a+'&i_partner='+i_partner;
      $('#item_popmodal_content').load(url,function(result){
    });
		$('#date_picker2').datepicker('refresh');
		$('.selectpicker').selectpicker('refresh');
	}

	function get_change(view){
		var color = "#fff";
		var color_hover = "#676464";
		$(".menu-bar-btn").css("background-color", color);
		$(".ha").css("color", color_hover);
		$(".fa_"+view).css("color", color);
		document.getElementById("btn_bar_"+view).style.backgroundColor = "#d82827";
		document.getElementById("btn_bar_icon_"+view).style.backgroundColor = "#d82827";
			if (view == 1) {
				$('#all_menu').html('');
				$("#menu").attr("onclick","list_menu()");
				$('#param_id').val(1);
				document.getElementById('all_menu_list').style.display="block";
			}else {
					$("#menu").attr("onclick","menu()");
					menu();
					$('#param_id').val(2);
					document.getElementById('all_menu_list').style.display="none";
			}
		}
function test() {
	alert("ok");
}
	function list_menu(){
		$('#all_menu').html('');
		$("#menu").attr("onclick","list_menu()");
		var transaction_id = <?php echo $transaction_id ?>;
		no = 1;
	$.ajax({
				type:'POST',
				data:{z:transaction_id},
				url: 'transaction_new.php?page=menu',
				dataType:'json',
			}).done(function(data){
				$('#menu_list_body_tb').empty();
				for (var i = 0; i < data.length; i++) {
					$('#menu_list_body_tb').append('\
						<tr id="tr_1_'+i+'">\
							<td align="center"><strong>'+no+'</strong></td>\
							<td class="item-name"><strong>'+data[i].item_name+'</strong></td>\
							<td width="15%">\
								<input id="item_id_'+i+'" class="no-border" type="hidden" value="'+data[i].item_id+'"></input>\
								<input id="real_stock_qty_'+i+'" class="no-border" type="hidden" value="'+data[i].qty+'"></input>\
								<input id="stock_qty_'+i+'" style="width:100px;" class="no-border"\
								 type="text" value="'+data[i].qty+'" readonly></input>\
								<input id="stock_qty_konversi_'+i+'" class="" type="hidden" value=""></input>\
								<input type="hidden" id="harga_1_'+i+'" class="" value="'+data[i].item_price+'"/>\
							</td>\
							<td id="harga_v_'+i+'" align="center"><strong>'+toRp(data[i].item_price)+'\
							</strong></td>\
							<td style="width:150px;">\
								<input type="number" style="width:150px;" class="form-control focus"  style="width:100px;"\
								id="focus_'+i+'" value="1"></input>\
								<input type="hidden" id="output_'+i+'" class="output"></input>\
							</td>\
							<td>\
								<select id="select_unit_'+i+'" class="selectpicker show-tick form-control"\
								onchange="konversi_qty_list('+i+')"\
								data-live-search="true">\
								<option value="0"></option>\
								</select>\
							</td>\
							<td style="text-align:center;">\
								<a id="simpan_'+i+'" href="javascript:void(0)"\
								 class="btn btn-primary tombol_focus" onclick="simpan('+i+')">Simpan</a>\
							</td>\
						</tr>\
					');
						var item_id = data[i].item_id;
						open_select(item_id, i);
						get_harga(1,i);
						no++;
						}
						$('.selectpicker').selectpicker('refresh');
			});
	}

	function konversi_qty_list(i){
		var unit 			= $('#select_unit_'+i).val();
		var real_qty 	= $('#real_stock_qty_'+i).val();
		var item_id 	= $('#item_id_'+i).val();
		$.ajax({
				type:'POST',
				data:{unit:unit,real_qty:real_qty,item_id:item_id},
				url:'transaction_new.php?page=get_konversi',
				dataType:'json',
		}).done(function(data) {
			var order = $('#focus_'+i).val();
			$('#stock_qty_'+i).val(data.qty-order);
			$('#stock_qty_konversi_'+i).val(data.qty-order);
			$('#harga_v_'+i).html('');
			$('#harga_v_'+i).html('<strong>'+toRp(data.harga_konversi)+'</strong>');
		});
	}

	$( "#menu_list_body_tb" ).delegate( "*", "focus blur", function() {
	  var elem = $( this );
		var elem_val = $( this ).val();
		var id = '';
		var id_val = '';
		$(document).on("click", ":focus", function() {
			id = this.id;
			id_val = this.value;
			myarr = id.split ("_");
			var myvar = myarr[0] + "_" + myarr[1];
			$('#output_'+myarr[1]).val(id_val);
			hitung_stock(myarr[1]);
	  })
	});


	function hitung_stock(i) {
		document.getElementById('focus_'+i);
		$(document).each(function(){
	      $(this).keyup(function(){
					var i_unit = $('#select_unit_'+i).val();
					var stock = $('#real_stock_qty_'+i).val();
					var order = $('#focus_'+i).val();
					var stock_view = $('#stock_qty_'+i).val();
					var stock_qty_konversi = $('#stock_qty_konversi_'+i).val();
					order = $.isNumeric(order)?order:0;
					if (i_unit == 0) {
		        $("#stock_qty_"+i).val(parseInt(stock)-parseInt(order));
						if ($("#stock_qty_"+i).val()<=0){
							$("#stock_qty_"+i).val(0);
						}
						if ($("#focus_"+i).val()<=0){
							$("#focus_"+i).val();
						}
					} else {
						$("#stock_qty_"+i).val(parseInt(stock_qty_konversi)-parseInt(order));
						if ($("#stock_qty_"+i).val()<=0){
							$("#stock_qty_"+i).val(0);
						}
						if ($("#focus_"+i).val()<=0){
							$("#focus_"+i).val();
						}
					}
				});
			});
		}

	function simpan(x){
		var url = "transaction_new.php?page=create_note";
		var i_item_id_popmodal = $('#item_id_'+x).val();
		var i_stock_real = $('#real_stock_qty_'+x).val();
		var i_qty_popmodal = $('#focus_'+x).val();
		var i_unit = $('#select_unit_'+x).val();
		var transaction_id = <?php echo $transaction_id ?>;
		var test1 = $('#i_member_id').val();
		var a = document.getElementById('date_picker1').value;
		var branch_id = $('#i_branch_id').val();
			if (i_qty_popmodal != 0) {
				$.post(url,
				 {
					i_item_id_popmodal : i_item_id_popmodal,
					i_stock_real : i_stock_real,
					i_qty_popmodal : i_qty_popmodal,
					i_unit : i_unit,
					transaction_id : transaction_id,
					test1 : test1,
					branch_id : branch_id
				});
				window.location.href ='transaction_new.php?page=list&transaction_id='+transaction_id+'';
			}else {
			alert("Jumlah item 0, isi kolom order terlebih dahulu");
			}
		}

	list_menu();

	// menu();

		function sub_menu(x){
			var transaction_id = <?php echo $transaction_id ?>;
			$('#sub_menu_v').html("");
			$.ajax({
				type:'POST',
				url:'transaction_new.php?page=sub_menu_2',
				data: {x:x},
				dataType:'json',
			}).done(function(data){
				for(var inn = 0; inn < data.length; inn++){
						$('#sub_menu_v').append(
							'<div class="col-md-3" style="padding-left:0px;">\
								<div class="form-group">\
								<div class="btn btn-block btn_cat_button"\
								 onclick="menu_sub('+data[inn].sub_kategori_id+')">\
								'+data[inn].sub_kategori_name+'</div>\
								</div>\
							</div>');
						}
				});
				$('#all_menu').html('');
				$('#menu_list_body_tb').html('');
				$.ajax({
					type:'POST',
					url:'transaction_new.php?page=menu_sub_2',
					data: {x:x,z:transaction_id},
					dataType:'json',
				}).done(function(data){
					var no = 1;
					$('#menu_list_body_tb').empty();
					for(var i = 0; i <= data.length; i++){
							$('#menu_list_body_tb').append('\
								<tr id="tr_1_'+i+'">\
									<td align="center"><strong>'+no+'</strong></td>\
									<td class="item-name"><strong>'+data[i].item_name+'</strong></td>\
									<td width="15%">\
										<input id="item_id_'+i+'" class="no-border" type="hidden" value="'+data[i].item_id+'"></input>\
										<input id="real_stock_qty_'+i+'" class="no-border" type="hidden" value="'+data[i].qty+'"></input>\
										<input id="stock_qty_'+i+'" style="width:100px;" class="no-border"\
										 type="text" value="'+data[i].qty+'" readonly></input>\
										<input id="stock_qty_konversi_'+i+'" class="" type="hidden" value=""></input>\
										<input type="hidden" id="harga_1_'+i+'" class="" value="'+data[i].item_price+'"/>\
									</td>\
									<td id="harga_v_'+i+'" align="center"><strong>'+toRp(data[i].item_price)+'\
									</strong></td>\
									<td style="width:150px;">\
										<input type="number" style="width:150px;" class="form-control focus"  style="width:100px;"\
										id="focus_'+i+'" value="1"></input>\
										<input type="hidden" id="output_'+i+'" class="output"></input>\
									</td>\
									<td><select id="select_unit_'+i+'" class="selectpicker show-tick form-control"\
									 onchange="konversi_qty_list('+i+')"\
									 data-live-search="true">\
									 			<option value="0"></option>\
									 </select>\
									</td>\
									<td style="text-align:center;">\
										<a id="simpan_'+i+'" href="javascript:void(0)"\
										 class="btn btn-primary tombol_focus" onclick="simpan('+i+')">Simpan</a>\
									</td>\
								</tr>\
							');
								var item_id = data[i].item_id;
								open_select(item_id, i);
								get_harga(1,i);
								no++;
						no++;
						}
					});
		}

	function menu_sub(x){
		var transaction_id = <?php echo $transaction_id ?>;
		var no = 1;
		$('#all_menu').html("");
		$('#menu_list_body_tb').html("");
		$.ajax({
			type:'POST',
			url:'transaction_new.php?page=menu_sub',
			data: {x:x,z:transaction_id},
			dataType:'json',
		}).done(function(data){
			$('#menu_list_body_tb').empty();
				for(var i = 0; i <= data.length; i++){
						$('#menu_list_body_tb').append('\
							<tr id="tr_1_'+i+'">\
								<td align="center"><strong>'+no+'</strong></td>\
								<td class="item-name"><strong>'+data[i].item_name+'</strong></td>\
								<td width="15%">\
									<input id="item_id_'+i+'" class="no-border" type="hidden" value="'+data[i].item_id+'"></input>\
									<input id="real_stock_qty_'+i+'" class="no-border" type="hidden" value="'+data[i].qty+'"></input>\
									<input id="stock_qty_'+i+'" style="width:100px;" class="no-border"\
									 type="text" value="'+data[i].qty+'" readonly></input>\
									<input id="stock_qty_konversi_'+i+'" class="" type="hidden" value=""></input>\
									<input type="hidden" id="harga_1_'+i+'" class="" value="'+data[i].item_price+'"/>\
								</td>\
								<td id="harga_v_'+i+'" align="center"><strong>'+toRp(data[i].item_price)+'\
								</strong></td>\
								<td style="width:150px;">\
									<input type="number" style="width:150px;" class="form-control focus"  style="width:100px;"\
									id="focus_'+i+'" value="1"></input>\
									<input type="hidden" id="output_'+i+'" class="output"></input>\
								</td>\
								<td><select id="select_unit_'+i+'" class="selectpicker show-tick form-control"\
								 onchange="konversi_qty_list('+i+')"\
								 data-live-search="true">\
								 <option value="0"></option>\
								 </select></td>\
								<td style="text-align:center;">\
									<a id="simpan_'+i+'" href="javascript:void(0)"\
									 class="btn btn-primary tombol_focus" onclick="simpan('+i+')">Simpan</a>\
								</td>\
							</tr>\
						');
							var item_id = data[i].item_id;
							open_select(item_id, i);
							get_harga(1,i);
							no++;
					no++;
				}
			});
	}

	function cust_detail(){
		var x = document.getElementById('cust_detail');
		x.style.display = 'block';
	}

function tambah_pembeli()	{
	var param = $('#i_member_id').val();
	if (param =='+') {
		tambah_pembeli_modal();
	}
}

function tambah_pembeli_modal(){
	var a = document.getElementById('date_picker1').value;
	var b = document.getElementById('i_member_id').value;
	var c = document.getElementById('i_transaction_id').value;
	var d = document.getElementById('i_branch_id').value;
	$('#tambah_pembeli_popmodal').modal();
	var url = 'transaction_new.php?page=tambah_pembeli_popmodal&transaction_id='+c+'&branch_id='+d+'&tanggal='+a;
		$('#tambah_pembeli_popmodal_content').load(url,function(result){
	});
}

function onEnter(e){
	var key=e.keyCode || e.which;
	if(key==13){
		showCell();
	}
}

function showCell(){
	iObj=document.getElementById("jcorgFilterTextChild");
	index=iObj.value.trim();
	newIndex=eval(index)+1;

	rObj=document.getElementById("jcorgFilterTextChild");
	valBarcode=rObj.value.trim();

	rObj.value="";rObj.focus(); iObj.value=newIndex;
	doRequested('viewResult'+index,'readCell.php?val='+valBarcode+'&index='+newIndex,false);
}

$(document).ready(function() {
$('#menu_list_tb').DataTable( {
				"paging": false,
				"lengthChange": false,
				"searching": false,
				"ordering": false,
				"info": false,
				"autoWidth": false,
				"sDom": 'lfrtip'
	});
});
$('#filter').on("click", ":focus", function() {
	id = this.id;
	id_val = this.value;
	myarr = id.split ("_");
	var myvar = myarr[0] + "_" + myarr[1];
	$('#output_'+myarr[1]).val(id_val);
	hitung_stock(myarr[1]);
})

function check_filter(){
	var param_id = $('#param_id').val(2);
	document.getElementById('filter');
	$(document).each(function(){
			$(this).on('keyup',function(){
				var transaction_id = <?php echo $transaction_id ?>;
				var z = document.getElementById('filter').value;
				$.ajax({
					type:'POST',
					data:{x:transaction_id,z:z},
					url: 'transaction_new.php?page=menu_search',
					dataType:'json',
				}).done(function(data){
					$('#all_menu').empty();
					no = 1;
					for (var i = 0; i < data.length; i++) {
							$('#menu_list_body_tb').empty();
							$('#menu_list_body_tb').append('\
								<tr id="tr_1_'+i+'">\
									<td align="center"><strong>'+no+'</strong></td>\
									<td class="item-name"><strong>'+data[i].item_name+'</strong></td>\
									<td width="15%">\
										<input id="item_id_'+i+'" class="no-border" type="hidden" value="'+data[i].item_id+'"></input>\
										<input id="real_stock_qty_'+i+'" class="no-border" type="hidden" value="'+data[i].qty+'"></input>\
										<input id="stock_qty_'+i+'" style="width:100px;" class="no-border"\
										 type="text" value="'+data[i].qty+'" readonly></input>\
										<input id="stock_qty_konversi_'+i+'" class="" type="hidden" value=""></input>\
										<input type="hidden" id="harga_1_'+i+'" class="" value="'+data[i].item_price+'"/>\
									</td>\
									<td id="harga_v_'+i+'" align="center"><strong>'+toRp(data[i].item_price)+'\
									</strong></td>\
									<td><select id="select_unit_'+i+'" class="selectpicker show-tick form-control"\
									 onchange="konversi_qty_list('+i+')"\
									 data-live-search="true">\
									 <option value="0"></option>\
									 </select></td>\
									<td style="width:150px;">\
										<input type="number" style="width:150px;" class="form-control focus"  style="width:100px;"\
										id="focus_'+i+'" value="1"></input>\
										<input type="hidden" id="output_'+i+'" class="output"></input>\
									</td>\
									<td style="text-align:center;">\
										<a id="simpan_'+i+'" href="javascript:void(0)"\
										 class="btn btn-primary tombol_focus" onclick="simpan('+i+')">Simpan</a>\
									</td>\
								</tr>\
							');
								var item_id = data[i].item_id;
								open_select(item_id, i);
								get_harga(1,i);
								no++;
						}
			});
		});
	});
}

function open_select(id, elem) {
	$.ajax({
		type:'POST',
		data:{item_id:id},
		url: 'transaction_new.php?page=select_satuan',
		dataType:'json',
	}).done(function(data){
			for (var i = 0; i < data.length; i++) {
				$('#select_unit_'+elem).append('<option value="'+data[i].unit_id+'">'+data[i].unit_name+'</option>');
			}
		$('.selectpicker').selectpicker('refresh');
	});
}
// $('.selectpicker').selectpicker('refresh');
function get_harga(x,y){
	var harga = $('#harga_'+x+'_'+y).val();
	if (harga == 0) {
	 	$('#tr_'+x+'_'+y).addClass( "tr_pada_kondisi" );
		$('#stock_qty_'+y).css({ 'background': '#cef5b6' });
		$('#simpan_'+y).attr('disabled','disabled');
	}
}


	function open_select(id, elem) {
		$.ajax({
			type:'POST',
			data:{item_id:id},
			url: 'transaction_new.php?page=select_satuan',
			dataType:'json',
		}).done(function(data){
				for (var i = 0; i < data.length; i++) {
					$('#select_unit_'+elem).append('<option value="'+data[i].unit_id+'">'+data[i].unit_name+'</option>');
				}
			$('.selectpicker').selectpicker('refresh');
		});
	}

function simpan_form(){
	var i_member = $('#i_member_id').val();
	var transaction_id = $('#i_transaction_id').val();
	var action = 'transaction_new.php?page=save';
	if (i_member == 0) {
		alert("Isi Nama Pembeli : ");
	} else {
		$.ajax({
					type: "POST",
					dataType: "json",
					url: action,
					data: $("#form").serialize(), // serializes the form's elements.
					success: function(data)
					{
						if (data.status == 100) {
							alert("Harga Masih Kosong, pilih terlebih dahulu !!");
						} else {
							$('#large_modal').modal({
								backdrop: 'static',
								keyboard: false
							});
								var url = 'transaction_new.php?page=simpan_transaksi&id='+transaction_id;
									$('#large_modal_content').load(url,function(result){
								});
						}
					},
					error: function (data) {
						console.log(data);
					}
				});
	}
}

function submitForm(action){
	document.getElementById('form').action = action;
	document.getElementById('form').submit();
}
</script>
