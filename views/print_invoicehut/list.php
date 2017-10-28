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
<style type="text/css">
body{
	font-family:"Palatino Linotype", "Book Antiqua", Palatino, serif;
}
.frame{
	border:1px solid #000;
	width:10%;
	margin-left:auto;
	margin-right:auto;
	padding:10px;
}
table{
	font-size:14px;

}
.header{
	text-align:center;
	font-weight:bold;
	font-size:11px;

}
.header_img{

	width:164px;
	height:79px;
	margin-left:auto;
	margin-right:auto;
	margin-bottom:10px;
}

.back_to_order{
	width:10%;
	margin-left:auto;
	margin-right:auto;
	color:#fff;
	font-weight:bold;
	background:#09F;
	text-align:center;
	border-radius:10px;
	margin-top:10px;
	padding:5px;height:30px;
}
.back_to_order:hover{
	background:#069;
}
table#office_header td{
	width: 200px;
	text-align: center;
	font-size: 14px;
}
</style>
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
	<b>INVOICE PENGANGSURAN HUTANG</b>
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
<div style="clear:both;"></div>
<br>
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
			<th>Harga barang</th>
			<th>Total</th>
		</tr>
	</thead>
	<tbody>
	<?php
		$q_piut = mysql_query("SELECT a.*, b.*, c.*, d.*,e.*, f.*, g.unit_name FROM hutang a
													JOIN purchases b ON b.purchases_id = a.purchase_id
													JOIN purchases_details e ON e.purchase_id = a.purchase_id
													JOIN items c ON c.item_id = e.item_id
													JOIN suppliers d ON d.supplier_id = b.supplier_id
													JOIN pengangsuran_hut f ON f.id_hutang = a.id_hutang
													JOIN units g on g.unit_id = c.unit_id
													WHERE f.angsuran_date = '".$r_hutang['angsuran_date']."' AND b.lunas = 1");
		while ($r_hut = mysql_fetch_array($q_piut)) { ?>
		<tr>
			<td style="padding:10px;"><?= $r_hutang['item_name'] ?></td>
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
<style>
table#lintable2,
table#lintable2 th,
table#lintable2 td {
	border: none;
	border-collapse: collapse;
}
table#lintable2 th,
table#lintable2 td {
	border: 1px solid;
	text-align:center;
}
table#lintable2 td{
	padding: 5px;
}
</style>
Pembayaran hutang :
<br>
<br>
<table id="lintable2" style="width:50%;">
	<thead>
		<tr>
			<th style="width:50%;">Jumlah Angsuran</th>
			<th>Sisa hutang</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>Rp. <?= format_rupiah($r_hutang['jml_bayar']) ?>,00</td>
			<td>Rp. <?= format_rupiah($r_hutang['hutang']) ?>,00</td>
		</tr>
	</tbody>
</table>
<br>
<br>
<br>
<table style="margin-left:400px;padding-top:0;">
	<tr style="height:150px;">
		<td style="text-align:center;"><?= $r_office['office_name']?></td>
	</tr>
	<tr>
		<td style="text-align:center;">...............</td>
	</tr>
</table>
<div style="clear:both;"></div>
<a href="home.php" style="text-decoration:none"><div class="back_to_order"></div></a>
</body>
<script>
	function close_window() {
		window.close();
	}
</script>
