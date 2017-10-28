<script type="text/javascript" src="../js/search2/jcfilter.min.js"></script>
<script type="text/javascript">
	function filter_cat(){
		alert("test");
	}
</script>
<link rel="stylesheet" href="../css/gadai.css">
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
<form method="post" enctype="multipart/form-data" role="form">
<!-- Main content -->
	<section class="content" style="padding-top: 0">
		<?php
				$gadai_id = get_last_id("gadai","gadai_id");?>
			<br>
		<div class="input-group">
			<input type="hidden" required class="form-control pull-right" name="gadai_id" id="gadai_id"value="<?= $gadai_id?>"/>
		</div>
		<div class="col-md-12" id="table_menu">
			<div class="box box-cokelat" style="padding-bottom:100px;">
				<div class="box-body">
					<div class="container">
					<!-- Top Navigation -->
					<section class="color-2">
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
								<label>Tanggal :</label>
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
								<div id="" class="form-group">
									<div class="form-group">
										<label>Tambah Member :</label>
										<select id="i_member" name="i_member" size="1" class="selectpicker show-tick form-control"
										data-live-search="true" onchange="select_member()"/>
											<option value="0"></option>
											<?php
											while ($r_member = mysql_fetch_array($q_member)) {?>
												<option value="<?= $r_member['member_id']?>"><?= $r_member['member_name']?></option>
											<?}
											 ?>
											<option type="button" id="tambah_supplier" class="btn btn-default" value="+">
											- - - Tambah Member - - -
											</option>
										</select>
									</div>
								</div>
							</div>
						<div class="col-md-3">
							<div id="" class="form-group">
								<label>Cabang :</label>
								<select name="i_branch_id" id="i_branch_id" class="selectpicker show-tick form-control"
								data-live-search="true" value="0">
									<option value="0"></option>
									<?php
									if ($_SESSION['branch_id_1']) {
										$type = $_SESSION['branch_id_1'];
									} else {
										$type = $_SESSION['branch_id'];
									}
								while($row_branch=mysql_fetch_array($q_branch)){
									?><option value="<?= $row_branch['branch_id']?>"<?php if($type == $row_branch['branch_id']){echo "Selected";} ?>>
										<?= $row_branch['branch_name']; ?>
									</option>
								<?php } ?>
									 ?>
								</select>
							</div>
						</div>
						</div><!-- row -->
						<div class="row">
							<input type="hidden" name="i_permit" id="i_permit" value="<?= $permit?>">
							<input type="hidden" id="s_member_id" name="s_member_id" value="<?= isset($_SESSION['member_id']) ? $_SESSION['member_id'] : 0?>">
							<input type="hidden" id="img_val" value="1"></input>
							<div id="ket_member_frame" class="row" style="display:none;">
								<div class="col-md-12">
									<div id="ket_member"></div>
									<div id="barang_gadai_frame"></div>
								</div>
							</div>
						</div>
					</div>
				</div><!-- /container -->
			</div>
		</div>
					</section>
		</div>
</section>
</form>
 <!-- start popmodal -->

<div id="gadai_popmodal" class="modal fade bs-example-modal-lg" tabindex="-1"
role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content" id="gadai_popmodal_content" style="border-radius:0;">

    </div>
  </div>
</div>

