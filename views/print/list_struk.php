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

<?php
  $query=mysql_query("SELECT * FROM office");
  $r_office = mysql_fetch_array($query);
 ?>
<div class="header center">
  <span style="font-size:15px;">
    <?= $r_office['office_name']?><br>
    <?= $r_office['office_address']?><br>
    <?= $r_office['office_phone']?>
  </span>
</div>
<?php
	if($r_invoice['member_id']!=0){
		$query = mysql_query("select * from members where member_id = ".$r_invoice['member_id']);
		$rmember= mysql_fetch_array($query);?>
  <div class="form-group left" style="float:left;">
    Nama&nbsp;&nbsp;&nbsp;&nbsp;: <?= $rmember['member_name']?>
    <br>
    Alamat&nbsp;&nbsp;&nbsp;: <?= $rmember['member_alamat']?>
    <br>
    Tlp.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?= $rmember['member_phone']?>
  </div>
<?php } ?>
<div class="form-group left" style="float:right;">
  Id&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?= $r_invoice['transaction_code']?>
  <br>
  Tgl&nbsp;&nbsp;&nbsp;: <?= format_date_only($r_invoice['transaction_date'])?>
  <br>
  Tlp.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?= $rmember['member_phone']?>
</div>
<table id="lintable" width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-top: 5;font-size:12px;">
  <thead>
    <tr>
      <th>NO.</th>
      <th>JMl</th>
      <th>DESK</th>
      <th>POT. ( % )</th>
      <th>POT. NOMINAL</th>
      <th>S.TOT</th>
    </tr>
  </thead>
  <tbody>
  <?php
    $no = 1;
    $total_berat = 0;
    $q_invo = get_detail_transaction($r_invoice['transaction_id']);
    while ($r_invo = mysql_fetch_array($q_invo)) {
    $count = count($r_invo); ?>

  <tr>
    <td class="center no-border"><?= $no;?></td>
    <td class="no-border"><?= $r_invo['item_name'] ?></td>
    <td class="no-border"></td>
  </tr>
  <tr>
    <td class="no-border"></td>
    <td class="center no-border">
      <?= $r_invo['transaction_detail_qty']." ( ".$r_invo['unit_konversi_name']." ) x ".number_format($r_invo['transaction_detail_grand_price'])?>
    </td>
    <td class="center no-border"><?= $r_invo['transaction_detail_persen_discount']?></td>
    <td class="right no-border"><?= $r_invo['transaction_detail_nominal_discount']?></td>
    <td class="right no-border">
      <?= number_format($r_invo['transaction_detail_total'])?>
    </td>
  </tr>
<? $no++;} ?>
</tbody>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px; padding-top: 5;">
	<tr>
		<br>
		<td style="font-size:14px"><strong>Grand Total</strong></td>
		<td style="font-size:14px" align="right">
      <strong>
        Rp.<?= format_rupiah($r_invoice['transaction_grand_total'])?>,00
      </strong>
    </td>
	</tr>
	<tr>
		<td style="font-size:14px">Bayar</td>
		<td style="font-size:14px" align="right">
      Rp.<?= format_rupiah($r_invoice['transaction_payment'])?>,00
    </td>
	</tr>
	<tr>
		<td style="font-size:14px">Kembalian</td>
		<td style="font-size:14px" align="right">
      Rp.<?= format_rupiah($r_invoice['transaction_change'])?>,00
    </td>
	</tr>
</table>
<table width="100%" style="text-align:center; font-size:8px;">
	<tr>
		<td>
			Terima Kasih Telah Berbelanja di Toko Kami
		</td>
	</tr>
	<tr>
		<td>
MOHON MAAF<br>BARANG YANG SUDAH DIBELI<BR>TIDAK DAPAT DIKEMBALIKAN		</td>
	</tr>
</table>
<br>
<center>
  <div class="row">
    <!-- <a href="#" class="hidden-print"><button class="back_to_order" onclick="send_email()"><label>Email</label></button></a> -->
    <!-- <a href="pdf.php?page=list&transaction_id=<?= $r_invoice['transaction_id']?>" class="hidden-print">
      <button class="btn btn-primary"><label>Save Pdf</label></button>
    </a> -->
    <a href="transaction_new.php" class="hidden-print">
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
