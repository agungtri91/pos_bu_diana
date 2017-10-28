<script type="text/javascript" src="../js/search2/jcfilter.min.js"></script>
<script type="text/javascript">
	function filter_cat(){
		alert("test");
	}
</script>
<link rel="stylesheet" href="../css/purchase.css">
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
 <!--form action="<?= $action ?>" method="post" enctype="multipart/form-data" role="form"-->
	<form id="form" method="post" enctype="multipart/form-data" role="form">
	<!-- Main content -->
		<section class="content" style="padding-top: 0">
			<div class="row">
			<div class="row">
				<div class="col-md-4">
          <?php
        	$purchases_id = get_last_id("purchases","purchases_id");
        	if($id){
        		$id2 = $id;
        	}else {
        		if($purchases_id == true)
        			{
        					$id2 = $purchases_id+1;
        			}
        			else {
        				$id2 = 1;
        			} } ?>
            <input type="hidden" id="purchase_id" name="purchase_id" value="<?= $id2 ?>"/>
				</div>
			</div>
      <?php
        $q_all_jumlah = mysql_query("SELECT Sum(harga_total) FROM item_tmp WHERE purchases_id = '$id2'");
        $get_all_jumlah = mysql_fetch_array($q_all_jumlah);
       ?>
				<div class="col-md-12" id="table_menu">
					<div class="box box-cokelat">
						<div class="box-body">
							<div class="container">
							<!-- Top Navigation -->
								<section class="color-2">
									<div class="row">
										<div class="col-md-3">
											<div class="form-group">
												<?php
												if (isset($_SESSION['tanggal']) && $_SESSION['tanggal']==true) {
													$date = $_SESSION['tanggal'];
												}else {
													$date = $date;
												}
												 ?>
												<label>Tanggal : </label>
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</div>
														<input type="text" required class="form-control pull-right" id="date_picker1"
														name="i_date" value="<?= $date?>"/>
												</div><!-- /.input group -->
											</div>
										</div>
										<div class="col-md-3">
											<div class="form-group">
											<label>User :</label>
									             <?php
									            $user_data = get_user_data(); ?>
									            <div class="col-md-12">
									              <input type="text" class="form-control" value="<?=$user_data[0];?>" readonly>
									            </div>
								            </div>
										</div>
										<div class="col-md-3">
											<div id="i_member" class="form-group">
                        <div class="form-group">
          								<label>Supplier</label>
          								<select id="i_supplier" name="i_supplier" size="1" class="selectpicker show-tick form-control"
													data-live-search="true" onchange="ket_supplier()"/>
													<option value="0"></option>
          								<?php
													$no = 1;
													if (isset($_SESSION['i_supplier']) && $_SESSION['i_supplier']==true) {
														$type = $_SESSION['i_supplier'];
													} else {
														$type = '';
													}
													while($r_supplier = mysql_fetch_array($query_supplier)){ ?>
          									<option value="<?= $r_supplier['supplier_id'] ?>"
															<?php if($type == $r_supplier['supplier_id']){ ?> selected="selected"<?php } ?>>
															<?= $r_supplier['supplier_name']?>
														</option>
          								<?php $no++; } ?>
													<option type="button" id="tambah_supplier" class="btn btn-default" value="+">
														- - - Tambah Supplier - - -
													</option>
          								</select>
          							</div>
                      </div>
                    </div>
										<div class="col-md-3">
											<div id="i_member" class="form-group">
												<label>Cabang :</label>
												<select name="kategori" id="kategori" class="selectpicker show-tick form-control"
												data-live-search="true" value="0">
													<option value=""></option>
													<?php
													if ($_SESSION['branch_id_1']) {
														$type = $_SESSION['branch_id_1'];
													}
														else {
															$type = $_SESSION['branch_id'];
														}
													while($row_branch=mysql_fetch_array($query_branch)){
														?><option value="<?= $row_branch['branch_id']?>"
															<?php if($type == $row_branch['branch_id']){echo "Selected";} ?>>
															<?= $row_branch['branch_name']; ?>
														</option>
													<?php } ?>
												</select>
											</div>
										</div>
									</div><!-- row -->
										<div class="row">
										<br>
											<div class="col-md-3" style="padding-left:0px;">
												<div class="form-group">
													<div class="btn btn-block btn_cat_button" id="menu" onclick="list_menu()"> All Categories</div>
												</div>
											</div>
											<div class="row">
												<?php
												while($m_kategori = mysql_fetch_array($q_kategori)){?>
													<div class="col-md-3" style="padding-left:0px;">
														<div class="form-group">
															<div class="btn btn-block btn_cat_button" id="menu_type_id<?= $m_kategori['kategori_id']?>"
																onclick="sub_menu('<?= $m_kategori['kategori_id']?>')"><?= $m_kategori['kategori_name']?></div>
														</div>
													</div>
												<?php }?>
											</div>
										<!-- sub menu select -->
										<div>
											<div class="row menu-bar" style="display:none;">
												<div class="col-md-3 menu-bar-btn" id="btn_bar_1" onclick="get_change(1)" style="background-color: #d82827;">
													<div class="menu-bar-btn" id="btn_bar_icon_1">
														<i class="fa fa-list fa_1 ha" aria-hidden="true" style="font-size:20px;color: #fff;"></i>
													</div>
												</div>
												<div class="col-md-3 menu-bar-btn" id="btn_bar_2" onclick="get_change(2)">
													<div class="menu-bar-btn" id="btn_bar_icon_2">
														<i class="fa fa-th fa_2 ha" aria-hidden="true" style="font-size:20px;"></i>
													</div>
												</div>
											</div>
										</div>
										<input type="hidden" id="param_id" name="param_id" value="1">
										<div class="row">
											<div id="sub_menu_v"></div>
										</div>
										<div id="all_menu_list" style="display:;">
											<table id="menu_list_tb" class="table table-bordered">
												<thead id="menu_list_head_tb">
													<tr>
														<th style="width:5%;" align="center">No.</th>
														<th>Nama Item</th>
														<th>Satuan</th>
														<th>Order</th>
														<th>Harga</th>
														<th style="text-align:center;">Pilih</th>
													</tr>
												</thead>
												<tbody id="menu_list_body_tb">
												</tbody>
											</table>
										</div>
									</div>
							</div>
						</div><!-- /container -->
						<div style="height:100px; width:100%;"></div>
					</div>
				</div>
						</section>
			</div>
		</section><!-- /.content -->
		<section class="content_checkout" style="padding-right:10px;">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<input required type="hidden" readonly="readonly" name="i_total_harga"
						id="i_total_harga" class="form-control total_checkout" value="<?= $get_all_jumlah['Sum(harga_total)'] ?>"/>
						<input required type="text" readonly="readonly" name="i_total_harga_rupiah"
						id="i_total_harga_rupiah" class="form-control total_checkout" value="<?= format_rupiah($get_all_jumlah['Sum(harga_total)'])?>"/>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<input class="btn btn-danger button_checkout" type="button" onclick="simpan_form()" value="Simpan"/>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<input type="text" name="searchText" id="filter" onkeypress="check_filter()"
						class="form-control cari_checkout" value="" placeholder="Cari item..."/>
					</div>
				</div>
				<div class="col-md-2" style="float:right">
					<button type="button" class="btn btn-danger btn_cat_button" id="bullet-btn"
						name="new_stock" data-toggle="modal" data-target="#myModal">
						<i class="fa fa-plus" style="font-size:35px;color: #fff"></i>
					</button>
					<button type="button"  id="bullet-btn" 	name="new_stock" class="btn btn-danger btn_cat_button" onclick="table_widget()">
						<i class="fa fa-shopping-cart" aria-hidden="true" style="font-size:30px;color:#fff;" ></i>
					</button>
				</div>
			</div>
		</section>
