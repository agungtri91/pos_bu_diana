<?php

date_default_timezone_set('Etc/UTC');

require '../lib/PHPmailer/PHPMailerAutoload.php';
$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 2;
$mail->Debugoutput = 'html';
$mail->Host = 'smtp.gmail.com';
$mail->Port = 465;
$mail->SMTPSecure = 'ssl';
$mail->SMTPAuth = true;
$mail->Username = "bumiberkatbahari@gmail.com";
$mail->Password = "sally0505";
$mail->setFrom('bumiberkatbahari@gmail.com', 'First Last');
$mail->addReplyTo('bumiberkatbahari@gmail.com', 'First Last');
$mail->addAddress($i_mail_to, '');
$mail->Subject = 'PHPMailer GMail SMTP test';
$mail->isHTML(true);
$mail->Body= '
<html>
	<head>
	<style>
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
		font-size: 20px;
	}
	table#lintable th{
		text-align: center;
	}
	.btn_row{
		margin-left:auto;
		margin-right:auto;
	}

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
	table#lintable th{
		text-align: center;
	}
	</style>

	</head>
					<body>
					<div class="header" style="float:left;">
					<table id="office_header">
  				<tr>
		  			<td>
		  				'.$r_office['office_name'].'
		  			</td>
		  		</tr>
		  		<tr>
		  			<td style="font-size:15px;">
		  				'.$r_office['office_address'].'
		  			</td>
		  		</tr>
		  		<tr>
		  			<td style="font-size:10px;">
		  				'.$r_office['office_phone'].'
		  			</td>
		  		</tr>
		  	</table>
		  </div>
		  <br>
		  <br>
		  <div class="header" style="font-size:20px;">
		  	<div style="clear:both;"></div>
		  	<b>INVOICE PEMBELIAN</b>
		  </div>
		  <div class="header">
		  </div>
		  <br>
		  <table style="float:right;">
		  <tr>
		  	<td>
		  		<tr>
		  			<td>Tanggal</td><td>: '.$r_purchases['purchases_date'].'</td>
		  		</tr>
		  		<tr>
		  			<td>No</td><td>: '.$r_purchases['purchases_code'].'</td>
		  		</tr>
		  	</td>
		  </tr>
		</table>
		<table>
				<tr>
					<td>Cabang</td><td>: '.$r_purchases['branch_name'].'</td>
				</tr>
		</table>';
	if($r_purchases['supplier_id']!=0){
$mail->Body .='<table style="float:left;">
<tr>
  <td>
    <tr>
      <td>Nama</td><td>: '.$r_purchases_supplier['supplier_name'].'</td>
    </tr>
    <tr>
      <td>Alamat</td><td>: '.$r_purchases_supplier['supplier_addres'] ?>/Telp. : <?= $r_purchases_supplier  ['supplier_phone'].'</td>
    </tr>
  </td>
</tr>
<div style="clear:both;">
    <table id="lintable" style="width:100%;">
    	<thead>
    		<tr>
    			<th>Nama Barang</th>
    			<th>Jumlah</th>
          <th>Satuan</th>
    			<th>Harga barang</th>
    			<th>Total</th>
    		</tr>
    	</thead>
    	<tbody>
		';
	$mail->Body .='</div><br>
  <table id="lintable" style="width:100%;">
  	<thead>
  		<tr>
  			<th>Nama Barang</th>
  			<th>Qty</th>
  			<th>Satuan</th>
  			<th>Harga/Item</th>
  			<th>Jumlah	</th>
  		</tr>
  	</thead>
  	<tbody>';
	$total_berat = 0;
  $q_piut = mysql_query("SELECT a.*, b.*, c.unit_name, d.lunas FROM purchases_details a
                        JOIN items b ON b.item_id = a.item_id
                        left JOIN units c ON c.unit_id = b.unit_id
                        JOIN purchases d ON d.purchases_id = a.purchase_id
                        WHERE a.purchase_id = '".$r_purchases['purchases_id']."' AND d.lunas = 1");
  while ($r_purchase = mysql_fetch_array($q_piut)) {
	$mail->Body .= '<tr>
    <td style="padding:10px;"> '.$r_purchase['item_name'].'</td>
    <td style="padding:10px;text-align:center;">'.$r_purchase['unit_name'].'</td>
    <td style="padding:10px;text-align:center;">'.$r_purchase['purchase_qty'].'</td>
    <td style="padding:10px;text-align:center;">'.$r_purchase['purchase_price'].'</td>
    <td style="text-align:right; padding-right:12px;">'.format_rupiah($r_purchase['purchase_price']*$r_purchase['purchase_qty']).'</td>
  </tr>';
                }
	$mail->Body .= '<tr class="sub_table">
                  <td colspan="4" style="text-align:right; border:none; padding-right:55px;">Total</td>
                  <td border="1" style="text-align:right; padding-right:12px;">'.format_rupiah($r_purchases['purchase_total']).'</td>
                 </tr>';
	$q_payment_method=mysql_query("SELECT a.* FROM payment_methods a
																 JOIN transactions b on b.payment_method_id=a.payment_method_id
																 WHERE a.payment_method_id = '".$r_invoice['payment_method_id']."'");
	$mail->Body .='</table>';
  $query = mysql_query("SELECT * from hutang WHERE purchase_id = '".$r_purchases['purchases_id']."'");
  $r_hutang=mysql_fetch_array($query);
	$mail->Body .=	'<div style="clear:both;"></div>
  <table style="float:left;">
  <tr>
    <td>
      <tr>
        <td>Uang Muka</td><td>: Rp.'.format_rupiah($r_hutang['uang_muka']).',00</td>
      </tr>
      <tr>
        <td>Sisa / Hutang</td><td>: Rp.'.format_rupiah($r_hutang['hutang']).',00</td>
      </tr>
      <tr>
        <td>Batas Tanggal</td><td>: '.$r_hutang['batas_tanggal'].'</td>
      </tr>
    <tr>
        <td>Nb</td><td>: '.$r_purchases['purchase_desc'].'</td>
      </tr>
    </td>
  </tr>
  </table>';
		}
$mail->Body .='</tbody>';
$mail->Body .='</table>';
$mail->Body .='</body></html>';
	//$mail->msgHTML($body,$body2);
  if (!$mail->send()) {
      echo "Mailer Error: " . $mail->ErrorInfo;
  } else {
      // echo "Message sent!";
			header("Location:print.php?page=print_purchase&id=".$r_purchases['purchases_id']);
  }
	break;
 ?>
