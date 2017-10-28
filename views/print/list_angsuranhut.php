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
<body  onload=print() style="width:100%;">
<!--<body>-->
<?php
	$query=mysql_query("SELECT * FROM office");
	$r_office = mysql_fetch_array($query);
 ?>
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
<div class="header" style="font-size:30px;">
	<div style="clear:both;"></div>
	<!-- <b>INVOICE PENGANGSURAN HUTANG</b> -->
</div>
<div class="header"></div>
<br>
<table style="float:right;">
<tr>
	<td>
		<tr>
			<td>Tanggal</td><td>: <?= $r_hutang['angsuran_date'] ?></td>
		</tr>
		<tr>
			<td>No. Invoice Hutang</td><td>: <?= $r_hutang['purchases_code'] ?></td>
		</tr>
	</td>
</tr>
</table>
<!-- <div style="clear:both;"></div> -->
<table style="float:left;">
<tr>
	<td>
		<tr>
			<td>Nama</td><td>: <?= $r_hutang['supplier_name'] ?></td>
		</tr>
		<tr>
			<td>Telp.</td><td>: <?= $r_hutang['supplier_phone'] ?></td>
		</tr>
		<tr>
			<td>Alamat</td><td>: <?= $r_hutang['supplier_addres'] ?></td>
		</tr>
		<tr>
			<td>E-mail</td><td>: <?= $r_hutang['supplier_email'] ?></td>
		</tr>
	</td>
</tr>
</table>
<table id="lintable" style="width:100%;">
	<thead>
		<tr>
			<th>Nama Barang</th>
			<th>Satuan</th>
			<th>Jumlah</th>
			<th>Harga barang</th>
			<th>Total</th>
		</tr>
	</thead>
	<tbody>
	<?php
		while ($r_hut = mysql_fetch_array($q_piut)) { ?>
		<tr>
			<td style="padding:10px;"><?= $r_hut['item_name'] ?></td>
			<td style="padding:10px;text-align:center;"><?= $r_hut['unit_name'] ?></td>
			<td style="padding:10px;text-align:center;"><?= $r_hut['purchase_qty'] ?></td>
			<td style="padding:10px;text-align:center;"><?= format_rupiah($r_hut['purchase_price']) ?></td>
			<td style="text-align:right; padding-right:12px;"><?= format_rupiah($r_hut['purchase_price']*$r_hut['purchase_qty']) ?></td>
		</tr>
	<?php } ?>
		<!-- <tr class="sub_table">
			<td colspan="4" style="text-align:right; border:none; padding-right:55px;">Sub Total</td>
			<td border="1" style="text-align:right; padding-right:12px;"><?= $r_hutang['jml_bayar']?></td>
		</tr> -->
	</tbody>
</table>
<br>
Pembayaran hutang :
<br>
<br>
<table>
	<tbody>
		<tr>
			<td>Jumlah Angsuran</td><td> : Rp. <?= format_rupiah($r_hutang['jml_bayar']) ?>,00</td>
		</tr>
			<?php
			 			$query=mysql_query("SELECT hutang from hutang  where purchase_id = '".$purchase_id."'");
						$r_query=mysql_fetch_array($query);
						if($r_query['hutang']==0){?>
						<tr>
							<td>Sisa hutang</td><td>: LUNAS</td>
						</tr>
						<? } else { ?>
						<tr>
							<td>Sisa hutang</td><td>: Rp. <?= format_rupiah($r_query['hutang']) ?>,00</td>
						</tr>
						<? }?>
		<tr>
			<td>Tipe Pembayaran</td><td>: <?= $get_payment_method ?></td>
		</tr>
		<?php if($r_hutang['payment_method']>1){?>
			<tr>
				<td>Dari Bank</td><td> : <?= $get_bank_name?> // <?=$r_hutang['no_bank_id_1']?></td>
			</tr>
			<tr>
				<td>Menuju Bank</td><td>: <?= $get_bank_name_to?> // <?=$r_hutang['no_bank_id_2'] ?></td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<table style="width:100%;padding-top:0;">
	<tr style="height:150px;">
		<td style="text-align:center;width:50%;">Pembeli</td>
		<td style="text-align:center;">Hormat Kami,<br><?= $r_office['office_name']?></td>
	</tr>
	<tr>
		<td style="text-align:center;width:50%;"><?= $r_hutang['supplier_name']  ? $r_hutang['supplier_name'] : "................."?></td>
		<td style="text-align:center;"><?= $user_name?></td>
	</tr>
</table>
<center>
	<div class="row">
		<a href="home.php" class=" hidden-print" style="text-decoration:none">
			<button type="button" class="btn btn-primary" name="button">Kembali</button>
		</a>
	</div>
</center>
<script>
	function close_window() {
		window.close();
	}
</script>
