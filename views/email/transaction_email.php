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
		  	<b>INVOICE PENJUALAN</b>
		  </div>
		  <div class="header">
		  </div>
		  <br>
		  <table style="float:right;">
		  <tr>
		  	<td>
		  		<tr>
		  			<td>Tanggal</td><td>: '.$r_invoice['transaction_date'].'</td>
		  		</tr>
		  		<tr>
		  			<td>No</td><td>: '.$r_invoice['transaction_code'].'</td>
		  		</tr>
		  	</td>
		  </tr>
		</table>
		<table>
			<tr>
				<td style="font-size:20px;">Cabang</td><td>: '.$r_invoice['branch_name'].'</td>
			</tr>
		</table>';
	if($r_member['member_id']!=0){
$mail->Body .='<table style="float:left;">
	  <tr>
	  	<td>
	  		<tr>
	  			<td>Nama</td><td>: '.$r_member['member_name'].'</td>
	  		</tr>
	  		<tr>
	  			<td>Alamat</td><td>:'.$r_member['member_alamat'].'/'.$r_member['member_phone'].'</td>
	  		</tr>
	  	</td>
	  </tr>
		';
	$query_diskon = mysql_query("SELECT b.*, c.item_name, c.item_type, a.member_id,f.unit_name
  														FROM transaction_details b
  														JOIN transactions a ON a.transaction_id = b.transaction_id
  														JOIN items c ON c.item_id = b.item_id
  														left JOIN item_harga d ON d.item_id = b.item_id
  														LEFT JOIN members e ON e.member_id = a.member_id
  														left JOIN units f ON f.unit_id = c.unit_id
  														WHERE b.transaction_id = '".$r_invoice['transaction_id']."' group by b.item_id");
	while ($r_member_diskon= mysql_fetch_assoc($query_diskon)){
	  		$q_diskon_member = mysql_query("SELECT a.*,b.* from type_diskon_pembeli a
	  																		JOIN items_types b on b.item_type_id = a.type_item
	  																		where member_id = '".$r_member_diskon['member_id']."' and type_item = '".$r_member_diskon['item_type']."'");
	while ($r_diskon_member = mysql_fetch_assoc($q_diskon_member)){
	$mail->Body .='<tr>
				  				<td colspan="2" width="50%">Diskon ('.$r_diskon_member['diskon'].'%) Tipe item <label>'.$r_diskon_member['item_type_name'].'</label></td>
				  			 </tr>
			  				<tr>
			  					<td colspan="3" style="text-align:right; font-size:20px;" ></td>
			  				</tr>';
				}
			}
		}
	$mail->Body .='<div style="clear:both;"></div><br>
  <table id="lintable" style="width:100%;">
  	<thead>
  		<tr>
				<th>Nama Barang</th>
				<th>Qty</th>
				<th>Satuan</th>
				<th>Jumlah Zak</th>
				<th>Harga/Item</th>
				<th>Jumlah	</th>
  		</tr>
  	</thead>
  	<tbody>';
	$total_berat = 0;
	$q_invo = get_detail_transaction($r_invoice['transaction_id']);
	while ($r_invo = mysql_fetch_array($q_invo)) {
	$mail->Body .= '<tr>
										<td style="padding:10px;">'.($r_invo['item_name']).'</td>
										<td style="padding:10px;text-align:center;">'.$r_invo['transaction_detail_qty'].'</td>
										<td style="padding:10px;text-align:center;">'.$r_invo['unit_name'].'</td>
										<td style="padding:10px;text-align:center;">'.$r_invo['zak'].'</td>
										<td style="padding:10px;text-align:center;">'.format_rupiah($r_invo['item_price']).'</td>
										<td style="text-align:right; padding-right:12px;">'.format_rupiah($r_invo['item_price']*$r_invo['transaction_detail_qty']).'</td>
									</tr>';
			$total_berat=$total_berat+$r_invo['item_berat']*$r_invo['transaction_detail_qty'];}
	$mail->Body .= '<tr>
				<td colspan="5" style="text-align:right; border:none; padding-right:55px;">Total</td>
				<td border="1" style="text-align:right; padding-right:12px;">'.format_rupiah($r_invoice['transaction_grand_total']).'</td>
			</tr>
			<tr>
				<td colspan="5" style="text-align:right; border:none; padding-right:55px;">Bayar</td>
				<td border="1" style="text-align:right; padding-right:12px;">'.format_rupiah($r_invoice['transaction_payment']).'</td>
			</tr>';
	$q_payment_method=mysql_query("SELECT a.* FROM payment_methods a
																 JOIN transactions b on b.payment_method_id=a.payment_method_id
																 WHERE a.payment_method_id = '".$r_invoice['payment_method_id']."'");
	$r_payment_method = mysql_fetch_array($q_payment_method);
	$q_bank=mysql_query("select * from banks WHERE bank_id = '".$r_invoice['bank_id']."'");
	$r_bank=mysql_fetch_array($q_bank);
	$q_bank_to=mysql_query("select * from banks WHERE bank_id = '".$r_invoice['bank_id_to']."'");
	$r_bank_to=mysql_fetch_array($q_bank_to);
	$mail->Body .='</table>';
	$mail->Body .=	'<div style="clear:both;"></div>
		<table style="float:left;">
			<tr>
				<td>
					Tipe Pembayaran
				</td>
				<td>
					:'.$r_payment_method['payment_method_name'].'
				</td>
			</tr>';
			if ($r_invoice['payment_method_id']>1){
		$mail->Body .='<tr>
				<td>
					Dari Bank
				</td>
				<td>
					:'.$r_bank['bank_name']?>//<?= $r_invoice['i_bank_account'].'
				</td>
			</tr>
			<tr>
				<td>
					Menuju Bank
				</td>
				<td>
					:'.$r_bank_to['bank_name']?>//<?= $r_invoice['i_bank_account_to'].'
				</td>
			</tr>';
		}
	$mail->Body .='<tr>
				<td> Nb </td><td>: '.$r_invoice['transaction_desc'].'</td>
			</tr>
		</table>';

$mail->Body .='</tbody>';
$mail->Body .='</table>';
$mail->Body .='</body></html>';
	//$mail->msgHTML($body,$body2);
  if (!$mail->send()) {
      echo "Mailer Error: " . $mail->ErrorInfo;
  } else {
      // echo "Message sent!";
			header("Location:print.php?transaction_id=$transaction_id");
  }
	break;
 ?>
