<!-- ANGSURAN HUTANG -->
<style>
	#payment_type2{
		height:auto;
	}
	#payment_type2 label span{
		text-align:center;
    padding:13px 13px;
    display:block;
    cursor: pointer;
    color: #000;
	}
  #bank_frame{
    display: table;
    width: 100%;
    border-bottom-width: 41px;
    padding-bottom: 19px;
    padding-left: 101px;
    text-align: left;
  }
  #bank_frame_transfer{
    display: table;
    width: 100%;
    border-bottom-width: 41px;
    padding-bottom: 19px;
    padding-left: 101px;
    text-align: left;
  }
	#supplier{
		padding: 15px 0 15px 0;
		text-align: center;
		font-size: 20px;
	}
</style>
<section class="content">
  <div class="row">
  <!-- right column -->
    <div id="utama" class="col-md-12">
    <!-- general form elements disabled -->
      <div class="title_page"><label><?= $title ?></label></div>
        <div class="box">
          <div class="box-body2 table-responsive">
            <table id="example1" style="width:100%;" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style="width:5%;text-align:center;">NO. </th>
                  <th style="text-align:center;">Supplier </th>
                  <th style="text-align:center;">Total Hutang </th>
                  <th style="text-align:center;">Alamat </th>
                  <th style="text-align:center;">Config </th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                while($r_hutang=mysql_fetch_array($query)){ ?>
                  <tr>
                    <td style="width:5%;text-align:center;"><label><?= $no?></label></td>
                    <td><label><?= $r_hutang['supplier_name']?></label></td>
                    <td style="text-align:center"><label>Rp. <?= $r_hutang['total_hutang']?></label></td>
                    <td><label><?= $r_hutang['supplier_addres']?></label></td>
                    <td style="text-align:center;">
											<a type="button" class="btn btn-default">
												<i class="fa fa-search" onclick="angsuran_v_2(<?= $r_hutang['supplier_id']?>)"></i>
											</a>
										</td>
                  </tr>
                 <?php $no++; } ?>
              </tbody>
            </table>
          </div>
        </div>
            <div style="clear:both;"></div>
            <div>
              <br>
            </div>
    </div>
  </div>
	<div class="box">
		<div id="supplier_name" style="display:none;text-align:center;font-size:18px;"></div>
	  <div id="angsuran_v_2" style="display:none;" class="box-body2 table-responsive">
	</div>
  </div>
  <div id="angsuran_v_4" class="box box-body" style="display:none;"></div>