</form>
 <!-- start popmodal -->
 <div id="item_purchase_popmodal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
 aria-labelledby="myLargeModalLabel" style="z-index:888888;">
  <div class="modal-dialog modal-lg" role="document"  style="width:900px;">
    <div class="modal-content" id="item_purchase_popmodal_content" style="border-radius:0px;">

    </div>
  </div>
</div>

<div id="tambah_purchase_popmodal" class="modal fade bs-example-modal-lg" tabindex="-1"
role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" id="tambah_purchase_popmodal_content" style="border-radius:0;">

    </div>
  </div>
</div>
<!-- end popmodal -->
<!-- Modal -->
<form id="form_add_stock" action="" enctype="multipart/form-data" method="post" novalidate>
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="z-index:888888;">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content" style="border-radius: 0;">
	      <div class="modal-header" style="border-radius:0px">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Tambah Master Item</h4>
	      </div>
	      <div class="modal-body">
					<div  class="form-group">
						<label>Nama Item</label>
						<input required type="text" name="nama_brg" id="nama_brg" class="form-control" placeholder="Masukkan harga..."/>
						</input>
					</div>
					<div  class="form-group">
						<label>Kode Item</label>
						<input required type="" name="kode_barang" id="kode_barang" class="form-control" placeholder="Masukkan kode Item..."/>
						</input>
					</div>
					<div class="form-group">
						<label>Merk Item</label>
						<input required type="" name="merk_barang" id="merk_barang" class="form-control" placeholder="Masukkan merk Item..."/>
						</input>
					</div>
					<div class="form-group">
						<label>Tipe Item</label>
						<input required type="" name="tipe_barang" id="tipe_barang" class="form-control" placeholder="Masukkan tipe Item..."/>
						</input>
					</div>
					<div  class="form-group">
						<label>Limit</label>
						<input required type="number" name="i_limit" id="i_limit" class="form-control" placeholder="Masukkan limit..."/>
						</input>
					</div>
					<div class="form-group">
						<div style="width:150px;width: 150px;left: 0px;top: 30px;">
							<label>Gambar</label>
						  <img id="output" style="max-width:120px;max-height:120px;">
							<input type="file" name="i_img" id="i_img" accept="image/*"  onchange="loadFile(event)"/>
						</div>
					</div>
	      </div>
	      <div class="modal-footer">
					<button type="button" class="btn btn-primary" onclick="check_nama()">
						Simpan
					</button>
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
	      </div>
	    </div>
	  </div>
	</div>
