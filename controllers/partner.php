<?php
include '../lib/config.php';
include '../lib/function.php';
include '../models/partner_model.php';
$page = null;
$page = (isset($_GET['page'])) ? $_GET['page'] : "list";
$title = ucwords("Partner");

$_SESSION['menu_active'] = 1;
$_SESSION['sub_menu_active'] = 43;
$permit = get_akses_permits($_SESSION['user_type_id'],$_SESSION['sub_menu_active']);

switch ($page) {
	case 'list':
		get_header($title);
		$where = "WHERE branch_id = '$s_cabang'";
		$query = select_config('partners', $where);
		$add_button = "partner.php?page=form";
		include '../views/partner/list.php';
		get_footer();
	break;

	case 'form':
		get_header();
		$close_button = "partner.php?page=list";
		$id = (isset($_GET['id'])) ? $_GET['id'] : null;
		if($id){
			$where = "WHERE partner_id = '$id'";
			$row = select_object_config('partners', $where);
			$action = "partner.php?page=edit&id=$id";
		} else{
			$row = new stdClass();
			$row->partner_name = false;
			$row->partner_alamat = false;
			$row->partner_phone = false;
			$row->partner_email = false;
			$row->partner_deskripsi = false;
			$action = "partner.php?page=save";
		}
		include '../views/partner/form.php';
		get_footer();
	break;

	case 'save':
		extract($_POST);
		$i_name = get_isset($i_name);
		$i_phone = get_isset($i_phone);
		$i_email = get_isset($i_email);
		$i_alamat = get_isset($i_alamat);
		$i_desk = get_isset($i_desk);
		$data = "'',
					'$i_name',
					'$i_phone',
					'$i_email',
					'$i_alamat',
					'$i_desk',
					'$s_cabang'
			";

			create_config('partners',$data);
			header("Location: partner.php?page=list&did=1");
			break;

	case 'edit':
		extract($_POST);
		$id = get_isset($_GET['id']);
		$i_name = get_isset($i_name);
		$i_phone = get_isset($i_phone);
		$i_email = get_isset($i_email);
		$i_alamat = get_isset($i_alamat);
		$i_desk = get_isset($i_desk);
					$data = " partner_name = '$i_name',
										partner_phone = '$i_phone',
										partner_alamat = '$i_alamat',
										partner_email = '$i_email',
										partner_deskripsi = '$i_desk'
					";
			update($data, $id);
			header('Location: partner.php?page=list&did=2');
			break;

	case 'delete':
		$id = get_isset($_GET['id']);
		delete($id);
		header('Location: partner.php?page=list&did=3');
		break;

	case 'form_partner_history':
		get_header();
		$partner_id = $_GET['id'];
		$where_partner_id = "WHERE partner_id = '$partner_id'";
		$partner_name = select_config_by('partners', 'partner_name', $where_partner_id);

		$q_partner_transaction = select_config('transactions', $where_partner_id);

		$close_button = "partner.php?page=list";
		include '../views/partner/form_partner_history.php';
		get_footer();
		break;
}

?>