<script type="text/javascript">
	function select_member(){
		$('#ket_member_frame').removeAttr('style');
		var i_member = $('#i_member').val();
		var i_permit = $('#i_permit').val();
		var str = 'readonly';
		if (i_member == '+') {
			tambah_member();
		} else {
				$.ajax({
					type:'POST',
					data:{i_member:i_member},
					url:'gadai.php?page=ket_member',
					dataType:'json',
				}).done(function(data){
					$('#ket_member').html("");
					$('#ket_member').append('\
					<div class="box">\
						<div class="box-body">\
							<div class="row">\
								<div class="col-md-12">\
									<div class="title_page">FORMULIR PELANGGAN</div>\
										<div class="box-body">\
											<div class="col-md-12">\
												<div class="form-group">\
													<input type="hidden" name="member_id" id="member_id" value="'+data.member_id+'">\
													<label>Nama </label>\
													<input required type="text" name="i_name" class="form-control"\
													placeholder="Masukkan Nama..."\
													value="'+data.member_name+'" '+str+'/>\
												</div>\
												<div class="form-group">\
													<label>NIK </label>\
													<input required type="text" name="i_nik" class="form-control"\
													placeholder="Masukkan NIK..."\
													value="'+data.member_nik+'" '+str+'/>\
												</div>\
											</div>\
										</div>\
								</div>\
							</div>\
						</div>\
					</div>\
					');
					barang_gadai_form(data.member_id);
				});
		}
	}


	function barang_gadai_form(member_id){
		var i_date = $('#date_picker1').val();
		var i_member = $('#i_member').val();
		var i_branch_id = $('#i_branch_id').val();
		var img_val = $('#img_val').val();
		var action = 'gadai.php?page=save_gadai&i_date='+i_date+'&i_member='+i_member+'&i_branch_id='+i_branch_id+'&img_val='+img_val;
		$('#barang_gadai_frame').append('\
		<form action="'+action+'" method="post" enctype="multipart/form-data">\
			<div class="box">\
				<div class="row">\
					<div class="col-md-12">\
							<div class="box-body">\
								<div class="row">\
									<div class="col-md-3">\
										<div class="panel panel-default">\
											<div id="output_frame_1">\
												<div class="panel-heading" style="float:right;">\
													<button type="button" class="btn btn-danger" onclick="close_img(1)"><i class="fa fa-times"></i></button>\
												</div>\
												<div class="panel-body">\
													<div class="form-group" style="max-width:200px;max-height:200px;">\
														<img id="output_1" class="img-responsive" style="height:170px;">\
													</div>\
												</div>\
												<div class="panel-footer" style="float:bottom-left;">\
													<input type="file" name="i_img[]" id="i_img_1" accept="image/*"  onchange="loadFile(event,1)"/>\
												</div>\
											</div>\
										</div>\
									</div>\
									<div id="gambar_2"></div>\
								</div>\
								<div class="form-group" style="display:none;">\
									<br>\
									<label>Kode Program </label>\
									<input type="hidden" value="'+member_id+'">\
									<input type="text" name="i_kode_program" class="form-control"\
									placeholder="Masukkan Kode Program..."\
									value=""/>\
								</div>\
								<div class="form-group">\
									<label>Nama Barang </label>\
									<input id="i_nama_barang" name="i_nama_barang" size="1" class="form-control"/>\
								</div>\
								<div class="row">\
									<div class="col-md-4">\
										<div class="form-group">\
											<label>Jenis Barang </label>\
											<select id="i_jenis_barang" name="i_jenis_barang" size="1" class="selectpicker show-tick form-control"\
											data-live-search="true"/>\
										</div>\
									</div>\
									<div class="col-md-4">\
										<div class="form-group">\
											<label>Merk / Model Barang </label>\
											<input required type="text" name="merk_barang" class="form-control"\
											placeholder="Masukkan Merk / Model Barang..."\
											value=""/>\
										</div>\
									</div>\
									<div class="col-md-4">\
										<div class="form-group">\
											<label>Tipe Barang </label>\
											<input required type="text" name="i_tipe_barang" id="i_tipe_barang" class="form-control"\
											placeholder="Masukkan Tipe Barang..."\
											value=""/>\
										</div>\
									</div>\
								</div>\
								<div class="row">\
									<div class="col-md-12">\
										<div class="form-group">\
											<label>Adminstrasi</label>\
											<input required type="" id="i_adminstrasi_currency" name="i_adminstrasi_currency" class="form-control"\
											placeholder="Masukkan Biaya Administrasi..."\
											value="" onkeyup="nilai_currency(this);"/>\
											<input required type="hidden" id="i_adminstrasi" name="i_adminstrasi" class="form-control"\
											value=""/>\
										</div>\
									</div>\
									<div class="" style="display:none;">\
										<div class="form-group">\
											<label>Harga Barang</label>\
											<input  type="text" id="i_harga_barang_currency" name="i_harga_barang_currency" class="form-control"\
											placeholder="Masukkan Harga Barang..."\
											value="" onkeyup="nilai_currency(this);"/>\
											<input  type="hidden" id="i_harga_barang" name="i_harga_barang" class="form-control"\
											placeholder="Masukkan Harga Barang..."\
											value=""/>\
										</div>\
									</div>\
								</div>\
								<div class="row">\
									<div class="col-md-6">\
										<div class="form-group" style="display:;">\
											<label>Cara Pembayaran</label>\
											<select id="i_cara_pembayaran" name="i_cara_pembayaran" size="1" class="selectpicker show-tick form-control"\
											data-live-search="true"/>\
										</div>\
									</div>\
									<div class="col-md-6">\
										<div class="form-group">\
											<label>Nilai Pembiayaan  </label>\
											<input type="text" id="i_nilai_pembiayaan_currency" name="i_nilai_pembiayaan_currency" class="form-control"\
											placeholder="Masukkan Nilai Pembiayaan..."\
											value="" onkeyup="nilai_currency(this);"/>\
											<input required type="hidden" id="i_nilai_pembiayaan" name="i_nilai_pembiayaan" class="form-control"\
											value=""/>\
										</div>\
									</div>\
								</div>\
								<div class="row">\
									<div class="col-md-3">\
										<div class="form-group">\
											<label>Periode Angsuran Gadai</label>\
											<select id="i_periode_angsuran" name="i_periode_angsuran" size="1" class="selectpicker show-tick form-control"\
											data-live-search="true" onchange="periode_angsuran()"/>\
										</div>\
									</div>\
									<div class="col-md-3">\
										<div class="form-group">\
											<label>Lama Angsuran</label>\
											<select id="i_lama_angsuran" name="i_lama_angsuran" size="1" class="selectpicker show-tick form-control"\
											data-live-search="true" onchange="lama_angsuran()"/>\
										</div>\
									</div>\
									<div class="col-md-3">\
										<div class="form-group">\
											<label>Angsuran Gadai Per Bulan</label>\
											<input required type="text" id="i_angsuran_per_bulan_currency" name="i_angsuran_per_bulan_currency" class="form-control"\
											placeholder="Masukkan Angsuran..." value="" readonly/>\
											<input required type="hidden" id="i_angsuran_per_bulan" name="i_angsuran_per_bulan" class="form-control"\
											placeholder="Masukkan Angsuran..." value="" readonly/>\
										</div>\
									</div>\
									<div class="col-md-3">\
										<div class="form-group">\
											<label>Pembayaran Per Tanggal </label>\
											<input type="text" required class="form-control pull-right" id="per_tanggal"\
											name="i_date_pembayaran" value=""/>\
										</div>\
									</div>\
								</div>\
								<div style="clear:both"></div>\
							</div>\
							<div style="float:right;">\
								<button type="submit" class="btn btn-primary">Simpan</button>\
								<button class="btn btn-danger" onclick="close_form()">Batal</button>\
							</div>\
					</div>\
				</div>\
			</div>\
		</form>\
		');
		open_select_periode("periode","i_periode_angsuran");
		open_select_tipe_barang("kategori","i_jenis_barang");
		open_select_payment("payment_methods","i_cara_pembayaran");
		$('.selectpicker').selectpicker('refresh');
		$('#per_tanggal').daterangepicker({
				format: 'DD'
			});
	}



	function open_select_periode(table,elem){
		var elem = $('#'+elem);
		$.ajax({
			type:'POST',
			data:{table:table},
			url:'gadai.php?page=select_periode',
			dataType:'json',
		}).done(function(data) {
				elem.empty();
				elem.append('<option value="0"></option>');
			for (var i = 0; i < data.length; i++) {
				elem.append('<option value="'+data[i].id+'">'+data[i].name+'</option>');
			}
			$('.selectpicker').selectpicker('refresh');
		});
	}

	function periode_angsuran(){
		var i_periode_angsuran = $('#i_periode_angsuran');
    $('#i_lama_angsuran').empty();
		$('#i_lama_angsuran').append('<option value="0"></option>');
    if (i_periode_angsuran.val() == 2) {
      for (var i = 0; i <= 56 ; i++) {
        $('#i_lama_angsuran').append('<option value="'+i+'">'+i+'</option>');
      }
    } else if (i_periode_angsuran.val() == 3) {
      for (var i = 0; i <= 12; i++) {
        $('#i_lama_angsuran').append('<option value="'+i+'">'+i+'</option>');
      }
    }
		$('.selectpicker').selectpicker('refresh');
	}

	function lama_angsuran(){
		var lama_angsuran = $('#i_lama_angsuran');
		var val_lama_angsuran = $('#i_lama_angsuran').val();
		$('#i_angsuran_per_bulan').empty();
		var nilai_pembiayaan = $('#i_nilai_pembiayaan').val();
		var nilai_angsuran = nilai_pembiayaan / val_lama_angsuran;

		var nilai_angsuran_bulat = pembulatan(nilai_angsuran);

		if (nilai_pembiayaan > 0) {
      $('#i_angsuran_per_bulan').val(nilai_angsuran_bulat);
      $('#i_angsuran_per_bulan_currency').val(format_rupiah(nilai_angsuran_bulat));
    }
	}

	function open_select_tipe_barang(table,elem){
		var elem = $('#'+elem);
		$.ajax({
			type:'POST',
			data:{table:table},
			url:'gadai.php?page=select_tipe_barang',
			dataType:'json',
		}).done(function(data) {
				elem.append('<option value="0"></option>');
			for (var i = 0; i < data.length; i++) {
				elem.append('<option value="'+data[i].id+'">'+data[i].name+'</option>');
			}
			$('.selectpicker').selectpicker('refresh');
		});
	}

	function open_select_payment(table,elem){
		var elem = $('#'+elem);
		$.ajax({
			type:'POST',
			data:{table:table},
			url:'gadai.php?page=select_payment',
			dataType:'json',
		}).done(function(data) {
				elem.append('<option value="0"></option>');
			for (var i = 0; i < data.length; i++) {
				elem.append('<option value="'+data[i].id+'">'+data[i].name+'</option>');
			}
			$('.selectpicker').selectpicker('refresh');
		});
	}


	function tambah_member(){
		var url = 'gadai.php?page=simpan_member';
		$('#ket_member').html("");
		$('#barang_gadai_frame').empty();
		$('#ket_member').append('\
	<div class="box">\
		<div class="box-body">\
			<form id="form_member" method="post" enctype="multipart/form-data" role="form">\
				<div class="">\
					<div class="row">\
						<div class="col-md-12">\
							<div class="title_page">FORMULIR PELANGGAN</div>\
								<div class="">\
									<ul class="nav nav-tabs" role="tablist">\
										<li role="presentation" class="active">\
											<a href="#tab_1" aria-controls="home" role="tab" data-toggle="tab">Data Pribadi&nbsp;<i id="t_1"></i></a>\
										</li>\
										<li role="presentation">\
											<a href="#tab_2" aria-controls="profile" role="tab" data-toggle="tab">Darurat&nbsp;<i id="t_2"></i></a>\
										</li>\
										<li role="presentation">\
											<a href="#tab_3" aria-controls="messages" role="tab" data-toggle="tab">Data Pekerjaan&nbsp;<i id="t_3"></i></a>\
										</li>\
									</ul>\
									<div class="tab-content">\
										<br>\
										<div role="tabpanel" class="tab-pane active" id="tab_1">\
											<div class="col-md-12">\
												<div class="form-group">\
													<label>Nama </label>\
													<input required type="text" id="i_name" name="i_name" class="form-control"\
													placeholder="Masukkan Nama..."\
													value=""/>\
												</div>\
												<div class="form-group">\
													<label>NIK </label>\
													<input required type="text" id="i_nik" name="i_nik" class="form-control"\
													placeholder="Masukkan NIK..."\
													value=""/>\
												</div>\
												<div class="row">\
													<div class="col-md-6">\
														<div class="form-group">\
															<label>Alamat</label>\
															<input required type="text" id="i_alamat" name="i_alamat" class="form-control"\
															placeholder="Masukkan Alamat..."\
															value=""/>\
														</div>\
													</div>\
													<div class="col-md-2">\
														<div class="form-group">\
															<label>Kode Pos</label>\
															<input required type="text" id="i_kode_pos" name="i_kode_pos" class="form-control"\
															placeholder="Kode Pos..."\
															value=""/>\
														</div>\
													</div>\
													<div class="col-md-4">\
														<div class="col-md-12">\
															<div class="row">\
																<div class="col-md-6">\
																	<div class="form-group">\
																		<label>RT</label>\
																		<input required type="text" id="i_rt" name="i_rt" class="form-control"\
																		placeholder="RT.."\
																		value=""/>\
																	</div>\
																</div>\
																<div class="col-md-6">\
																	<div class="form-group">\
																		<label>RW</label>\
																		<input required type="text" id="i_rw" name="i_rw" class="form-control"\
																		placeholder="RW.."\
																		value=""/>\
																	</div>\
																</div>\
															</div>\
														</div>\
													</div>\
												</div>\
												<div class="row">\
													<div class="col-md-4">\
														<div class="form-group">\
															<label>Kelurahan</label>\
															<input required type="text" id="i_kelurahan" name="i_kelurahan" class="form-control"\
															placeholder="Masukkan Kelurahan..."\
															value=""/>\
														</div>\
													</div>\
													<div class="col-md-4">\
														<div class="form-group">\
															<label>Kecamatan</label>\
															<input required type="text" id="i_kecamatan" name="i_kecamatan" class="form-control"\
															placeholder="Masukkan Kecamatan..."\
															value=""/>\
														</div>\
													</div>\
													<div class="col-md-4">\
														<div class="form-group">\
															<label>Kota</label>\
															<input required type="text" id="i_kota" name="i_kota" class="form-control"\
															placeholder="Masukkan Kota..."\
															value=""/>\
														</div>\
													</div>\
												</div>\
												<div class="form-group">\
													<label>Nama Ibu Kandung</label>\
													<input required type="text" id="i_ibu" name="i_ibu" class="form-control"\
													placeholder="Masukkan Nama Ibu Kandung..."\
													value=""/>\
												</div>\
												<div class="row">\
													<div class="col-md-6">\
														<div class="form-group">\
															<label>Tempat Lahir</label>\
															<input required type="text" id="i_tempat_lahir" name="i_tempat_lahir" class="form-control"\
															placeholder="Masukkan Tempat Lahir..."\
															value=""/>\
														</div>\
													</div>\
													<div class="col-md-6">\
														<div class="form-group">\
															<label>Tanggal Lahir</label>\
															<input type="text" required class="form-control pull-right"\
															id="date_picker2" name="i_tanggal_lahir" value="">\
														</div>\
													</div>\
												</div>\
												<div class="row">\
													<div class="col-md-6">\
														<div class="form-group">\
															<label>Status Perkawinan</label>\
															<select id="i_status_kawin" name="i_status_kawin" size="1" class="selectpicker show-tick form-control"\
															data-live-search="true" dropupAuto="true">\
																<option value="0"></option>\
																<option value="1">Kawin</option>\
																<option value="2">Cerai</option>\
																<option value="3">Belum Kawin</option>\
															</select>\
														</div>\
													</div>\
													<div class="col-md-6">\
														<div class="form-group">\
															<label>Jumlah Tanggungan</label>\
															<input required type="text" id="i_tanggungan" name="i_tanggungan" class="form-control"\
															placeholder="Masukkan Jumlah Tanggungan..."\
															value=""/>\
														</div>\
													</div>\
												</div>\
												<div class="row">\
													<div class="col-md-6">\
														<div class="form-group">\
															<label>Tlp. Rumah</label>\
															<input required type="text" id="i_phone_rumah" name="i_phone_rumah" class="form-control"\
															placeholder="Masukkan Tlp. Rumah..."\
															value=""/>\
														</div>\
													</div>\
													<div class="col-md-6">\
														<div class="form-group">\
															<label>Handphone</label>\
															<input required type="text" id="i_phone" name="i_phone" class="form-control"\
															placeholder="Masukkan Handphone..."\
															value=""/>\
														</div>\
													</div>\
												</div>\
												<div class="row">\
													<div class="col-md-6">\
														<div class="form-group">\
															<label>Status Rumah</label>\
															<select id="i_status_rumah" name="i_status_rumah" size="1" class="selectpicker show-tick form-control"\
															data-live-search="true">\
																<option value="0"></option>\
																<option value="1">Sendiri</option>\
																<option value="2">Keluarga</option>\
																<option value="3">Dinas</option>\
																<option value="4">Sewa</option>\
																<option value="5">KPR</option>\
															</select>\
														</div>\
													</div>\
													<div class="col-md-6">\
														<label>Lama Tinggal</label>\
														<input required type="text" id="i_lama_tinggal" name="i_lama_tinggal" class="form-control"\
														placeholder="Masukkan Handphone..."\
														value=""/>\
													</div>\
												</div>\
												<div class="form-group">\
													<label>Pendidikan Terakhir</label>\
													<select id="i_pendidikan" id="i_pendidikan" name="i_pendidikan" size="1" class="selectpicker dropup show-tick form-control"\
													data-live-search="true">\
														<option value="0"></option>\
														<option value="1">SD</option>\
														<option value="2">SMP</option>\
														<option value="3">SMA</option>\
														<option value="4">D3</option>\
														<option value="5">S1</option>\
													</select>\
												</div>\
												<div class="form-group">\
													<label>Email</label>\
													<input required type="email" id="i_email" name="i_email" class="form-control"\
													placeholder="Masukkan email member..."\
													value=""/>\
												</div>\
											</div>\
										</div>\
										<div role="tabpanel" class="tab-pane" id="tab_2">\
											<div class="col-md-12">\
												<div class="form-group">\
													<label for="">Nama</label>\
													<input type="text" id="nama_darurat" name="nama_darurat" class="form-control" value=""\
													placeholder="Masukkan Nama...">\
												</div>\
												<div class="form-group">\
													<label for="">Hubungan</label>\
													<select id="i_hubungan" name="i_hubungan" size="1" class="selectpicker show-tick form-control"\
													data-live-search="true">\
														<option value="0"></option>\
														<option value="1">Orang Tua</option>\
														<option value="2">Kakak</option>\
														<option value="3">Adik</option>\
														<option value="4">Anak</option>\
														<option value="5">Lainnya</option>\
													</select>\
												</div>\
												<div class="form-group">\
													<label for="">Alamat</label>\
													<input type="text" id="alamat_darurat" name="alamat_darurat" class="form-control" value=""\
													placeholder="Masukkan Alamat...">\
												</div>\
												<div class="form-group">\
													<label for="">No. Telp</label>\
													<input type="text" id="telp_darurat" name="telp_darurat" class="form-control" value=""\
													placeholder="Masukkan No. Telp...">\
												</div>\
											</div>\
										</div>\
										<div role="tabpanel" class="tab-pane" id="tab_3">\
											<div class="col-md-12">\
												<div class="form-group">\
													<label for="">Nama Perusahaan</label>\
													<input type="text" id="nama_perusahaan" name="nama_perusahaan" class="form-control" value=""\
													placeholder="Masukkan Nama Perusahaan...">\
												</div>\
												<div class="row">\
													<div class="col-md-6">\
														<div class="form-group">\
															<label for="">Alamat</label>\
															<input type="text" id="alamat_perusahaan" name="alamat_perusahaan" class="form-control" value=""\
															placeholder="Masukkan Alamat Perusahaan...">\
														</div>\
													</div>\
													<div class="col-md-2">\
														<div class="form-group">\
															<label for="">Kode Pos</label>\
															<input type="text" id="kode_pos_perusahaan" name="kode_pos_perusahaan" class="form-control" value=""\
															placeholder="Kode Pos...">\
														</div>\
													</div>\
													<div class="col-md-4">\
														<div class="col-md-6">\
															<div class="form-group">\
																<label for="">RT</label>\
																<input type="text" id="rt_perusahaan" name="rt_perusahaan" class="form-control" value=""\
																placeholder="RT...">\
															</div>\
														</div>\
														<div class="col-md-6">\
															<div class="form-group">\
																<label for="">RW</label>\
																<input type="text" id="rw_perusahaan" name="rw_perusahaan" class="form-control" value=""\
																placeholder="RW...">\
															</div>\
														</div>\
													</div>\
												</div>\
												<div class="row">\
													<div class="col-md-3">\
														<div class="form-group">\
															<label for="">Kelurahan</label>\
															<input type="text" id="kel_perusahaan" name="kel_perusahaan" class="form-control" value=""\
															placeholder="Masukkan Kel. Perusahaan...">\
														</div>\
													</div>\
													<div class="col-md-3">\
														<div class="form-group">\
															<label for="">Kecamatan</label>\
															<input type="text" id="kec_perusahaan" name="kec_perusahaan" class="form-control" value=""\
															placeholder="Masukkan Kec. Perusahaan...">\
														</div>\
													</div>\
													<div class="col-md-3">\
														<div class="form-group">\
															<label for="">Kota</label>\
															<input type="text" id="kota_perusahaan" name="kota_perusahaan" class="form-control" value=""\
															placeholder="Masukkan Kota...">\
														</div>\
													</div>\
													<div class="col-md-3">\
														<div class="form-group">\
															<label for="">Telepon</label>\
															<input type="text" id="telp_perusahaan" name="telp_perusahaan" class="form-control" value=""\
															placeholder="Masukkan Telp...">\
														</div>\
													</div>\
												</div>\
												<div class="form-group">\
													<label for="">Jenis Pekerjaan</label>\
													<input type="text" id="jenis_pekerjaan" name="jenis_pekerjaan" class="form-control" value=""\
													placeholder="Masukkan Jenis Pekerjaan...">\
												</div>\
												<div class="row">\
													<div class="col-md-6">\
														<div class="form-group">\
															<label for="">Jabatan</label>\
															<input type="text" id="jabatan" name="jabatan" class="form-control" value=""\
															placeholder="Masukkan Jabatan...">\
														</div>\
													</div>\
													<div class="col-md-6">\
														<div class="form-group">\
															<label for="">Lama Bekerja</label>\
															<div class="row">\
																<div class="col-md-6">\
																	<input type="text" id="lama_bekerja_tahun" name="lama_bekerja_tahun" class="form-control" value=""\
																	placeholder="Masukkan Tahun...">\
																</div>\
																<div class="col-md-6">\
																	<input type="text" id="lama_bekerja_bulan" name="lama_bekerja_bulan" class="form-control" value=""\
																	placeholder="Masukkan Bulan...">\
																</div>\
															</div>\
														</div>\
													</div>\
												</div>\
												<div class="row">\
			                    <div class="col-md-6">\
			                      <div class="form-group">\
			                        <label for="">Penghasilan</label>\
															<input type="text" id="penghasilan_currency" name="penghasilan_currency" class="form-control" value=""\
			                        placeholder="Masukkan Jabatan..." onkeyup="nilai_currency(this);"/>\
			                        <input type="hidden" id="penghasilan" name="penghasilan" class="form-control" value="">\
			                      </div>\
			                    </div>\
			                    <div class="col-md-6">\
			                      <div class="form-group">\
			                        <label for="">Pengeluaran Rata - Rata</label>\
															<input type="text" id="pengeluaran_currency" name="pengeluaran_currency" class="form-control" value=""\
			                        placeholder="Masukkan Jabatan..." onkeyup="nilai_currency(this);"/>\
			                        <input type="hidden" id="pengeluaran" name="pengeluaran" class="" value="">\
			                      </div>\
			                    </div>\
			                  </div>\
												<div class="row">\
													<div class="col-md-6">\
														<div class="form-group">\
															<label for="">Penghasilan Lain</label>\
															<input type="text" id="penghasilan_lain_currency" name="penghasilan_lain_currency" class="form-control" value=""\
															placeholder="Masukkan Penghasilan..." onkeyup="nilai_currency(this);"/>\
															<input type="hidden" id="penghasilan_lain" name="penghasilan_lain" class="form-control" value="">\
														</div>\
													</div>\
													<div class="col-md-6">\
														<div class="form-group">\
															<label for="">Sumber Penghasilan Lain</label>\
															<select id="sumber_penghasilan_lain" name="sumber_penghasilan_lain" size="1"\
															 class="selectpicker show-tick form-control"\
															data-live-search="true">\
																<option value="0"></option>\
																<option value="1">Suami / Istri</option>\
																<option value="2">Orang Tua</option>\
																<option value="3">Usaha Lain</option>\
															</select>\
														</div>\
													</div>\
												</div>\
											</div>\
											<div style="float:right;">\
											<br>\
											<br>\
											<br>\
												<button type="submit" class="btn btn-primary" onclick="simpan_form(2)">Simpan</button>\
												<button type="" class="btn btn-danger">Batal</button>\
											</div>\
										</div>\
									</div>\
								</div>\
						</div>\
					</div>\
				</div>\
			</form>\
		</div>\
	</div>\
		');
		$('.selectpicker').selectpicker('refresh');
	}

	function simpan_form(x){
		if (x == 1) {
			var i_date = $('#date_picker1').val();
			var i_member = $('#i_member').val();
			var i_branch_id = $('#i_branch_id').val();
			var action = 'gadai.php?page=save_gadai&i_date='+i_date+'&i_member='+i_member+'&i_branch_id='+i_branch_id;
			document.getElementById('form_gadai').action = action;
			document.getElementById('form_gadai').submit();
		} else {
			var field1_1 = $('#i_name');
			var field1_2 = $('#i_phone');
			var field1_2 = $('#i_phone');
			var field1_3 = $('#i_email');
			var field1_4 = $('#i_nik');
			var field1_5 = $('#i_alamat');
			var field1_6 = $('#i_kode_pos');
			var field1_7 = $('#i_rt');
			var field1_8 = $('#i_rw');
			var field1_9 = $('#i_kelurahan');
			var field1_10 = $('#i_kecamatan');
			var field1_11 = $('#i_kota');
			var field1_12 = $('#i_ibu');
			var field1_13 = $('#date_picker2');
			var field1_14 = $('#i_tanggal_lahir');
			var field1_15 = $('#i_tempat_lahir');
			var field1_16 = $('#i_status_kawin');
			var field1_17 = $('#i_tanggungan');
			var field1_18 = $('#i_phone_rumah');
			var field1_19 = $('#i_phone');
			var field1_20 = $('#i_status_rumah');
			var field1_21 = $('#i_lama_tinggal');
			var field1_22 = $('#i_pendidikan');

			var field2_23 = $('#nama_darurat');
			var field2_24 = $('#i_hubungan');
			var field2_25 = $('#alamat_darurat');
			var field2_26 = $('#telp_darurat');

			var field3_27 = $('#nama_perusahaan');
			var field3_28 = $('#alamat_perusahaan');
			var field3_29 = $('#kode_pos_perusahaan');
			var field3_30 = $('#rt_perusahaan');
			var field3_31 = $('#rw_perusahaan');
			var field3_32 = $('#kel_perusahaan');
			var field3_33 = $('#kec_perusahaan');
			var field3_34 = $('#kota_perusahaan');
			var field3_35 = $('#telp_perusahaan');
			var field3_36 = $('#jenis_pekerjaan');
			var field3_37 = $('#jabatan');
			var field3_38 = $('#lama_bekerja_tahun');
			var field3_39 = $('#lama_bekerja_bulan');
			var field3_40 = $('#penghasilan');
			var field3_41 = $('#pengeluaran');
			var field3_42 = $('#penghasilan_lain');
			var field3_43 = $('#sumber_penghasilan_lain');

			var field = new Array(field1_1, field1_2, field1_3, field1_4, field1_5, field1_6, field1_7, field1_8,
														field1_9, field1_10, field1_11, field1_12, field1_13, field1_14, field1_15, field1_16,
														field1_17, field1_18, field1_18, field1_19, field1_20, field1_21, field1_22, field2_23, field2_24,
														field2_25, field2_26, field3_27, field3_28, field3_29, field3_30, field3_31, field3_32, field3_33, field3_33,
														field3_34, field3_35, field3_36, field3_37, field3_38, field3_39, field3_40, field3_41, field3_42, field3_43);

														$('#t_1').removeClass('fa fa-times');
														$('#t_2').removeClass('fa fa-times');
														$('#t_3').removeClass('fa fa-times');

														var field_count = field.length;
										        var x = 1;
														for (var i = 0; i <= field_count; i++) {
															var elem = field[i];
															var value = field[i].val();
															var parent = $(elem).parent();
															var grandparent = parent.parent() ;
															var master_grandparent = grandparent.parent();
															var id_master = master_grandparent.attr('id');
															if (value == false) {
																$(elem).addClass('error');
																if (id_master == 'tab_1') {
																	console.log(id_master);
																	$('#t_1').addClass('fa fa-times');
																}
																if (id_master == 'tab_2') {
																	$('#t_2').addClass('fa fa-times');
																}
																if (id_master == 'tab_3'){
																	$('#t_3').addClass('fa fa-times');
																}
																console.log(master_grandparent);
															} else {
																$(elem).removeClass('error');
																x++;
															}
															if (x==45) {
																var action = 'gadai.php?page=simpan_member';
																document.getElementById('form_member').action = action;
																document.getElementById('form_member').submit();
															}
														}

		}
	}