</form>
<!-- end popmodal -->
<script type="text/javascript">

$( "input[type='number']" ).change(function() {
  console.log('a');
});

    	$( document ).ready(function(){
		    $("#kategori").change(function(){
		        alert('this');
		    });
		});

var loadFile = function(event) {
	var reader = new FileReader();
	reader.onload = function(){
		var output = document.getElementById('output');
		$('#output_1').empty();
		output.src = reader.result;
	};
	reader.readAsDataURL(event.target.files[0]);
};

function table_widget(){
	var purchase_id = document.getElementById('purchase_id').value;
	$('#large_modal').modal();
	var url = 'purchase.php?page=widget_modal&id='+purchase_id;
		$('#large_modal_content').load(url,function(result){
	});
}

function check_nama() {
	var kode_item = $('#kode_barang').val();
	var url = 'purchase.php?page=simpan_order';
	$.ajax({
		type:'POST',
		data:{x:kode_item},
		url: 'purchase.php?page=strcmp',
		dataType:'json',
	}).done(function(data){
			if (data !== null) {
				var a = confirm(kode_item+" sudah ada, Simpan atau tidak ?");
				if(a==true){
					submitForm_add_stock(url);
				}
			}else {
					submitForm_add_stock(url);
				}
	});
}


function submitForm_add_stock(action){
	document.getElementById('form_add_stock').action = action;
	document.getElementById('form_add_stock').submit();
}

