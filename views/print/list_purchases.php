<!-- INVOICE PENJUALAN  -->
<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../css/print/print.css" rel="stylesheet">
<!-- <body  onload=print()> -->
<body style='font-family:tahoma; font-size:8pt;' onload=print()>
	<?php
			$query=mysql_query("SELECT * FROM office");
			$r_office = mysql_fetch_array($query);
		 ?>
	<center>
		<table style='width:100%; font-size:8pt; font-family:calibri; border-collapse: collapse;' border = '0'>
			<td width='30%' align='left' style='padding-right:80px; vertical-align:top'>
				<span class="header">
					<b>
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
				PRINTED DATE&nbsp;&nbsp;: <?= format_date_only($r_purchases['purchases_date'])?></br>
				NO. NOTA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?= $r_purchases['purchases_code'] ?></br>
			</td>
			<td style='vertical-align:top' width='30%' align='left'>
				SUPPLIER&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?= $r_purchases_supplier['supplier_name'] ?></br>
				ALAMAT&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?= $r_purchases_supplier['supplier_addres'] ? $r_purchases_supplier['supplier_addres'] : "-" ?></br>
				TELEPON&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:<?= $r_purchases_supplier['supplier_phone'] ? $r_purchases_supplier['supplier_phone'] : "-" ?></br>
			</td>
		</table>
		<table id="lintable" cellspacing='0' style='width:100%; font-size:8pt; font-family:calibri;  border-collapse: collapse;'>
			<tr align='center'>
				<td width='5%'>NO.</td>
				<td>KODE BARANG.</td>
				<td>NAMA BARANG</td>
				<td>JUMLAH</td>
				<td>BERAT</td>
				<td>HARGA</td>
				<td>SUB TOTAL</td>
	   	</tr>
			<tbody style="border-bottom : 1px solid">
					<?php
					$no = 1;
					$total_berat = 0;
					$q_purchase = get_purchase($r_purchases['purchase_id']);
					while ($r_purchase = mysql_fetch_array($q_purchase)) { ?>
						<tr>
							<td class="center no-border"><?= $no?></td>
							<td class="center no-border"></td>
							<td class="left no-border"><?= $r_purchase['item_name'] ?></td>
							<td class="center no-border"><?= $r_purchase['purchase_qty'] ?> <?= $r_purchase['unit_name'] ?></td>
							<td class="center no-border"></td>
							<td class="right no-border"><?= format_rupiah($r_purchase['purchase_price']) ?></td>
							<td class="right no-border"></td>
						</tr>
					<? $no++;
						// $total_berat = $total_berat + $r_invo['item_berat'];
					} ?>
			</tbody>
				<tr class="right no-border">
					<td class="no-border left" colspan="2">Tipe Pembayaran</td>
					<td class="no-border left"> : <?= get_payment_method($r_purchases['payment_method'])?></td>
					<td class="no-border center"></td>
					<td class="no-border"></td>
					<td class="no-border right" colspan = ''>
						<div>Total Yang Harus Di Bayar Adalah : </div>
					</td>
					<td> Rp.<?= format_rupiah($r_purchases_t['purchase_total'])?>,00</td>
				</tr>
				<tr class="right no-border">
					<td class="no-border left" colspan="2">Uang Muka</td>
					<td class="no-border left">: Rp.<?= format_rupiah($r_hutang['uang_muka_barang'])?>,00</td>
					<td class="no-border left" colspan="2" rowspan="5">
						Catatan : <?= $r_purchases['purchase_desc']?>
					</td>
					<td  class="no-border right" colspan = ''>
						<div>Bayar : </div>
					</td>
					<td class="right">
						<?=format_rupiah($r_purchases_t['purchase_payment'])?>
					</td>
				</tr>
				<tr>
					<td class="no-border left" colspan="2">Sisa</td>
					<td class="no-border left"> : Rp.<?= format_rupiah($r_purchases_t['purchase_total'] - $r_hutang['uang_muka_barang'])?>,00</td>
					<td class="no-border right">
						<div>Kembalian : </div>
					</td>
					<td class="right">
						<?= format_rupiah($r_purchases_t['purchase_change'])?>
					</td>
				</tr>
				<tr>
					<td class="no-border left" colspan = "2">Tanggal Jatuh Tempo</td>
					<td class="no-border left"> : <?= format_date_only($r_hutang['batas_tanggal_angsuran'])?></td>
					<td class="no-border right"></td>
					<td class="no-border right"></td>
				</tr>
				<tr class="right no-border">
					<td class="no-border left" colspan="2">BANK Supplier</td>
					<td class="no-border left"> : <?= get_bank_name($r_purchases['bank_id_to'])?></td>
				</tr>
				<tr class="right no-border">
					<td class="no-border left" colspan="2">No. Rekening</td>
					<td class="no-border left"> :
						<?= $r_purchases['bank_account_to'] ? $r_purchases['bank_account_to'] : "-"?>
					</td>
				</tr>
			</table>
			<table style="width:100%;padding-top:0;font-size:10px;">
				<tr style="height:50px;">
					<td style="text-align:center;width:50%;">Pembeli</td>
					<td style="text-align:center;">Hormat Kami,<br><?= $r_office['office_name']?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td style="text-align:center;width:50%;">
						<?= $r_purchases_supplier['supplier_name'] ? $r_purchases_supplier['supplier_name'] : "................."?></td>
					<td style="text-align:center;"><?= $user_name?></td>
				</tr>
			</table>
			<div class="row">
				<!-- <a href="#" class="hidden-print"><button class="back_to_order" onclick="send_email()"><label>Email</label></button></a> -->
				<a href="pdf.php?page=pembelian&id=<?= $r_purchases['purchase_id']?>" class="hidden-print">
					<button class="btn btn-primary"><label>Save Pdf</label></button>
				</a>
				<a href="purchase.php" class="hidden-print">
					<button class="btn btn-danger"><label>Kembali</label></button>
				</a>
			</div>
	</center>
</body>
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
