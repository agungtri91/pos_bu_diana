<?php
include '../lib/config.php';
include '../lib/function.php';
include '../models/print_model.php';
$page = null;
$page = (isset($_GET['page'])) ? $_GET['page'] : "list";
$title = ucwords("Pembayaran");

$_SESSION['table_active'] = 1;
$q_office = select_office();
$r_office = mysql_fetch_array($q_office);
$user_name = get_user_name($_SESSION['user_id']);
$q_office= select_office();
$r_office = mysql_fetch_array($q_office);
switch ($page) {
	case 'list':
	$transaction_id = get_isset($_GET['transaction_id']);
	$branch_id = get_isset($_GET['branch_id']);

	$q_member = select_member($transaction_id);
	$r_member = mysql_fetch_array($q_member);

	$query = select($transaction_id);
	$r_invoice = mysql_fetch_array($query);

	$query_item = select_item($transaction_id);
	$r_name = get_branch_name($branch_id);

	$q_piutang = select_piutang($transaction_id);
	$r_piutang=mysql_fetch_array($q_piutang);

	include '../views/pdf/transaction_pdf.php';
	break;

	case 'pembelian':
		$purchases_id = get_isset($_GET['id']);
		$query = select_purchases($purchases_id);
		$r_purchases = mysql_fetch_array($query);
		$query_tot = select_purchases_tot($purchases_id);
		$r_purchases_t = mysql_fetch_array($query_tot);
		$q_purchases_supplier = select_purchases_supplier($purchases_id);
	  $r_purchases_supplier = mysql_fetch_array($q_purchases_supplier);
		$q_hutang = select_hutang($purchases_id);
		$r_hutang = mysql_fetch_array($q_hutang);
		include '../views/pdf/purchase_pdf.php';
		break;

	case 'perjanjian_kredit':
		$transaction_id = $_GET['id'];
		$branch_id = $_GET['branch_id'];
		$where = "WHERE transaction_id = '$transaction_id'";
		$transaction_date = select_config_by('transactions', 'transaction_date', $where);
		$user_id = select_config_by('transactions', 'user_id', $where);
		$transaction_code = select_config_by('transactions', 'transaction_code', $where);
		$branch_id = select_config_by('transactions', 'branch_id', $where);
		$hari_ini = get_nama_hari($transaction_date);
		$bulan_ini = get_nama_bulan($transaction_date);
		$tahun_ini = get_tahun($transaction_date);
		$where_user = "WHERE user_id = '$user_id'";
		$user_name = select_config_by('users', 'user_name', $where_user);
		$user_type_id = select_config_by('users', 'user_type_id', $where_user);
		$where_user_type = "WHERE user_type_id = '$user_type_id'";
		$user_type_name = select_config_by('user_types', 'user_type_name', $where_user_type);
		include '../views/pdf/perjanjian_kredit_pdf.php';
		break;

	case 'print_angsuran_piutang':
		$kredit_id = $_GET['id'];
		$where = "WHERE kredit_id = '$kredit_id'";
		$angsuran_kredit_id = select_config_by('angsuran_kredit', 'angsuran_kredit_id', $where);
		$q_angsuran_kredit = select_angsuran_kredit($kredit_id);
		$r_angsuran_kredit = mysql_fetch_array($q_angsuran_kredit);
		include '../views/pdf/angsuran_piutang.php';
		break;
}

?>
