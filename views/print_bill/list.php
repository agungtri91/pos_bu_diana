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
</style>
<body  onload=print()>
<!--<body>-->

<div class="header">
<span style="font-size:14px;">Hong Li Huo Guo Cheng<br>
Resto </span><br>
Manyar Kertoarjo 45 Surabaya<br />
(031) 591 74 777

</div>

<!--<table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-top: 5;">
  <tr>
    <td>Meja: <?= $row['table_name']?></td>
    <td align="right" ><?= $row['transaction_date'] ?></td>
  </tr>
</table>-->

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding-top: 5;">
<?php
  $no_item = 1;
  $total_price = 0;
 $query1 = mysql_query("select a.*,b.*, c.menu_name
                from transactions_tmp a
                join transaction_tmp_details b on b.transaction_id = a.transaction_id
                join menus c on c.menu_id = b.menu_id
                where a.transaction_id = '".$transaction_id."' AND c.menu_price !=0");

  while($row_item = mysql_fetch_array($query1)){
 $count = count($row_item);
  ?>
  <tr>
    <td><?= $row_item['menu_name'] ?></td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td><?= $row_item['transaction_detail_qty']." x ".number_format($row_item['transaction_detail_price'])?></td>
    <td align="right"><?= number_format($row_item['transaction_detail_total'])?></td>
  </tr>
  <?php
 $no_item++;
 $total_price = $total_price + $row_item['transaction_detail_total'];
  }
	$totalawal  = $total_price;
	$svc	    = 5/100*$totalawal;
	$tax	    = 10/100*($totalawal+$svc);
	$totalkedua =	$totalawal+$svc+$tax;
	$totalkedua=ceil($totalkedua);
	if (substr($totalkedua,-2)!=00){
		if(substr($totalkedua,-2)<50){
			$totalkedua=round($totalkedua,-2)+100;
		}else{
			$totalkedua=round($totalkedua,-2);
		}
	}
 ?>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size:12px; padding-top: 5;">
	<tr>
		<td>Total</td>
		<td align="right"><?= number_format($totalawal)?></td>
	</tr>
	<tr>
		<td>Service Charge (5%)</td>
		<td align="right"><?= number_format($svc)?></td>
	</tr>
	<tr>
		<td>Tax (10%)</td>
		<td align="right"><?= number_format($tax)?></td>
	</tr>
	<tr>
		<td style="font-size:16px"><strong>Grand Total</strong></td>
		<td style="font-size:16px" align="right"><strong><?= number_format($totalkedua)?></strong></td>
	</tr>
</table>
<a href="javascript:close_window();" style="text-decoration:none"><div class="back_to_order"></div></a>
</body>
<script>
	function close_window() {
		window.close();
	}
</script>
