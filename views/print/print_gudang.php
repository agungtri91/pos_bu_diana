<?php
/*
INVOICE PENJUALAN
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
	margin-top: 0px;
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
<body  onload=print()>
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
<div class="header" style="font-size:20px;">
	<div style="clear:both;"></div>
	<b>INVOICE PENGIRIMAN BARANG</b>
</div>
<div class="header">
</div>
<br>
<table style="float:right;">
  <?php $r_mutasi = mysql_fetch_array($q_mutasi); ?>
  <tr>
    <td>Tanggal : </td><td><?= format_date_only($r_mutasi['mutasi_date'] )?></td>
  </tr>
	<tr>
    <td>Tanggal : </td><td><?= $r_mutasi['mutasi_code']?></td>
  </tr>
</table>
<div style="clear:both;"></div>
<?php if ($r_mutasi['kirim_status']==2 ) {?>
  <table style="float:left;">
    <?php $r_gudang_asal = mysql_fetch_array($q_gudang_asal) ?>
    <tr>
      <td>Gudang asal  : </td><td><?= $r_gudang_asal['gudang_name']?></td>
    </tr>
    <?php $r_gudang_tujuan = mysql_fetch_array($q_gudang_tujuan) ?>
    <tr>
      <td>Gudang tujuan  : </td><td><?= $r_gudang_tujuan['gudang_name']?></td>
    </tr>
  </table>
<?} else {?>
  <table style="float:left;">
    <?php $r_gudang_asal = mysql_fetch_array($q_gudang_asal) ?>
    <tr>
      <td>Gudang asal  : </td><td><?= $r_gudang_asal['gudang_name']?></td>
    </tr>
    <?php $r_cabang_tujuan = mysql_fetch_array($q_cabang_tujuan) ?>
    <tr>
      <td>Cabang tujuan  : </td><td><?= $r_cabang_tujuan['branch_name']?></td>
    </tr>
  </table>
<?}?>

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
			<th>Jumlah</th>
		</tr>
	</thead>
  <tbody>
    <?php
      while ($r_mutasi_details = mysql_fetch_array($q_mutasi_details)) {?>
        <tr>
    			<td style="padding:10px;"><?= $r_mutasi_details['item_name'] ?></td>
					<td style="padding:10px;text-align:center;"><?= $r_mutasi_details['item_qty'] ?></td>
    			<!-- <td style="padding:10px;text-align:center;"><?= $r_mutasi_details['unit_name'] ?></td> -->
    		</tr>
      <?}
     ?>
  </tbody>
</table>
<br>
<br>
<br>
<table style="width:100%;padding-top:0;padding-left:400px;">
	<tr style="height:150px;">
		<td style="text-align:center;"><?= $r_office['office_name']?></td>
	</tr>
	<tr>
		<td style="text-align:center;">.................</td>
	</tr>
</table>
<div style="clear:both;"></div>
<a href="home.php" style="text-decoration:none"><div class="back_to_order"></div></a>
</body>
<script>
	// function close_window() {
	// 	window.close();
	// }
</script>