$(document).ready(function(){
	var i_member = $('#s_member_id').val();
	var str = 'readonly';
	if (i_member != 0) {
	document.getElementById('ket_member_frame').style.display='block';
			$.ajax({
				type:'POST',
				data:{i_member:i_member},
				url:'gadai.php?page=ket_member',
				dataType:'json',
			}).done(function(data){
				$('#ket_member').html("");
				$('#ket_member').append('\
			<div class="box">\
				<div class="box-body">\
					<div class="row">\
						<div class="col-md-12">\
							<div class="title_page">FORMULIR PELANGGAN</div>\
								<div class="box-body">\
									<div class="col-md-12">\
										<div class="form-group">\
											<input type="hidden" name="member_id" id="member_id" value="'+data.member_id+'">\
											<label>Nama </label>\
											<input required type="text" name="i_name" class="form-control"\
											placeholder="Masukkan Nama..."\
											value="'+data.member_name+'" '+str+'/>\
										</div>\
										<div class="form-group">\
											<label>NIK </label>\
											<input required type="text" name="i_nik" class="form-control"\
											placeholder="Masukkan NIK..."\
											value="'+data.member_nik+'" '+str+'/>\
										</div>\
									</div>\
								</div>\
						</div>\
					</div>\
				</div>\
			</div>\
				');
				barang_gadai_form(data.member_id);
			});
		} else {
			$('#ket_member_frame').removeAttr('style');
			tambah_member();
		}
});
var loadFile = function(event,elem) {
	var reader = new FileReader();
	var x = $('#img_val').val();
		reader.onload = function(){
			$("#output_"+elem).attr("src",reader.result);
			var y = parseInt(x) + parseInt(1);
			$('#img_val').val(y);
			if ( x < 4 ) {
				$('#gambar_2').append('\
					<div class="col-md-3">\
						<div class="panel panel-default">\
							<div id="output_frame_'+y+'">\
								<div class="panel-heading" style="float:right;">\
									<button type="button" class="btn btn-danger" onclick="close_img('+y+')"><i class="fa fa-times"></i></button>\
								</div>\
								<div class="panel-body">\
									<div class="form-group" style="max-width:200px;max-height:200px;">\
										<img id="output_'+y+'" class="img-responsive" style="height:170px;">\
									</div>\
								</div>\
								<div class="panel-footer" style="float:bottom-left;">\
									<input type="file" name="i_img[]" id="i_img_'+y+'" accept="image/*" onchange="loadFile(event,'+y+')"/>\
								</div>\
							</div>\
						</div>\
					</div>\
				');
			}
		};
		reader.readAsDataURL(event.target.files[0]);
};

function close_img(x){
	var i_img = $('#i_img_'+x).val();
	$('#output_'+x).attr('src','');
	var input_img = $('#i_img_'+x);
	input_img.replaceWith(input.val('').clone(true));
}

function close_form(){
	var url = "gadai.php?page=session_destroy";
	window.location.href = url;
}

function nilai_currency(elem){
	var elem_id = elem.id;
	var elem = '#'+elem.id;
	var elem_val_curr = $(elem).val();
	var elem_val_curr_no_rupiah = remove_rupiah(elem_val_curr);
	var elem_val_curr_no_currency = elem_val_curr_no_rupiah.toString().replace(/[^0-9\.]+/g, "");

	var elem_str = elem_id.toString();
	var elem_no_cur = elem_str.replace(/_currency/g,'');

	var elem_val_currency = format_rupiah(elem_val_curr);
	$(elem).val(elem_val_currency);
	$('#'+elem_no_cur).val(elem_val_curr_no_currency);
}

</script>
