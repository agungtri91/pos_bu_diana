<?php
require_once '../lib/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;
$dompdf = new Dompdf();

$html= '
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
      <div class="header" style="font-size:30px;">
      	<div style="clear:both;"></div>
      	<b>INVOICE PEMBELIAN</b>
      </div>
      <div class="header"></div>
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
	if($r_purchases_supplier['supplier_id']!=0){
    $html .='<table style="float:left;">
    <tr>
    	<td>
    		<tr>
    			<td>Nama</td><td>: '.$r_purchases_supplier['supplier_name'].'</td>
    		</tr>
    		<tr>
    			<td>Alamat</td><td>: '.$r_purchases_supplier['supplier_addres'].'/Telp. : '.$r_purchases_supplier['supplier_phone'].'</td>
    		</tr>
    		<!-- <tr>
    			<td>E-mail.</td><td>: '.$r_purchases_supplier['supplier_email'].'</td>
    		</tr> -->
    	</td>
    </tr>
    </table>
    <div style="clear:both;"></div>
		';
  }
  $html .='<table id="lintable" style="width:100%;" style="float:right;">
  	<thead>
  		<tr>
  			<th>Nama Barang</th>
  			<th>Jumlah</th>
  			<th>Harga barang</th>
  			<th>Total</th>
  		</tr>
  	</thead>
  	<tbody>';
  $q_purchase = get_purchase_hut($r_purchases['purchase_id']);
  while ($r_purchase = mysql_fetch_array($q_purchase)) {
	$html .='
  <tr>
    <td style="padding:10px;"> '.$r_purchase['item_name'].'</td>
    <td style="padding:10px;text-align:center;">'.$r_purchase['purchase_qty'].'</td>
    <td style="padding:10px;text-align:center;"> '.format_rupiah($r_purchase['purchase_price']).'</td>
    <td style="text-align:right; padding-right:12px;">'.format_rupiah($r_purchase['purchase_price']*$r_purchase['purchase_qty']).'</td>
  </tr>';}
	$html .= '<tr class="sub_table">
										<td colspan="3" style="text-align:right; border:none; padding-right:55px;">Total</td>
										<td border="1" style="text-align:right; padding-right:12px;">'.format_rupiah($r_purchases_t['purchase_total']).'</td>
									</tr>
									<tr class="sub_table">
										<td colspan="3" style="text-align:right; border:none; padding-right:55px;">Bayar</td>
										<td border="1" style="text-align:right; padding-right:12px;">'.format_rupiah($r_purchases_t['purchase_payment']).'</td>
									</tr>';
                  $q_payment_method=mysql_query("SELECT a.*,b.* FROM payment_methods a
                  																		 JOIN purchases b on b.payment_method=a.payment_method_id
                  																		 WHERE a.payment_method_id = '".$r_purchases['payment_method']."'");
                  			$r_payment_method = mysql_fetch_array($q_payment_method);

                  	$q_bank=mysql_query("select * from banks WHERE bank_id = '".$r_purchases['bank_id']."'");
                  	$r_bank=mysql_fetch_array($q_bank);
                  	$q_bank_to=mysql_query("select * from banks WHERE bank_id = '".$r_purchases['bank_id_to']."'");
                  	$r_bank_to=mysql_fetch_array($q_bank_to);
	$html .='</table>';
	$html .=	'<div style="clear:both;"></div>
		<table style="float:left;">
			<tr>
				<td>
					Tipe Pembayaran
				</td>
				<td>
					:'.$r_payment_method['payment_method_name'].'
				</td>
			</tr>';
			if ($r_purchases['payment_method']>1){
		$html .='<tr>
				<td>
					Dari Bank
				</td>
				<td>
					:'.$r_bank['bank_name']?>//<?= $r_purchases['i_bank_account'].'
				</td>
			</tr>
			<tr>
				<td>
					Menuju Bank
				</td>
				<td>
					:'.$r_bank_to['bank_name']?>//<?= $r_purchases['i_bank_account_to'].'
				</td>
			</tr>';
		}
	$html .='<tr>
				<td> Nb </td><td>: '.$r_purchases['purchase_desc'].'</td>
			</tr>
		</table>';

$html .='</tbody>';
$html .='</table>';
$html .='</body></html>';
$dompdf->loadHtml($html);
// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();

 ?>
