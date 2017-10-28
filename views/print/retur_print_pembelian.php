<?php
/*
$outprint = "Just the test printer";
$printer = printer_open("58 Printer(1)");
printer_set_option($printer, PRINTER_MODE, "RAW");
printer_start_doc($printer, "Tes Printer");
printer_start_page($printer);
printer_write($printer, $outprint);
printer_end_page($printer);
printer_end_doc($printer);
printer_close($printer);
*/
?>
<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="../css/print/print.css" rel="stylesheet">
<body  onload=print()>
<!--<body>-->
	<div class="header" style="float:left;">
	<table id="office_header">
		<tr>
			<td>
				<?= $r_office['office_name']?>
			</td>
		</tr>
		<tr>
			<td style="font-size:10px;">
				<?= $r_office['office_address']?>
			</td>
		</tr>
		<tr>
			<td style="font-size:8px;">
				<?= $r_office['office_phone']?>
			</td>
		</tr>
		<!-- <tr>
			<td style="font-size:11px;">
				<?= $r_office['office_city']?>
			</td>
		</tr> -->
	</table>
</div>
<br>
<br>
<div class="header" style="font-size:20px;">
	<div style="clear:both;"></div>
	<b>RETUR INVOICE PEMBELIAN</b>
</div>
<div class="header">
</div>
<br>
<table style="float:right;">
<tr>
	<td>
		<tr>
			<td>Tanggal Transaksi</td><td>: <?= format_date_only($r_retur_pembelian['purchase_date']) ?></td>
		</tr>
		<tr>
			<td>Tanggal Retur</td><td>: <?= format_date_only($r_retur_pembelian['retur_date']) ?></td>
		</tr>
		<tr>
			<td>No</td><td>: <?= $r_retur_pembelian['purchases_code'] ?></td>
		</tr>
	</td>
</tr>
</table>
<?php if($r_supplier['supplier_id']!=0){?>
<table style="float:left;">
<tr>
	<td>
		<tr>
			<td>Nama</td><td>: <?= $r_supplier['supplier_name'] ?></td>
		</tr>
		<tr>
			<td>Alamat</td><td>: <?= $r_supplier['supplier_addres'] ?></td>
		</tr>
		<tr>
			<td>Telp.</td><td>: <?= $r_supplier['supplier_phone'] ?></td>
		</tr>
		<tr><td>Ket.</td>
			<?php if ($r_supplier['lunas']==1) {?>
				<td> : Belum Lunas</td>
			<?}elseif ($r_supplier['lunas']==2) {?>
				<td> : Sudah Lunas</td>
			<?}else {?>
				<td> : Lunas</td>
			<?} ?>

		</tr>
	</td>
</tr>
</table>
<?php } ?>
<div style="clear:both;"></div><br>
<style>
table#lintable,
table#lintable th,
table#lintable td {
	border: none;
	border-collapse: collapse;
}
table#lintable th,
table#lintable td {
	border: 1px solid;
}
</style>
<table id="lintable" style="width:100%;">
	<thead>
		<tr>
			<th>Nama Barang</th>
			<th>Satuan</th>
			<th>Jumlah</th>
			<th>Diskripsi</th>
			<th>Harga barang</th>
			<th>Total</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$q_invo = mysql_query("SELECT a.*, b.*, c.item_name, d.unit_name FROM retur_pembelian a
		 											 JOIN retur_pembelian_details b on b.retur_id = a.retur_id
													 JOIN items c on c.item_id = b.item_id
													 JOIN units d on d.unit_id = c.unit_id
													 WHERE a.retur_id = ".$retur_id);
		while ($r_invo_retur = mysql_fetch_array($q_invo)) { ?>
		<tr>
			<td style="padding:10px;"><?= $r_invo_retur['item_name'] ?></td>
			<td style="padding:10px;text-align:center;"><?= $r_invo_retur['unit_name'] ?></td>
			<td style="padding:10px;text-align:center;"><?= $r_invo_retur['item_qty'] ?></td>
			<td style="padding:10px;text-align:center;"><?= $r_invo_retur['retur_desc'] ?></td>
			<td style="padding:10px;text-align:center;"><?= format_rupiah($r_invo_retur['item_price'])?></td>
			<td style="text-align:right; padding-right:12px;"><?= format_rupiah($r_invo_retur['item_qty']*$r_invo_retur['item_price'])?></td>
		</tr>
	<?php } ?>
	<?php if ($r_supplier['lunas']!=1) {?>
		<tr>
			<td colspan="5" style="text-align:right; border:none; padding-right:55px;">Total</td>
			<td border="1" style="text-align:right; padding-right:12px;"><?= format_rupiah($r_retur_pembelian['retur_total_price'])?> </td>
		</tr>
		<?}?>
	</tbody>
</table>

<?php $q_payment_method=mysql_query("SELECT a.* FROM payment_methods a WHERE payment_method_id = ".$r_retur_pembelian['payment_method']);
      $r_payment_method = mysql_fetch_array($q_payment_method);

			$q_bank=mysql_query("select * from banks WHERE bank_id = '".$r_retur_pembelian['bank_id_1']."'");
			$r_bank=mysql_fetch_array($q_bank);
			$q_bank_to=mysql_query("select * from banks WHERE bank_id = '".$r_retur_pembelian['bank_id_2']."'");
			$r_bank_to=mysql_fetch_array($q_bank_to);
?>
<table>
	<tr>
		<td>
			Tipe Pembayaran
		</td>
		<td>
			:<?= $r_payment_method['payment_method_name']?>
		</td>
	</tr>
	<?php if ($r_retur_pembelian['payment_method']>1){?>
	<tr>
		<td>
			Dari Bank
		</td>
		<td>
			:<?= $r_bank['bank_name']?>//<?= $r_invoice['i_bank_account']?>
		</td>
	</tr>
	<tr>
		<td>
			Menuju Bank
		</td>
		<td>
			:<?= $r_bank_to['bank_name']?>//<?= $r_invoice['i_bank_account_to']?>
		</td>
	</tr><?}?>
</table>
<br>
<br>
<table style="width:100%;padding-top:0;font-size:10px;">
	<tr style="height:50px;">
		<td style="text-align:center;width:50%;">Pembeli</td>
		<td style="text-align:center;">Hormat Kami,<br><?= $r_office['office_name']?></td>
	</tr>
	<tr>
		<td style="text-align:center;width:50%;">
			<?= $r_supplier['supplier_name'] ? $r_supplier['supplier_name'] : "................."?></td>
		<td style="text-align:center;"><?= $user_name?></td>
	</tr>
</table>
<div style="clear:both;"></div>
	<div class="row" style="text-align:center;">
		<!-- <a href="#" class="hidden-print"><button class="back_to_order"><label>Email</label></button></a> -->
		<!-- <a href="#" class="hidden-print"><button class="back_to_order" onclick="save_pdf()"><label>Save Pdf</label></button></a> -->
		<a href="retur_pembelian.php" class="hidden-print">
			<button class="btn btn-danger"><label>Kembali</label></button></a>

	</div>
</body>
<script>
	// function close_window() {
	// 	window.close();
	// }
</script>
