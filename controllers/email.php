<?php
date_default_timezone_set('Etc/UTC');
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
switch ($page) {
	case 'list':
	$transaction_id = get_isset($_GET['transaction_id']);
	$q_member = select_member($transaction_id);
	$r_member = mysql_fetch_array($q_member);
	$query = select($transaction_id);
	$r_invoice = mysql_fetch_array($query);
	$query_item = select_item($transaction_id);
  $i_mail_to = $_POST['i_mail_to'];
  var_dump($i_mail_to);
	$query=mysql_query("SELECT * FROM office");
	$r_office = mysql_fetch_array($query);
	if($r_invoice['payment_method_id']!=5){
		include '../views/email/transaction_email.php';
	}else {
		include '../views/email/transaction_piutang_email.php';
		// include '../views/email/email_penjualan_piutang.php';
	}
	case 'list_pembelian':
		$purchases_id = get_isset($_GET['purchase_id']);
		$query = select_purchases($purchases_id);
		$r_purchases = mysql_fetch_array($query);
		$query_tot = select_purchases_tot($purchases_id);
		$r_purchases_t = mysql_fetch_array($query_tot);
		$q_purchases_supplier = select_supplier($purchases_id);
		$r_purchases_supplier = mysql_fetch_array($q_purchases_supplier);
		$i_mail_to = $_POST['i_mail_to'];
		if($r_purchases['payment_method']!=5){
			include '../views/email/purchase_email.php';
		}else {
			include '../views/email/purchase_hutang_email.php';
			// include '../views/email/email_penjualan_piutang.php';
		}
		break;
}

 ?>
