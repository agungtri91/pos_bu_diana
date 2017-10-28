<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../css/print/print.css" rel="stylesheet">
<link href="../font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<style media="screen">
	.padding-left{
		padding-left: 20px;
	}
	.padding-right{
		padding-right: 20px;
	}
</style>
<body id="angsuran_kredit" onload=print() style="width:100%;">
	<div class="Section2">
		<table id="header-angsuran">
			<tr>
					<td style="width:30%;">
						<?php $gambar = $r_office['office_img'] ?>
							<img id="img-angsuran" src="../img/office/<?=$gambar?>" alt="" style="width:200px;">
					</td>
					<td id="header-angsuran-title" class="center">
						BUKTI PEMBAYARAN ANGSURAN
					</td>
			</tr>
		</table>
		<div class="form-group" style="font-size:12px;">
			<label for="">Kode Pengangsuran : <?= $r_angsuran_kredit['angsuran_kredit_details_code']?></label>
		</div>
		<table id="tb_angsuran" style="width:100%;">
			<tr>
				<td style="width: 100px;">Tanggal Transaksi</td><td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;</td>
				<td><?= format_date_only($r_angsuran_kredit['transaction_date'])?></td>
				<td colspan="">&nbsp;&nbsp;&nbsp;</td>
				<?php while ($r_payment_method = mysql_fetch_array($q_payment_method)) {
					if ($r_payment_method['payment_method_id'] < 4) {?>
				<td style="width:100px;" colspan="2">
					<i
					<?php if ($r_payment_method['payment_method_id'] == $r_angsuran_kredit['cara_bayar_angsuran']){
						echo "class='fa fa-check'";} else { echo "class='fa fa-square-o'"; }?>>
					</i>
					<?= $r_payment_method['payment_method_name']?>
				</td>
					<? }
				} ?>
			</tr>
			<tr>
				<td>No. Angsuran</td><td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;</td><td><?= $r_angsuran_kredit['kredit_code']?></td>
				<td rowspan="<?= $row_span?>" colspan="11">
					<div style="clear:both;"></div>
					<table id="tb_list_angsuran">
						<tbody>
							<tr>
								<th class="center">No.</th>
								<th class="center">Jumlah Angsuran</th>
								<th class="center">Denda</th>
								<th class="center">Total Denda</th>
							</tr>
							<?php
							$no = 1;
							$total_denda = 0;
							$total_angsuran = 0;
							while ($r_angsuran_kredit = mysql_fetch_array($q_angsuran)) {?>
								<tr>
									<td class="center"><?= $no?></td>
									<td class="center"><?= format_rupiah($r_angsuran_kredit['angsuran_nominal'])?></td>
									<td class="center"><?= $r_angsuran_kredit['denda_persen']?></td>
									<td class="right"><?= format_rupiah($r_angsuran_kredit['denda_persen_nominal'])?></td>
								</tr>
							<? $no++;
							$total_denda = $total_denda + $r_angsuran_kredit['denda_persen_nominal'];
							$total_angsuran = $total_angsuran + $r_angsuran_kredit['angsuran_nominal'];
							$row_span++;
						} ?>

							<tr class="no-border">
								<td class="no-border padding-left" colspan="3">Total Angsuran</td>
								<td  class="right padding-right"><?= $total_angsuran?></td>
							</tr>
							<tr>
								<td class="padding-left" colspan="3">Total Denda</td>
								<td class="right padding-right"><?= $total_denda?></td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td>No. Transaksi</td><td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;</td><td><?= $r_angsuran_kredit['transaction_code']?></td>
			</tr>
			<tr>
				<td>Nama</td><td>&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp;</td><td><?= $r_angsuran_kredit['member_name']?></td>
			</tr>
		</table>
	</div>
	<br>
	<br>
	<center>
		<div class="row">
			<!-- <a href="#" class="hidden-print"><button class="back_to_order" onclick="send_email()"><label>Email</label></button></a> -->
			<a href="pdf.php?page=angsuran_piutang&transaction_id=<?= $transaction_id?>&branch_id=<?= $branch_id?>" class="hidden-print">
				<!-- <button class="btn btn-primary"><label>Save Pdf</label></button> -->
			</a>
			<a href="angsuran.php" class="hidden-print">
				<button class="btn btn-danger"><label>Kembali</label></button>
			</a>
		</div>
	</center>
</body>
<script>
	function close_window() {
		window.close();
	}
</script>
