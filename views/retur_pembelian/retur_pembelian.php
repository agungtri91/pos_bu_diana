
  <!-- Main content -->
  <section class="content" style="padding-bottom: 100px;">
		<?php
		// $hannan_session = (isset($hannan_session)) ? $_SESSION['purchases_id'] : '';
	  //   if (!empty($hannan_session)) {
		if (isset($_SESSION['purchase_id']) && $_SESSION['purchase_id']==true) {
	    $purchases_id= $_SESSION['purchase_id'];
	  }else {
	    $purchases_id= 0;
	  }
	    $get_all_jumlah = get_all_jumlah($purchases_id);
	    $get_all_item	= get_all_item($purchases_id);
	  ?>
		<input type="hidden" name="name" value="<?= $purchases_id?>">
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
            <div class="title_page"> <?= $title ?></div>
              <div class="box">
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <br>
                      <label>Id Pembelian :</label>
                      <select name="i_purchase_id" id="i_purchase_id" class="selectpicker show-tick form-control"
											data-live-search="true" onchange="ket_purchase()" value="">
                        <option value="0"></option>
                        <?php
                        	while($r_pur=mysql_fetch_array($query)) {
	                          if(count($r_pur)>0){
															$type= $r_pur['purchases_id'];}
														if ($_SESSION['purchase_id']) {
															$type = $_SESSION['purchase_id'];}?>
	                          <option value="<?= $r_pur['purchases_id']?>"<?php if($type == $r_pur['purchases_id']){echo "Selected";}?>>
															<?= $r_pur['purchases_code']?>
														</option>
                        <? } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="">
                  <div class="row" id="purchase_detail_1" style="display:none;"></div>
                </div>
                  <div class="box-body2 table-responsive" id="tb_trans">
                      <table class="table table-bordered table-striped" id="retur_item_tb">
                          <thead>
                              <tr>
                              	  <th width="5%">No</th>
                                  <th>Nama Item</th>
                                  <th>Qty</th>
                                  <th>Harga beli Item</th>
                                  <th>Total</th>
                                  <th>Config</th>
                              </tr>
                          </thead>
                          <tbody id="purch_detail"></tbody>
                          <tfoot id="purch_detail_foot"></tfoot>
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
										class="form-control total_checkout" value="<?= format_rupiah($get_all_jumlah) ?>"/>
                  </div>
                </div>
                <div class="col-xs-4">
									<?php if (strpos($permit, 'c') !== false || strpos($permit, 'u') !== false): ?>
	                  <div class="form-group">
	                    <input class="btn btn-danger button_checkout" type="submit" value="Simpan"
											onclick="save_retur('<?= $purchases_id?>')"/>
	                  </div>
									<?php endif; ?>
                </div>
              </div>
							<div class="col-md-6" style="text-align:right;">
								<button type="button"  id="bullet-btn" 	name="new_stock" class="btn btn-danger btn_cat_button" onclick="table_widget()">
									<i class="fa fa-shopping-cart" aria-hidden="true" style="font-size:30px;color:#fff;"></i>
								</button>
							</div>
            </div>
          </section>
      </div>
  </section><!-- /.content -->
	<div id="retur_item_popmodal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
	aria-labelledby="myLargeModalLabel" style="z-index:888888;">
	 <div class="modal-dialog modal-lg" role="document"  style="width:900px;">
		 <div class="modal-content" id="retur_item_popmodal_content" style="border-radius:0px;">

		 </div>
	 </div>
	</div>

  <script type="text/javascript">
	function table_widget(){
		var y = document.getElementById('i_purchase_id').value;
		$('#medium_modal').modal();
		var url = 'retur_pembelian.php?page=retur_widget_popmodal&id='+y;
			$('#medium_modal_content').load(url,function(result){
		});
	}
		$(function() {
			$("#table_widget").draggable();
		});

    var x = document.getElementById('i_purchase_id').value;
    var y = document.getElementById('purchase_detail_1');
		var nama = "";
		var alamat = "";
		var telepon ="";
		var email = "";
		var lunas = "";
    if (x!=0) {
      // alert(x);
      y.style.display='block';
      $.ajax({
        type:'POST',
        data:{x:x},
        url:'retur_pembelian.php?page=search',
        dataType:'json',
      }).done(function(data){
				if (data[0].supplier_id !== null) {
						nama = data[0].supplier_name;
						alamat = data[0].supplier_addres;
						telepon = data[0].supplier_phone;
						email = data[0].supplier_email;
						lunas = data[0].lunas;
					}
        $('#purch_detail').html("");
        $('#purchase_detail_1').html("");
        $('#tb_trans').html("");
        $('#purch_code').html("");
				$('#purchase_detail_1').append('\
				<div class="">\
					<div class="row">\
						<div class="col-md-3">\
							<div class="form-group" style="margin:0;">\
								<label>Nama Supplier</label>\
							</div>\
						</div>\
						<div class="col-md-2">\
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
						<div class="col-md-2">\
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
						<div class="col-md-2">\
							<div class="form-group">\
								<label>: '+telepon+'</label>\
							</div>\
						</div>\
					</div>\
        </div>');
        $('#tb_trans').append('<br><div id="purch_code" class="text-center" style="font-size:20px;">\
				</div><table class="table table-bordered table-striped" id="retur_item_tb">\
        <thead>\
            <tr>\
                <th width="5%">No</th>\
                <th>Nama Item</th>\
                <th>Qty</th>\
                <th>Harga beli Item</th>\
                <th>Total</th>\
                <th style="text-align:center;">Config</th>\
            </tr>\
        </thead>\
        <tbody id="purch_detail"></tbody>\
        </table>\
      ');
      var no=1;
      for (var i = 0; i < data.length; i++) {
          $('#purch_detail').append('<tr>\
            <td class="text-center">'+no+'</td>\
            <td>'+data[i].item_name+'</td>\
            <td>'+data[i].purchase_qty+'('+data[i].unit_name+')</td>\
            <td>'+data[i].purchase_price+'</td>\
            <td>'+data[i].purchase_total+'\
							<input type="hidden" id="purchase_detail_id_'+i+'" value="'+data[i].purchase_detail_id+'"/>\
						</td>\
            <td style="text-align:center; font-size:20px;">\
							<a type="button" href="javascript:void(0);" class="btn btn-default" onclick="returmodal('+data[i].purchase_detail_id+')">\
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

    function ket_purchase(){
			// session_destroy($_SESSION['transaction_id']);
      var x = document.getElementById('i_purchase_id').value;
      // y.style.display='block';
			// alert(x);
			var nama = "";
			var alamat = "";
			var telepon ="";
			var email = "";
			var lunas = "";
      $.ajax({
        type:'POST',
				data:{x:x},
				url:'retur_pembelian.php?page=search',
				dataType:'json',
			}).done(function(data){
				if (data[0].supplier_id !== null) {
						nama = data[0].supplier_name;
						alamat = data[0].supplier_addres;
						telepon = data[0].supplier_phone;
						email = data[0].supplier_email;
						lunas = data[0].lunas;
				}
        $('#purch_detail').html("");
        $('#purchase_detail_1').html("");
        $('#tb_trans').html("");
        $('#purch_code').html("");
				$('#purchase_detail_1').append('\
				<div class="">\
					<div class="row">\
						<div class="col-md-3">\
							<div class="form-group" style="margin:0;">\
								<label>Nama Supplier</label>\
							</div>\
						</div>\
						<div class="col-md-2">\
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
						<div class="col-md-2">\
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
						<div class="col-md-2">\
							<div class="form-group">\
								<label>: '+telepon+'</label>\
							</div>\
						</div>\
					</div>\
        </div>');
        $('#tb_trans').append('<br><div id="purch_code" class="text-center" style="font-size:20px;"></div>\
				<table class="table table-bordered table-striped" id="retur_item_tb">\
        <thead>\
            <tr>\
                <th width="5%">No</th>\
                <th>Nama Item</th>\
                <th>Qty</th>\
                <th>Harga beli Item</th>\
                <th>Total</th>\
                <th style="text-align:center;">Config</th>\
            </tr>\
        </thead>\
        <tbody id="purch_detail"></tbody>\
        </table>\
      ');
      var no=1;
      for (var i = 0; i < data.length; i++) {
          $('#purch_detail').append('<tr>\
            <td class="text-center">'+no+'</td>\
            <td>'+data[i].item_name+'</td>\
            <td>'+data[i].purchase_qty+'('+data[i].unit_name+')</td>\
            <td>'+data[i].purchase_price+'</td>\
            <td>'+data[i].purchase_total+'\
						<input type="hidden" id="purchase_detail_id_'+i+'" value="'+data[i].purchase_detail_id+'"/>\
						</td>\
            <td style="text-align:center; font-size:20px;">\
							<a type="button" href="javascript:void(0);" class="btn btn-default" onclick="returmodal('+data[i].purchase_detail_id+')">\
								<i class="fa fa-arrow-left"></i>\
							</a>\
						</td>\
          </tr>\
          ');
          no++;
        }
        // $('#purch_detail_foot').append('<tr><td>Total Transaksi'+data.data.total_all+'</td></tr>');
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
        });
      });
    });
  }

  function returmodal(purchase_detail_id){
    var y=document.getElementById('i_purchase_id').value;
		$('#retur_item_popmodal').modal();
		var url = 'retur_pembelian.php?page=retur_item_popmodal&id='+purchase_detail_id+'&purchase_id='+y;
			$('#retur_item_popmodal_content').load(url,function(result){
		});
  }

  function confirm_delete_retur(x){
		var a = confirm("Anda yakin ingin menghapus order ini ?");

		if(a==true){
			window.location.href = 'retur_pembelian.php?page=delete_widget&id='+x;
		}
	}

  function save_retur(x){
		var y = document.getElementById('i_total_harga_rupiah').value;
    window.location.href = 'retur_pembelian.php?page=save_retur&purchase_id='+x+'&retur_price='+y;
  }

  </script>
