<?php
include '../lib/config.php';
include '../lib/function.php';
include '../models/payment_model.php';
$page = null;
$page = (isset($_GET['page'])) ? $_GET['page'] : "list";
$title = ucwords("Pembayaran");

$_SESSION['table_active'] = 1;
$permit = get_akses_permits($_SESSION['user_type_id'],$_SESSION['sub_menu_active']);
switch ($page) {
	case 'list':

		$transaction_id = get_isset($_GET['transaction_id']);
		$query = select($transaction_id);
		$query2 = select($transaction_id);
		$transaction_code = get_transaction_code($transaction_id);
		$member_id = get_member_id($transaction_id;
	break;

	case 'save':

		extract($_POST);
		$i_name = get_isset($i_name);
		$data = "'',
					'$i_name'
			";
			//echo $data;
			create($data);
			header("Location: payment.php?page=list&did=1");


	break;

	case 'read_voucher':

		extract($_POST);
		$id = get_isset($id);
		$data_voucher = read_voucher($id);
		//echo $data_voucher['voucher_type_id']."-".$data_voucher['voucher_value'];
		$data['voucher_type_id'] = $data_voucher['voucher_type_id'];
		$data['voucher_value'] = $data_voucher['voucher_value'];
		echo json_encode($data);

	break;
	// case 'popmodal':
	// 	include '../views/payment/popmodal.php';
	// break;
	case 'hitungbulat':
		$totalkedua=ceil($_POST['price']);
		if (substr($totalkedua,-2)!=00){
			if(substr($totalkedua,-2)<50){
				$totalkedua=round($totalkedua,-2)+100;
			}else{
				$totalkedua=round($totalkedua,-2);
			}
		}
		echo $totalkedua;
	break;
}

?>
