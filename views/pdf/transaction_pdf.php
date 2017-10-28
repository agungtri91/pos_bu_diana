<?php
require_once '../lib/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;
$dompdf = new Dompdf();
$html ='
<html>
<title>FAKTUR PENJUALAN</title>
<head>
	<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="../css/print/print.css" rel="stylesheet">
</head>';
$html .='
<body style="font-family:tahoma; font-size:8pt;">
	<center>
		<table style="width:100%; font-size:8pt; font-family:calibri; border-collapse: collapse;" border = "0">
			<tr>
				<td width="30%"" align="left" style="padding-right:80px; vertical-align:top">
					<span class="header">
						<b>FAKTUR PENJUALAN
							<br>
							 '.$r_office['office_name'].'
						</b>
					</span>
					</br>
					'.$r_office['office_address'].'
					</br>
					'.$r_office['office_phone'].'
				</td>
				<td style="vertical-align:top;" width="30%" align="left">
					PRINTED DATE&nbsp;&nbsp;: '.$r_invoice['transaction_date'].'<br>
					NO. NOTA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: '.$r_invoice['transaction_code'].'<br>
				</td>
				<td style="vertical-align:top;" width="30%" align="left">
					KEPADA&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:'.$r_member['member_name'].'<br>
					ALAMAT&nbsp;&nbsp;&nbsp;&nbsp;:'.$r_member['member_alamat'].'<br>
					KIRIM KE&nbsp;&nbsp;&nbsp;:'.$r_member['member_alamat'].'<br>
				</td>
			</tr>
		</table>
		<table id="lintable" cellspacing="0" style="width:100%; font-size:8pt; font-family:calibri;  border-collapse: collapse;">
			<tr align="center">
				<td width="5%">NO.</td>
				<td>KODE BARANG.</td>
				<td>NAMA BARANG</td>
				<td>JML</td>
				<td>JML. KONVERSI</td>
				<td>BERAT</td>
				<td>HARGA</td>
				<td>DISC ( % )</td>
				<td>DISC NOMINAL</td>
				<td>SUB TOTAL</td>
	   	</tr>
			<tbody style="border-bottom : 1px solid">';
			$no = 1;
			$total_berat = 0;
			$q_invo = get_detail_transaction($r_invoice['transaction_id']);
			while ($r_invo = mysql_fetch_array($q_invo)) {
	$html .='
				<tr>
					<td class="center no-border">'.$no.'</td>
					<td class="center no-border">'.$r_invo['kode_barang'].'</td>
					<td class="left no-border">'.$r_invo['item_name'].'</td>
					<td class="center no-border">'.$r_invo['transaction_detail_qty_real'].'('.$r_invo['unit_utama_name'].')</td>';
					$unit_id_utama = get_unit_id($r_invo['item_id']);
	$html .= '<td class="center no-border">'.konversi_total_jumlah($unit_id_utama, $r_invo['item_id'],$r_invo['transaction_detail_qty_real']
						,$r_invo['transaction_detail_unit']).'
					</td>
					<td class="center no-border">'.$r_invo['item_berat'].'</td>
					<td class="right no-border">'.format_rupiah($r_invo['transaction_detail_price']).'</td>
					<td class="center no-border">'.$r_invo['transaction_detail_persen_discount'].'</td>
					<td class="right no-border">'.$r_invo['transaction_detail_nominal_discount'].'</td>
					<td class="right no-border">'.format_rupiah($r_invo['transaction_detail_price']*$r_invo['transaction_detail_qty']).'</td>
				</tr>';
				$no++;
				$total_berat = $total_berat + $r_invo['item_berat'];
			}
$html .='</tbody>';
$bank_account = $r_invoice['i_bank_account'] ? $r_invoice['i_bank_account'] : "-";
$html .='
		<tfoot>
			<tr class="right no-border">
					<td class="no-border left" colspan="2">Tipe Pembayaran</td>
					<td class="no-border left" > : '.get_payment_method($r_invoice['payment_method_id']).'</td>
					<td class="no-border"></td>
					<td class="no-border"></td>
					<td class="no-border center">'.format_berat($total_berat).'</td>
					<td class="no-border"></td>
					<td class="no-border" colspan = "2">
						<div>Total Yang Harus Di Bayar Adalah : </div>
					</td>
					<td>'.format_rupiah($r_invoice['transaction_grand_total']).'</td>
			</tr>
			<tr class="right no-border">
				<td class="no-border left" colspan="2">Uang Muka</td>
				<td class="no-border left">: Rp.'.format_rupiah($r_invoice['transaction_payment']).',00</td>
				<td class="no-border left" colspan="5" rowspan="5">
					Catatan :
					'.$r_invoice['transaction_desc'].'
				</td>
				<td class="no-border">
					<div>Potongan : </div>
				</td>
				<td style="text-align:right">'.format_rupiah(get_total_discount($r_invoice['transaction_id'])).'</td>
			</tr>
			<tr>
				<td class="no-border left" colspan="2">Sisa</td>
				<td class="no-border left"> : Rp.'.format_rupiah($r_invoice['transaction_grand_total']-$r_invoice['transaction_payment']).',00</td>
				<td  class="no-border">
					<div>Bayar : </div>
				</td>
				<td style="text-align:right;">'.format_rupiah($r_invoice['transaction_payment']).'</td>
			</tr>
			<tr>
				<td class="no-border left" colspan = "2"></td>
				<td class="no-border left"></td>
				<td class="no-border">
					<div>Kembalian : </div>
				</td>
				<td style="text-align:right">'.format_rupiah($r_invoice['transaction_change']).'</td>
			</tr>
			<tr class="right no-border">
				<td class="no-border left" colspan="2">BANK Pembeli</td>
				<td class="no-border left"> : '.get_bank_name($r_invoice['bank_id']).'</td>
			</tr>
			<tr class="right no-border">
				<td class="no-border left" colspan="2">No. Rekening</td>
				<td class="no-border left"> : '.$bank_account.'</td>
			</tr>
		</tfoot>
	</table>';
$member_name = $r_member['member_name'] ? $r_member['member_name'] : ".................";
$html	.='<table style="width:100%;padding-top:0;font-size:10px;">
						<tr style="height:50px;">
							<td style="text-align:center;width:50%;">Pembeli</td>
							<td style="text-align:center;">Hormat Kami,<br>'.$r_office['office_name'].'</td>
						</tr>
						<tr style="height:50px;">
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr style="height:50px;">
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr style="height:50px;">
							<td>&nbsp;</td>
							<td>&nbsp;</td>
						</tr>
						<tr>
							<td style="text-align:center;width:50%;">
								'.$member_name.'</td>
							<td style="text-align:center;">'.$user_name.'</td>
						</tr>
					</table>
						';
$html .='
		</center>
	</body>
</html>';
$dompdf->loadHtml($html);
// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');
// Render the HTML as PDF
$dompdf->render();
$dompdf->set_base_path('../css/bootstrap.min.css');
$dompdf->set_base_path('../css/print/print.css');
// Output the generated PDF to Browser

$dompdf->stream("faktur_penjualan");

 ?>
