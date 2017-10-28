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
$html .='<table style="float:left;">
	  <tr>
	  	<td>
	  		<tr>
	  			<td>Nama</td><td>: '.$r_member['member_name'].'</td>
	  		</tr>
	  		<tr>
	  			<td>Alamat</td><td>:'.$r_member['member_alamat'].'/'.$r_member['member_phone'].'</td>
	  		</tr>
	  	</td>
	  </tr>s
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
	$html .='<tr>
				  				<td colspan="2" width="50%">Diskon ('.$r_diskon_member['diskon'].'%) Tipe item <label>'.$r_diskon_member['item_type_name'].'</label></td>
				  			 </tr>
			  				<tr>
			  					<td colspan="3" style="text-align:right; font-size:20px;" ></td>
			  				</tr>';
				}
			}
		}
	$html .='</div><br>
  <table id="lintable" style="width:100%;">
  	<thead>
  		<tr>
				<th>Nama Barang</th>
				<th>Qty</th>
				<th>Satuan</th>
				<th>Jumlah Zak</th>
				<th>Harga/Item</th>
				<th>Jumlah</th>
  		</tr>
  	</thead>
  	<tbody>';
	$total_berat = 0;
  $q_invo = mysql_query("SELECT a.*, b.*, c.*, d.unit_name, e.*, f.item_type_name, g.*
                          FROM transactions a
                          JOIN transaction_details b ON b.transaction_id = a.transaction_id
                          JOIN items c ON c.item_id = b.item_id
                          JOIN units d on d.unit_id = b.transaction_detail_unit
                          JOIN item_harga e on e.item_id = b.item_id
                          LEFT JOIN items_types f on f.item_type_id = c.item_type
                          LEFT join item_details g on g.item_id = b.item_id
                          WHERE a.transaction_id = '".$r_invoice['transaction_id']."' AND a.lunas = 1");
	while ($r_invo = mysql_fetch_array($q_invo)) {
	$html .= '<tr>
										<td style="padding:10px;">'.($r_invo['item_name']).'</td>
										<td style="padding:10px;text-align:center;">'.$r_invo['transaction_detail_qty'].'</td>
										<td style="padding:10px;text-align:center;">'.$r_invo['unit_name'].'</td>
										<td style="padding:10px;text-align:center;">'.$r_invo['zak'].'</td>
										<td style="padding:10px;text-align:center;">'.format_rupiah($r_invo['item_price']).'</td>
										<td style="text-align:right; padding-right:12px;">'.format_rupiah($r_invo['item_price']*$r_invo['transaction_detail_qty']).'</td>
									</tr>';
    }
	$html .= '<tr>
				<td colspan="4" style="text-align:right; border:none; padding-right:55px;">Total</td>
				<td border="1" style="text-align:right; padding-right:12px;">'.format_rupiah($r_invoice['transaction_grand_total']).'</td>
			</tr>
			<tr>
				<td colspan="4" style="text-align:right; border:none; padding-right:55px;">Bayar</td>
				<td border="1" style="text-align:right; padding-right:12px;">'.format_rupiah($r_invoice['transaction_payment']).'</td>
			</tr>';
  $q_hutang = mysql_query("SELECT * FROM piutang WHERE transaction_id = '".$r_invoice['transaction_id']."' ");
  $r_hutang=mysql_fetch_array($q_hutang);
	$html .='</table>';
	$html .=	'<table style="font-size:18px;">
  	<tr>
  		<td>Uang Muka </td><td>: Rp. '.format_rupiah($r_invoice['transaction_payment']).',00</td>
  	</tr>
  	<tr>
  		<td>Uang Sisa </td><td>: Rp. '.format_rupiah($r_invoice['transaction_grand_total']-$r_invoice['transaction_payment']).',00</td>
  	</tr>
  	<tr>
  		<td>Tgl. Terakhir </td>
  		<td>: <b>'.$r_hutang['tgl_batas'].'</b></td>
  	</tr>
  	<tr>
  		<td> Nb </td><td>: '.$r_invoice['transaction_desc'].'</td>
  	</tr>
  </table>';
$html .='</tbody>';
$html .='</table>';
$html .='</body></html>';
$dompdf->loadHtml($html);
// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream();

 ?>
