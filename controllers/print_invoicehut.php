<?php
include '../lib/config.php';
include '../lib/function.php';
include '../models/print_invoicehut_model.php';
$page = null;
$page = (isset($_GET['page'])) ? $_GET['page'] : "list";
$title = ucwords("Bill");

$_SESSION['table_active'] = 1;
$permit = get_akses_permits($_SESSION['user_type_id'],$_SESSION['sub_menu_active']);
switch ($page) {
	case 'list':

		// $transaction_id = get_isset($_GET['transaction_id']);
		// $query = select($transaction_id);
		// $row = mysql_fetch_array($query);
		// create_transaction_bill($transaction_id);
    $id = $_GET['id_hutang'];
    $query = get_hutang($id);

		include '../views/print_invoicehut/list.php';

	break;




}

?>
