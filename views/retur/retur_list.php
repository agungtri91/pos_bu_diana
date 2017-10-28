<section class="content" style="padding-bottom: 100px;">
		<?php
		if (isset($_SESSION['transaction_id']) && $_SESSION['transaction_id']==true) {
	    $transaction_id= $_SESSION['transaction_id'];
	  }else {
	    $transaction_id= 0;
	  }
	    $get_all_jumlah = get_all_jumlah($transaction_id);
	    $get_all_item	= get_all_item($transaction_id);
	  ?>
		<input type="hidden" name="name" value="<?= $transaction_id?>">
      <div class="row">
					<div class="col-md-6">
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
					<div class="col-md-6">
						<div class="form-group">
						<label>User :</label>
				             <?php
				            $user_data = get_user_data(); ?>
				            <div class="col-md-12">
				              <input type="text" class="form-control" value="<?=$user_data[0];?>" readonly>
				            </div>
			            </div>
					</div>	
        <div class="col-md-12">
              <div class="box">

                <div class="row">
									<br>
									<div class="title_page"> <?= $title ?></div>
		
                  <div class="col-md-3">
                    <div class="form-group">
                      <br>
                      <label>Id Transaksi :</label>
                      <select name="i_transaction_id" id="i_transaction_id" class="selectpicker show-tick form-control"
											data-live-search="true" onchange="ket_trans()" value="">
                        <option value="0"></option>
                        <?php
                        while($r_trans=mysql_fetch_array($query)) {
                          if(count($r_trans)>0){
														$type= $r_trans['transaction_id'];}
													if ($_SESSION['transaction_id']) {
														$type = $_SESSION['transaction_id'];}?>
                          <option value="<?= $r_trans['transaction_id']?>"
														<?php if($type == $r_trans['transaction_id']){echo "Selected";}?>><?= $r_trans['transaction_code']?>
													</option>
                        <? } ?>
                      </select>
                    </div>
                  </div>
                </div>

									<div class="form-group">
										<div class="row" id="transaction_detail_1" style="display:none;"></div>
									</div>
                  <div class="box-body2 table-responsive" id="tb_trans">
                      <table class="table table-bordered table-striped" id="retur_item_tb">
                          <thead>
                              <tr>
                              	  <th width="5%">No</th>
                                  <th>Nama Item</th>
                                  <th>Qty</th>
                                  <th>Harga Beli Item</th>
                                  <th>Diskon</th>
                                  <th>Total</th>
																	<th>Harga Akhir Item</th>
                                  <th>Config</th>
                              </tr>
                          </thead>
                          <tbody id="trans_detail"></tbody>
                          <tfoot id="trans_detail_foot"></tfoot>
                      </table>
                  </div><!-- /.box-body -->
                  <div style="clear:both"></div>
              </div><!-- /.box -->
          </div>
          <section class="content_checkout" style="left: 0px;">
            <div class="row">
              <div class="col-md-6" style="left: 236px;">
                <div class="col-xs-8">
                  <div class="form-group">
                    <input required type="hidden" readonly="readonly" name="i_total_harga" id="i_total_harga"
										class="form-control total_checkout" value="<?= $get_all_jumlah ?>"/>
                    <input required type="text" readonly="readonly" name="i_total_harga_rupiah" id="i_total_harga_rupiah"
										class="form-control total_checkout" value="<?= format_rupiah($get_all_jumlah)?>"/>
                  </div>
                </div>
                <div class="col-xs-4">
									<?php if (strpos($permit, 'c') !== false || strpos($permit, 'u') !== false): ?>
	                  <div class="form-group">
	                    <input class="btn btn-danger button_checkout" type="button"
											value="Simpan" onclick="save_retur('<?= $transaction_id?>')"/>
	                  </div>
									<?php endif; ?>
                </div>
              </div>
							<div class="col-md-6" style="text-align:right;left: 236px;">
								<button type="button"  id="bullet-btn" 	name="new_stock" class="btn btn-danger btn_cat_button" onclick="table_widget()">
									<i class="fa fa-shopping-cart" aria-hidden="true" style="font-size:30px;color:#fff;"></i>
								</button>
							</div>
            </div>
          </section>
      </div>
  </section>
	<div id="retur_item_popmodal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" style="z-index:888888;">
	 <div class="modal-dialog modal-lg" role="document"  style="width:900px;">
		 <div class="modal-content" id="retur_item_popmodal_content" style="border-radius:0px;">

		 </div>
	 </div>
	</div>
  <script type="text/javascript">

		function table_widget(){
			var y = document.getElementById('i_transaction_id').value;
			$('#medium_modal').modal();
			var url = 'retur.php?page=retur_widget_popmodal&id='+y;
				$('#medium_modal_content').load(url,function(result){
			});
		}


		function returmodal(i,z){
	    var y=document.getElementById('i_transaction_id').value;
			$('#retur_item_popmodal').modal();
			var url = 'retur.php?page=retur_item_popmodal&id='+i+'&item_id='+z+'&transaction_id='+y;
				$('#retur_item_popmodal_content').load(url,function(result){
			});
	  }

		$(function() {
			$("#table_widget").draggable();
		});

    var x = document.getElementById('i_transaction_id').value;
    var y = document.getElementById('transaction_detail_1');
		var unit = "";
		var nama = "";
		var alamat = "";
		var telepon ="";
		var email = "";
		var lunas = "";
		var diskon ="";
    if (x!=0) {
      y.style.display='block';
      $.ajax({
        type:'POST',
        data:{x:x},
        url:'retur.php?page=search',
        dataType:'json',
      }).done(function(data){
					if (data[0].member_id !== null) {
						nama = data[0].member_name;
						alamat = data[0].member_alamat;
						telepon = data[0].member_phone;
						diskon = data[0].member_discount;
						email = data[0].member_email;
						lunas = data[0].lunas;
					}
        $('#trans_detail').html("");
        $('#transaction_detail_1').html("");
        $('#tb_trans').html("");
        $('#trans_code').html("");
        $('#transaction_detail_1').append('\
				<div class="">\
					<div class="row">\
						<div class="col-md-3">\
							<div class="form-group" style="margin:0;">\
								<label>Nama Pembeli</label>\
							</div>\
						</div>\
						<div class="col-md-9">\
							<div class="form-group">\
								<label>: '+nama+'</label>\
							</div>\
						</div>\
					</div>\
					<div class="row">\
						<div class="col-md-3">\
							<div class="form-group" style="margin:0;">\
								<label>Alamat</label>\
							</div>\
						</div>\
						<div class="col-md-9">\
							<div class="form-group">\
								<label>: '+alamat+'</label>\
							</div>\
						</div>\
					</div>\
					<div class="row">\
						<div class="col-md-3">\
							<div class="form-group" style="margin:0;">\
								<label>Tlp.</label>\
							</div>\
						</div>\
						<div class="col-md-9">\
							<div class="form-group">\
								<label>: '+telepon+'</label>\
							</div>\
						</div>\
					</div>\
        </div>');
        $('#tb_trans').append('<br><div id="trans_code" class="text-center" style="font-size:20px;">\
				</div><table class="table table-bordered table-striped" id="retur_item_tb">\
        <thead>\
            <tr>\
                <th width="5%">No</th>\
                <th>Nama Item</th>\
                <th>Qty</th>\
								<th>Qty Retur</th>\
                <th>Harga Beli Item</th>\
                <th>Disk. Persen</th>\
								<th>Disk. Nominal</th>\
								<th>Harga Akhir Item</th>\
                <th>Total</th>\
                <th style="text-align:center;">Config</th>\
            </tr>\
        </thead>\
        <tbody id="trans_detail"></tbody>\
        </table>\
      ');
      var no=1;
			unit_utama_name = '';
      for (var i = 0; i < data.length; i++) {
				if (data[i].unit_name !== null) {
					unit = '('+data[i].unit_name+')';
					unit_utama_name = "("+data[i].unit_utama_name+")";
				}
          $('#trans_detail').append('<tr>\
            <td class="text-center">'+no+'</td>\
            <td>'+data[i].item_name+'</td>\
            <td>'+data[i].transaction_detail_qty+'</td>\
						<td>'+data[i].transaction_detail_qty_setelah_retur+' '+unit_utama_name+'</td>\
            <td>'+data[i].transaction_detail_price+'</td>\
            <td>'+data[i].transaction_detail_persen_discount+'</td>\
						<td>'+data[i].transaction_detail_nominal_discount+'</td>\
						<td>'+data[i].transaction_detail_grand_price+'</td>\
            <td>'+data[i].transaction_detail_total+'</td>\
            <td id="i_config" align="center">\
							<a type="button" href="javascript:void(0);" class="btn btn-default"\
							 onclick="returmodal('+data[i].transaction_detail_id+','+data[i].item_id+')">\
								<i class="fa fa-arrow-left"></i>\
							</a>\
						</td>\
          </tr>\
          ');
          no++;
				}
        setTimeout(function(){$('#retur_item_tb').DataTable({
          dom: 'Bfrtip',
          buttons: [

              {
                  extend: 'pageLength'
              }
              ,
              {
                  extend: 'copy'
              },
              {
                  extend: 'excel'
              },
              {
                  extend: 'pdf'
              }
            ],
            lengthMenu: [
                [ 10, 25, 50, -1 ],
                [ '10 rows', '25 rows', '50 rows', 'Show all' ]
            ]
        })
      });
    });
    }

    function ket_trans(){
			var unit = "";
      var x = document.getElementById('i_transaction_id').value;
      y.style.display='block';
      $.ajax({
        type:'POST',
				data:{x:x},
				url:'retur.php?page=search',
				dataType:'json',
			}).done(function(data){
					if (data[0].member_id !== null) {
						nama =data[0].member_name;
						alamat = data[0].member_alamat;
						telepon = data[0].member_phone;
						diskon = data[0].member_discount;
						email = data[0].member_email;
						lunas = data[0].lunas;
					}
        $('#trans_detail').html("");
        $('#transaction_detail_1').html("");
        $('#tb_trans').html("");
        $('#trans_code').html("");
        $('#transaction_detail_1').append('\
				<div class="">\
					<div class="row">\
						<div class="col-md-3">\
							<div class="form-group" style="margin:0;">\
								<label>Nama Pembeli</label>\
							</div>\
						</div>\
						<div class="col-md-9">\
							<div class="form-group">\
								<label>: '+nama+'</label>\
							</div>\
						</div>\
					</div>\
					<div class="row">\
						<div class="col-md-3">\
							<div class="form-group" style="margin:0;">\
								<label>Alamat</label>\
							</div>\
						</div>\
						<div class="col-md-9">\
							<div class="form-group">\
								<label>: '+alamat+'</label>\
							</div>\
						</div>\
					</div>\
					<div class="row">\
						<div class="col-md-3">\
							<div class="form-group" style="margin:0;">\
								<label>Tlp.</label>\
							</div>\
						</div>\
						<div class="col-md-9">\
							<div class="form-group">\
								<label>: '+telepon+'</label>\
							</div>\
						</div>\
					</div>\
        </div>');
        $('#tb_trans').append('<br><div id="trans_code" class="text-center" style="font-size:20px;">\
				</div><table class="table table-bordered table-striped" id="retur_item_tb">\
        <thead>\
					<tr>\
						<th width="5%">No</th>\
						<th>Nama Item</th>\
						<th>Qty</th>\
						<th>Qty Retur</th>\
						<th>Harga Beli Item</th>\
						<th>Disk. Persen</th>\
						<th>Disk. Nominal</th>\
						<th>Harga Akhir Item</th>\
						<th>Total</th>\
						<th style="text-align:center;">Config</th>\
					</tr>\
        </thead>\
        <tbody id="trans_detail"></tbody>\
        </table>\
      ');
      var no=1;
      for (var i = 0; i < data.length; i++) {
				if (data[i].unit_name !== null) {
					unit = '('+data[i].unit_name+')';
					unit_utama_name = "("+data[i].unit_utama_name+")";
				}
          $('#trans_detail').append('<tr>\
            <td class="text-center">'+no+'</td>\
            <td>'+data[i].item_name+'</td>\
            <td>'+data[i].transaction_detail_qty+' '+unit+'</td>\
						<td>'+data[i].transaction_detail_qty_setelah_retur+' '+unit_utama_name+'</td>\
            <td>'+data[i].transaction_detail_price+'</td>\
            <td>'+data[i].transaction_detail_persen_discount+'</td>\
						<td>'+data[i].transaction_detail_nominal_discount+'</td>\
						<td>'+data[i].transaction_detail_grand_price+'</td>\
            <td>'+data[i].transaction_detail_total+'</td>\
						<td id="i_config" align="center">\
							<a type="button" href="javascript:void(0);" class="btn btn-default"\
							 onclick="returmodal('+data[i].transaction_detail_id+','+data[i].item_id+')">\
								<i class="fa fa-arrow-left"></i>\
							</a>\
						</td>\
          </tr>\
          ');
          no++;
					}
        // $('#trans_detail_foot').append('<tr><td>Total Transaksi'+data.data.total_all+'</td></tr>');
        setTimeout(function(){$('#retur_item_tb').DataTable({
          dom: 'Bfrtip',
          buttons: [

              {
                  extend: 'pageLength'
              },
              {
                  extend: 'copy'
              },
              {
                  extend: 'excel'
              },
              {
                  extend: 'pdf'
              }
            ],
            lengthMenu: [
                [ 10, 25, 50, -1 ],
                [ '10 rows', '25 rows', '50 rows', 'Show all' ]
            ]
        })
      });
    });
  }

  function confirm_delete_retur(x){
    // alert(x);
		var a = confirm("Anda yakin ingin menghapus order ini ?");

		if(a==true){
			window.location.href = 'retur.php?page=delete_widget&id='+x;
		}
	}

  function save_retur(x){
    var y = document.getElementById('i_total_harga_rupiah').value;
    window.location.href = 'retur.php?page=save_retur&transaction_id='+x+'&retur_price='+y;
    session_destroy();
    session_unset();
  }
  </script>