</section><!-- /.content -->
<script>
	$('#submitButton').click(function() {
		$.ajax({
			url: 'angsuranhut.php?page=angsuranhut_v_2',
			dataType: 'json',
			data: myCriteria,
			success: function (data) {
				processData(data);
			}
		});
		alert("ok");
	});
  function angsuran_v_2(x){
		var a = document.getElementById('utama');
    var b = document.getElementById('supplier_name');
		var c = document.getElementById('angsuran_v_2');
		a.style.display='none';
    b.style.display='block';
		c.style.display='block';
    var y = document.getElementById('angsuran_v_2');
    y.style.display='block';
    $.ajax({
      type:'POST',
      data:{x:x},
      url:'angsuranhut.php?page=angsuranhut_v_2',
      dataType:'json',
    }).done(function(data){
        $('#angsuran_v_3').html("");
				$('#supplier_name').html("");
				$('#supplier_name').append('<label>'+data.data[0].supplier_name.toUpperCase()+'</label>');
				$('#angsuran_v_2').html("");
				$('#angsuran_v_2').append('<div class="box box-body table-responsive">\
				<table id="example2" style="width:100%;" class="table table-bordered table-striped">\
		      <thead>\
		        <tr>\
		          <th style="width:5%;text-align:center;">NO.</th>\
							<th style="text-align:center;">Id Hutang </th>\
		          <th style="text-align:center;">Uang muka </th>\
		          <th style="text-align:center;">Hutang </th>\
		          <th style="text-align:center;">Tanggal Beli </th>\
		          <th style="text-align:center;">Batas Tanggal </th>\
		          <th style="text-align:center;">Config </th>\
		        </tr>\
		      </thead>\
		      <tbody id="angsuran_v_3"></tbody>\
		    </table></div>');
        var no = 1;
        for(var inn2 = 0; inn2<data.data.length; inn2++){
        $('#angsuran_v_3').append('<tr>\
          <td style="text-align:center;">'+no+'</td>\
					<td>'+data.data[inn2].purchases_code+'</td>\
          <td style="text-align:center;">'+data.data[inn2].uang_muka+'</td>\
          <td style="text-align:center;">'+data.data[inn2].hutang+'</td>\
          <td style="text-align:center;">'+data.data[inn2].purchase_date+'</td>\
          <td style="text-align:center;">'+data.data[inn2].batas_tanggal+'</td>\
          <input type="hidden" value="data.data[inn2].id_hutang"></input>\
          <td style="text-align:center; width:100px;">\
						<a type="button" href="angsuranhut.php?page=save_angsuran_hut&id_hutang='+data.data[inn2].id_hutang+'"\
						  class="btn btn-default">\
							<i class="fa fa-money"></i>\
						</a>\
					</td>\
          </tr>\
        ');
        no++;
      }	setTimeout(function(){$('#example2').DataTable({
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
			});},5);
      });
  }

  function angsuran_v_4(x){
    //alert(x);
    var i = document.getElementById('utama');
    // i.style.display='none';
    var y = document.getElementById('angsuran_v_4');
    y.style.display='block';
    y.style.width='50%';
    $.ajax({
      type:'POST',
      data:{x:x},
      url:'angsuranhut.php?page=angsuranhut_v_4',
      dataType:'json',
    }).done(function(data){
        $('#angsuran_v_4').html("");
        $('#angsuran_v_4').append('');
      });
    }
    function byr_angsuran(x){
      var i = document.getElementById('nom_bayar').value;
      //var x = document.getElementById('sisa_hutang').value;
      var y = document.getElementById('angsuran_v_2');
      var j = document.getElementById('angsuran_v_4');
      var k = document.getElementById('payment_status').value;
      var l = document.getElementById('bank1').value;
      var m = document.getElementById('bank2').value;
      var n = document.getElementById('i_bank_account_1').value;
      var o = document.getElementById('i_bank_account_2').value;
      // alert(k);
        $.ajax({
          type:'POST',
          data:{i:i,x:x,k:k,l:l,m:m,n:n,o:o},
          url:'angsuranhut.php?page=save_angsuran',
          dataType:'json',
        }).done(function(){
        });
    }

    function update_change(a = 0){
      var bayar = parseFloat($("#nom_bayar").val());
      if(a == 0){
        var total = parseFloat($("#uang_sisa").val());
      }else{
        var total = a;
      }
          if(bayar > total ){
            alert("Kelebihan");
            kembali = 0;
          }else{
            kembali = total - bayar;
          }
          $("#sisa_hutang").val(kembali);
    }
    function get_change_sts(id){
            var color = "#eee";
          $(".i_span_sts").css("background-color", color);
          document.getElementById("i_span_sts_"+id).style.backgroundColor = "#ccc";
          //document.getElementById("i_span_"+id).style.color = "white";
        }
        function payment_method(id){
      		window.methodpembayaran = id;
              var bank_frame = document.getElementById("bank_frame");
              var bank_frame_transfer = document.getElementById("bank_frame_transfer");
              var angsuran_frame = document.getElementById("angsuran_frame");
              if(id == 1){
                bank_frame.style.display = 'none';
                bank_frame_transfer.style.display = 'none';
                document.getElementById('payment_status').value=id;
              }else if(id==2){
                bank_frame.style.display = 'table';
                bank_frame_transfer.style.display = 'none';
                document.getElementById('payment_status').value=id;
            }else {
              bank_frame.style.display = 'table';
              bank_frame_transfer.style.display = 'table';
              document.getElementById('payment_status').value=id;
            }
          }
</script>
