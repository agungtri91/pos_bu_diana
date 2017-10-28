<?php
include '../lib/config.php';
include '../lib/function.php';
include '../models/transaction_detail_model.php';
$page = null;
$page = (isset($_GET['page'])) ? $_GET['page'] : "list";
$title = ucfirst("Transaksi Detail");

$_SESSION['menu_active'] = 1;

switch ($page) {
	case 'list':
		get_header($title);

		$query = select();
		$add_button = "transaction_detail.php?page=form";

		include '../views/transaction_detail/list.php';
		get_footer();
	break;

	case 'form':
		get_header();

		$close_button = "transaction_detail.php?page=list";


		$id = (isset($_GET['id'])) ? $_GET['id'] : null;
		if($id){

			$row = read_id($id);
			$query_detail = select_detail($id);

			$action = "supplier.php?page=edit&id=$id";
		} else{

			//inisialisasi
			$row = new stdClass();

			$row->transaction_code = false;
			$row->transaction_date = false;
			$row->transaction_grand_total = false;

			$action = "supplier.php?page=save";
		}

		update($id);

		include '../views/transaction_detail/form.php';
		get_footer();
	break;

	case 'save':

		extract($_POST);

		$i_name = get_isset($i_name);
		$i_telp = get_isset($i_telp);
		$i_email = get_isset($i_email);
		$i_alamat = get_isset($i_alamat);

		$data = "'',
					'$i_name',
					'$i_telp',
					'$i_email',
					'$i_alamat'
			";

			//echo $data;

			create($data);

			header("Location: supplier.php?page=list&did=1");


	break;

}

?>