function submitForm(action){
	document.getElementById('form').action = action;
	document.getElementById('form').submit();
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

	 function get_change(view){
			var color = "#fff";
			var color_hover = "#676464";
			$(".menu-bar-btn").css("background-color", color);
			$(".ha").css("color", color_hover);
			$(".fa_"+view).css("color", color);
			var param_id = $('#param_id').val();
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

			function list_menu(){
				$("#menu").attr("onclick","list_menu()");
				$('#param_id').val(1);
				no = 1;
				$.ajax({
						url: 'purchase.php?page=menu',
						dataType:'json',
					}).done(function(data){
						$('#menu_list_body_tb').html('');
						for(var inn = 0; inn < data.data.length; inn++){
							$('#menu_list_body_tb').append('\
							<tr>\
								<td><strong>'+no+'</strong></td>\
								<td>\
									<input id="item_id_'+inn+'" class="no-border" type="hidden" value="'+data.data[inn].item_id+'"></input>\
									<strong>'+data.data[inn].item_name+'</strong>\
								</td>\
								<td>\
									<select id="select_unit_'+inn+'" class="selectpicker show-tick form-control" onchange="" data-live-search="true">\
										<option value="0"></option>\
									</select>\
								</td>\
								<td>\
									<input type="number" class="form-control focus"  id="focus_'+inn+'" value="1"></input>\
									<input type="hidden" id="output_'+inn+'" class="form-control output"></input>\
								</td>\
								<td>\
									<input type="text" class="form-control focus" onkeyup="nilai_currency_3(this);" id="focus_price_'+inn+'" value="0"></input>\
								</td>\
								<td style="text-align:center;">\
									<a id="simpan_'+inn+'" href="javascript:void(0)" class="btn btn-primary tombol_focus" onclick="simpan('+inn+')">Simpan</a>\
								</td>\
							</tr>\
							');
							var item_id = data.data[inn].item_id;
							var select = inn;
							open_select(item_id, select);
							$('.selectpicker').selectpicker('refresh');
							no++;
						}
					});
				}
	function open_select(item_id, no){
		$.ajax({
					type:'POST',
					data:{item_id:item_id},
					url: 'purchase.php?page=select_satuan',
					dataType:'json',
				}).done(function(data){
					for (var i = 0; i < data.length; i++) {
						$('#select_unit_'+no).append('<option value="'+data[i].unit_id+'">'+data[i].unit_name+'</option>');
						$('.selectpicker').selectpicker('refresh');
					}
				});
	}
	// list_menu();

	function dialogModal(x){
				var a = document.getElementById('i_supplier').value;
				var b = document.getElementById('i_branch_id').value;
        var c = document.getElementById('purchase_id').value;
				var d = document.getElementById('date_picker1').value;
				$('#item_purchase_popmodal').modal();
				var url = 'purchase.php?page=popmodal&item_id='+x+'&supplier_id='+a+'&branch_id='+b+'&purchase_id='+c+'&tanggal='+d;
		      $('#item_purchase_popmodal_content').load(url,function(result){
		    });
			}



		function menu(){
			$.ajax({
					url: 'purchase.php?page=menu',
					dataType:'json',
				}).done(function(data){
					$('#sub_menu_v').empty();
					$('#all_menu').html("");
					for(var inn = 0; inn<data.data.length; inn++){
						$('#all_menu').append('\
							<div class="col-md-3">\
								<div class="panel panel-default jcorgFilterTextParent">\
									<a id="dialogModal_ex_'+inn+'" onclick="dialogModal('+data.data[inn].item_id+')">\
									<input type="hidden" value="1"/>\
										<div class="panel-heading" style="text-align:center;color:#d82827;">\
											<div class="panel-title">'+data.data[inn].item_name+'</div>\
										</div>\
										<div class="panel-body">\
											<center>\
												<div class="form-group" style="max-width:150px;max-height:150px;">\
													<img id="output_1" class="img-responsive" src="../img/menu/'+data.data[inn].stock_img+'" style="height:140px;">\
												</div>\
											</center>\
											<div class="jcorgFilterTextChild">'+data.data[inn].item_name+'</div>\
										</div>\
									</a>\
								</div>\
							</div>\
							');
					}
				});
		}
		function sub_menu(x){
			var param_id = $('#param_id').val();
			$.ajax({
				type:'POST',
				url:'purchase.php?page=sub_menu',
				data:{x:x},
				dataType:'json',
			}).done(function(data){
				$('#sub_menu_v').empty();
				for(var inn = 0; inn< data.length; inn++){
						$('#sub_menu_v').append(
							'<div class="col-md-3" style="padding-left:0px;">\
								<div class="form-group">\
								<div class="btn btn-block btn_cat_button" onclick="menu_sub('+data[inn].sub_kategori_id+')">\
								'+data[inn].sub_kategori_name+'</div>\
								</div>\
							</div>');
						}
				});
				$('#menu_list_body_tb').html('');
				$('#all_menu').html("");
				$.ajax({
					type:'POST',
					url:'purchase.php?page=menu_sub_2',
					data:{x:x},
					dataType:'json',
				}).done(function(data){
					no = 1;
						for(var inn = 0; inn < data.length; inn++){
							$('#menu_list_body_tb').append('\
							<tr>\
								<td><strong>'+no+'</strong></td>\
								<td>\
									<input id="item_id_'+inn+'" class="no-border" type="hidden" value="'+data[inn].item_id+'"></input>\
									<strong>'+data[inn].item_name+'</strong>\
								</td>\
								<td>\
									<select id="select_unit_'+inn+'" class="selectpicker show-tick form-control" onchange="" data-live-search="true">\
										<option value="0"></option>\
									</select>\
								</td>\
								<td>\
									<input type="number" class="form-control focus"  id="focus_'+inn+'" value="1"></input>\
									<input type="hidden" id="output_'+inn+'" class="form-control output"></input>\
								</td>\
								<td>\
									<input type="number" class="form-control focus"  id="focus_price_'+inn+'" value="0"></input>\
								</td>\
								<td style="text-align:center;">\
									<a id="simpan_'+inn+'" href="javascript:void(0)" class="btn btn-primary tombol_focus" onclick="simpan('+inn+')">Simpan</a>\
								</td>\
							</tr>\
							');
							var item_id = data[inn].item_id;
							var select = inn;
							open_select(item_id, select);
							$('.selectpicker').selectpicker('refresh');
							no++;
						}
				});
			}
		function cust_detail(){
			var x = document.getElementById('cust_detail');
			x.style.display = 'block';
		}


	function menu_sub(x){
	$('#all_menu').html("");
	$('#menu_list_body_tb').html('');
	$.ajax({
		type:'POST',
		url:'purchase.php?page=menu_sub',
		data:{x:x},
		dataType:'json',
	}).done(function(data){
		no = 1;
			for(var inn = 0; inn < data.length; inn++){
				$('#menu_list_body_tb').append('\
				<tr>\
					<td><strong>'+no+'</strong></td>\
					<td>\
						<input id="item_id_'+inn+'" class="no-border" type="hidden" value="'+data[inn].item_id+'"></input>\
						<strong>'+data[inn].item_name+'</strong>\
					</td>\
					<td>\
						<select id="select_unit_'+inn+'" class="selectpicker show-tick form-control" onchange="" data-live-search="true">\
							<option value="0"></option>\
						</select>\
					</td>\
					<td>\
						<input type="number" class="form-control focus"  id="focus_'+inn+'" value="1"></input>\
						<input type="hidden" id="output_'+inn+'" class="form-control output"></input>\
					</td>\
					<td>\
						<input type="number" class="form-control focus"  id="focus_price_'+inn+'" value="0"></input>\
					</td>\
					<td style="text-align:center;">\
						<a id="simpan_'+inn+'" href="javascript:void(0)" class="btn btn-primary tombol_focus" onclick="simpan('+inn+')">Simpan</a>\
					</td>\
				</tr>\
				');
				var item_id = data[inn].item_id;
				var select = inn;
				open_select(item_id, select);
				$('.selectpicker').selectpicker('refresh');
				no++;
			}
	});
}

function check_filter(){
	document.getElementById('filter');
	$(document).each(function(){
			$(this).keyup(function(){
				var z = document.getElementById('filter').value;
				$.ajax({
					type:'POST',
					data:{z:z},
					url: 'purchase.php?page=menu_search',
					dataType:'json',
				}).done(function(data){
					$('#menu_list_body_tb').html('');
					no = 1;
						for(var inn = 0; inn < data.length; inn++){
							$('#menu_list_body_tb').append('\
							<tr>\
								<td><strong>'+no+'</strong></td>\
								<td>\
									<input id="item_id_'+inn+'" class="no-border" type="hidden" value="'+data[inn].item_id+'"></input>\
									<strong>'+data[inn].item_name+'</strong>\
								</td>\
								<td>\
									<select id="select_unit_'+inn+'" class="selectpicker show-tick form-control" onchange="" data-live-search="true">\
										<option value="0"></option>\
									</select>\
								</td>\
								<td>\
									<input type="number" class="form-control focus"  id="focus_'+inn+'" value="1"></input>\
									<input type="hidden" id="output_'+inn+'" class="form-control output"></input>\
								</td>\
								<td>\
									<input type="number" class="form-control focus"  id="focus_price_'+inn+'" value="0"></input>\
								</td>\
								<td style="text-align:center;">\
									<a id="simpan_'+inn+'" href="javascript:void(0)" class="btn btn-primary tombol_focus" onclick="simpan('+inn+')">Simpan</a>\
								</td>\
							</tr>\
							');
							var item_id = data[inn].item_id;
							var select = inn;
							open_select(item_id, select);
							$('.selectpicker').selectpicker('refresh');
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

	function add_stock(url){
		window.location.href = url;
	}
	function unit_id(x){
			var i_unit = $('#select_unit_'+x).val();
			alert(i_unit);
	}

	function simpan(x){
		var url = "purchase.php?page=create_note";
		var purchase_id = <?php echo $id2 ?>;
		var i_qty = $('#focus_'+x).val();
		var item_id = $('#item_id_'+x).val();
		var i_unit = $('#select_unit_'+x).val();
		var i_harga = $('#focus_price_'+x).val();
		var i_supplier = $('#i_supplier').val();
		var i_branch_id = $('#i_branch_id').val();
			if (i_harga != 0) {
				$.post(url,
				 {
					purchase_id : purchase_id,
					i_qty : i_qty,
					item_id : item_id,
					i_unit : i_unit,
					i_harga : i_harga,
					i_supplier : i_supplier,
					i_branch_id : i_branch_id
				});
				window.location.href ='purchase.php?page=form&id='+purchase_id+'';
			}else {
			alert("Isi kolom order dan harga terlebih dahulu");
			}
		}

	function simpan_form(){
		var i_supplier = $('#i_supplier').val();
		var action = '<?php echo $action ?>';
		var purchase_id = <?php echo $id2 ?>;

		if (i_supplier == 0) {
			alert("Isi Nama Supplier : ");
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
									var url = 'purchase.php?page=simpan_transaksi&id='+purchase_id;
										$('#large_modal_content').load(url,function(result){
									});
							}
						},
						error: function (data) {
							alert('simpan gagal');
						}
					});
		}
	}

	function ket_supplier(){
		var x = $('#i_supplier').val();
		if (x == '+') {
			tambah_supplier();
		}
	}

	function tambah_supplier(){
		var a = document.getElementById('date_picker1').value;
		var c = document.getElementById('purchase_id').value;
		var d = document.getElementById('i_branch_id').value;
		$('#tambah_purchase_popmodal').modal();
		var url = 'purchase.php?page=tambah_supplier_popmodal&purchase_id='+c+'&branch_id='+d+'&tanggal='+a;
			$('#tambah_purchase_popmodal_content').load(url,function(result){
		});
	}

	function submitForm(action){
		document.getElementById('form').action = action;
		document.getElementById('form').submit();
	}

</script>
