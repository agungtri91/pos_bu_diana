<?php
include '../lib/config.php';
include '../lib/function.php';
include '../models/member_model.php';
$page = null;
$page = (isset($_GET['page'])) ? $_GET['page'] : "list";
$title = ucwords("DETAIL CUSTOMER");

$_SESSION['menu_active'] = 1;
$_SESSION['sub_menu_active'] = 17;
$permit = get_akses_permits($_SESSION['user_type_id'],$_SESSION['sub_menu_active']);
switch ($page) {
	case 'list':
		get_header($title);
		$query = select_pembeli_detail();
		$add_button = "member.php?page=form";
		include '../views/member/list.php';
		get_footer();
	break;

	case 'form':
		get_header();
		$member_id = (isset($_GET['id'])) ? $_GET['id'] : null;
		$q_tipe_pembeli = select_config('type_pembeli', '');
		if ($member_id) {
			$where_member_id = "WHERE member_id = '$member_id'";
			$row = select_object_config('members', $where_member_id);
			$action = "member.php?page=edit&id=$member_id";
		} else {
			$row = new stdClass();
			$row->member_name 		= false;
			$row->member_phone 		= false;
			$row->member_alamat 	= false;
			$row->member_discount = false;
			$row->member_discount = false;
			$row->member_email = false;
			$row->tipe_pembeli 		= false;
			$action = "member.php?page=save";
		}
		$close_button = "member.php?page=list";
		include '../views/member/form.php';
		get_footer();
	break;

	case 'save':
		$member_name 		= $_POST['member_name'];
		$member_phone 	= $_POST['member_phone'];
		$member_alamat 	= $_POST['member_alamat'];
		$member_email 	= $_POST['member_email'];
		$tipe_pembeli 	= $_POST['tipe_pembeli'];

		$data = "'',
						 '$member_name',
						 '$member_phone',
						 '$member_email',
						 '$member_alamat',
						 '',
						 '$tipe_pembeli'
						 ";
		create_config('members', $data);
		header('Location: member.php?page=list&did=1');
		break;

	case 'edit':
		extract($_POST);

		$member_id 			= $_GET['id'];
		$member_name 		= $_POST['member_name'];
		$member_phone 	= $_POST['member_phone'];
		$member_alamat 	= $_POST['member_alamat'];
		$member_email 	= $_POST['member_email'];
		$tipe_pembeli 	= $_POST['tipe_pembeli'];
		$data = "member_name 		= '$member_name',
						 member_phone 	= '$member_phone',
						 member_email 	= '$member_email',
						 member_alamat	=	'$member_alamat',
						 tipe_pembeli 	= '$tipe_pembeli'
							";
		$where_member_id = "member_id = '$member_id'";
		update_config2('members', $data, $where_member_id);
		header('Location: member.php?page=list&did=2');
		break;

	case 'delete':
		$id = get_isset($_GET['id']);
		$where = "member_id = '$id'";
		delete_config('members', $where);
		unset($_SESSION['member_id']);
		header('Location: member.php?page=list&did=3');

	break;

	case 'select2_get_data':
	$type_item = $_POST['x'];
	$member_id = $_POST['id'];
	$q_type_pembeli2 = select_type_member();
	while ($r_type_pembeli = mysql_fetch_array($q_type_pembeli2)) {
		$data[] = array('type_id_pembeli' => $r_type_pembeli['type_id_pembeli'],
										'type_pembeli_name' => $r_type_pembeli['type_pembeli_name']);
	};
		$q_type_diskon = select_type_diskon2($type_item,$member_id);
			while ($r_type_diskon = mysql_fetch_array($q_type_diskon)) {
				$data2[] = array(
					'type_item' => $r_type_diskon['type_item'],
					'diskon' => $r_type_diskon['diskon']
				);
			}
			echo json_encode(array($data,$data2));
		break;

	case 'history_member_popmodal':
		$transaction_code = $_GET['code'];
		$where_transaction_code = "WHERE transaction_code = '$transaction_code'";
		$q_transaction = select_config('transactions', $where_transaction_code);
		$r_transaction = mysql_fetch_array($q_transaction);
		$transaction_id = select_config_by('transactions', 'transaction_id', $where_transaction_code);
		$where_transaction_id = "WHERE transaction_id = '$transaction_id'";
		$q_transaction_detail = select_transaction_detail($transaction_id);

		$member_id = select_config_by('transactions', 'member_id', $where_transaction_code);
		$where_member_id = "WHERE member_id = '$member_id'";
		$member_name = select_config_by('members', 'member_name', $where_member_id);

		$payment_method_id 	=	select_config_by('transactions', 'payment_method_id', $where_transaction_code);
		$where_payment_method_id 	= "WHERE payment_method_id = '$payment_method_id'";
		$payment_method_name 			= select_config_by('payment_methods','payment_method_name', $where_payment_method_id);

		$where_transaction_id = "WHERE transaction_id = $transaction_id";
		$q_kredit = select_config('kredit' , $where_transaction_id);
		$r_kredit = mysql_fetch_array($q_kredit);

		$kredit_id = select_config_by('kredit', 'kredit_id', $where_transaction_id);
		include '../views/member/history_member_popmodal.php';
		break;

// 8-2-2017
case 'history_member':
	get_header();
	$member_id = $_GET['id'];
	$where_member_id = "WHERE member_id = '$member_id'";
	$member_name = select_config_by('members', 'member_name', $where_member_id);
	$query = select_transactions_and_kredit($member_id);
	include '../views/member/history_member.php';
	get_footer();
	break;

}
?>
