<!-- INVOICE PENJUALAN  -->
<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../css/print/print.css" rel="stylesheet">
<!-- <body  onload=print()> -->
<body style='font-family:tahoma; font-size:8pt;' onload=print()>
<center>
	<table style='width:100%; font-size:8pt; font-family:calibri; border-collapse: collapse;' border = '0'>
		<td width='30%' align='left' style='padding-right:80px; vertical-align:top'>
			<span class="header">
				<b>FAKTUR PENJUALAN
					<br>
					<?= $r_office['office_name']?>
				</b>
			</span>
			</br>
				<?= $r_office['office_address']?>
			</br>
			<?= $r_office['office_phone']?>
		</td>
		<td style='vertical-align:top' width='30%' align='left'>
			PRINTED DATE&nbsp;&nbsp;: <?= $r_invoice['transaction_date']?></br>
			NO. NOTA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?= $r_invoice['transaction_code'] ?></br>
		</td>
		<td style='vertical-align:top' width='30%' align='left'>
			KEPADA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?= $r_member['member_name'] ?></br>
			ALAMAT&nbsp;&nbsp;&nbsp;&nbsp;:<?= $r_member['member_alamat'] ?></br>
			KIRIM KE&nbsp;&nbsp;&nbsp;:<?= $r_member['member_alamat'] ?></br>
		</td>
	</table>
	<table id="lintable" cellspacing='0' style='width:100%; font-size:8pt; font-family:calibri;  border-collapse: collapse;'>
		<tr align='center'>
			<td width='5%'>NO.</td>
			<td>KODE BARANG.</td>
			<td>NAMA BARANG</td>
			<td>JML</td>
			<td>JML. KONVERSI</td>
			<td>BERAT</td>
			<td>HARGA</td>
			<td>SUB TOTAL</td>
   	</tr>
		<tbody style="border-bottom : 1px solid">
				<?php
				$no = 1;
				$total_berat = 0;
				$total_jml = 0;
				$q_invo = get_detail_transaction($r_invoice['transaction_id']);
				while ($r_invo = mysql_fetch_array($q_invo)) { ?>
					<tr>
						<td class="center no-border"><?= $no?></td>
						<td class="center no-border"><?= $r_invo['kode_barang'] ?></td>
						<td class="left no-border"><?= $r_invo['item_name'] ?></td>
						<td class="center no-border"><?= $r_invo['transaction_detail_qty_real'] ?>(<?= $r_invo['unit_utama_name']?>)</td>
						<?php $unit_id_utama = get_unit_id($r_invo['item_id']); ?>
						<td class="center no-border"><?= konversi_total_jumlah($unit_id_utama, $r_invo['item_id'],$r_invo['transaction_detail_qty_real']
							,$r_invo['transaction_detail_unit'])?>
						</td>
						<td class="center no-border"><?= $r_invo['item_berat']?></td>
						<td class="center no-border"><?= format_rupiah($r_invo['transaction_detail_price'])?></td>
						<td class="right no-border"><?= format_rupiah($r_invo['transaction_detail_price']*$r_invo['transaction_detail_qty']) ?></td>
					</tr>
				<? $no++;
					$total_jml = $total_jml + $r_invo['transaction_detail_qty_real'];
					$total_berat = $total_berat + $r_invo['item_berat'];
				} ?>
		</tbody>
			<tr class="right no-border">
				<td class="no-border left" colspan="2">Tipe Pembayaran</td>
				<td class="no-border left" > : <?= get_payment_method($r_invoice['payment_method_id'])?></td>
				<td class="no-border"></td>
				<td class="no-border"></td>
				<td class="no-border center"><?= format_berat($total_berat)?></td>
				<td class="no-border right">
					<div>Total Yang Harus Di Bayar Adalah : </div>
				</td>
				<td><?= format_rupiah($r_invoice['transaction_grand_total'])?></td>
			</tr>
			<tr class="right no-border">
				<td class="no-border left" colspan="2">Uang Muka</td>
				<td class="no-border left">: <?= $uang_muka?></td>
				<td class="no-border left" colspan="3" rowspan="5">
					Catatan :
					<?= $r_invoice['transaction_desc']?>
				</td>
				<td class="no-border right">
					<div>Diskon Nominal: </div>
				</td>
				<td style='text-align:right'><?= format_rupiah($r_invoice['transaction_discount_nominal'])?></td>
			</tr>
			<tr>
				<td class="no-border left" colspan="2">Sisa</td>
				<td class="no-border left"> : <?= $uang_sisa?></td>
				<td  class="no-border right" colspan = ''>
					<div>Diskon Persen(<?= $r_invoice['transaction_discount']?> % ) : </div>
				</td>
				<td style='text-align:right'><?= $potongan_diskon_persen?></td>
			</tr>
			<tr>
				<td class="no-border left" colspan = "2"></td>
				<td class="no-border left"></td>
				<td class="no-border right">
					<div>Kembalian : </div>
				</td>
				<td style='text-align:right'><?= format_rupiah($r_invoice['transaction_change'])?></td>
			</tr>
			<tr class="right no-border">
				<td class="no-border left" colspan="2">BANK Pembeli</td>
				<td class="no-border left"> : <?= get_bank_name($r_invoice['bank_id'])?></td>
			</tr>
			<tr class="right no-border">
				<td class="no-border left" colspan="2">No. Rekening</td>
				<td class="no-border left"> : <?= $r_invoice['i_bank_account'] ? $r_invoice['i_bank_account'] : "-"?></td>
			</tr>
		</table>
		<table style="width:100%;padding-top:0;font-size:10px;">
			<tr style="height:50px;">
				<td style="text-align:center;width:50%;">Pembeli</td>
				<td style="text-align:center;">Hormat Kami,<br><?= $r_office['office_name']?></td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;</td>
				<td>&nbsp;&nbsp;&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;</td>
				<td>&nbsp;&nbsp;&nbsp;</td>
			</tr>
			<tr>
				<td style="text-align:center;width:50%;">
					<?= $r_member['member_name'] ? $r_member['member_name'] : "................."?></td>
				<td style="text-align:center;"><?= $user_name?></td>
			</tr>
		</table>
		<div class="row">
			<!-- <a href="#" class="hidden-print"><button class="back_to_order" onclick="send_email()"><label>Email</label></button></a> -->
			<a href="pdf.php?page=list&transaction_id=<?= $transaction_id?>&branch_id=<?= $branch_id?>" class="hidden-print">
				<button class="btn btn-primary"><label>Save Pdf</label></button>
			</a>
			<a href="transaction_new.php" class="hidden-print">
				<button class="btn btn-danger"><label>Kembali</label></button>
			</a>
		</div>
</center>
</body>
<form action="email.php?page=list&transaction_id=<?= $r_invoice['transaction_id']?>"
	enctype="	multipart/form-data" method="post">
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel" style="z-index:888888;">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content" style="border-radius: 0;">
	      <div class="modal-header" style="border-radius:0px">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
	        <h4 class="modal-title" id="myModalLabel">Kirim Email</h4>
	      </div>
	      <div class="modal-body">
					<div  class="form-group">
					</div>
					<div class="form-group">
						<label>Nama Email Tujuan</label>
						<input required type="text" name="i_mail_to" id="i_mail_to" class="form-control"
						placeholder="Masukkan email..."/>
						</input>
					</div>
	      </div>
	      <div class="modal-footer">
	        <button type="submit" class="btn btn-primary">Kirim</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
	      </div>
	    </div>
	  </div>
	</div>
</form>
<?php  ?>
<script src="../js/jquery.js"></script>
<script src="../js/bootstrap.min.js" type="text/javascript"></script>
<script>
function send_email() {
	$('#myModal').modal();
}

function save_pdf(){
}
	// function back() {
	// 	window.location.href = 'home.php';
	// }
</script>
