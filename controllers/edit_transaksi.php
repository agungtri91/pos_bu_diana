<?php
include '../lib/config.php';
include '../lib/function.php';
include '../models/edit_transaksi_model.php';
$page = null;
$page = (isset($_GET['page'])) ? $_GET['page'] : "list";
$title = ucfirst("EDIT TRANSAKSI");
$_SESSION['menu_active'] = 1;
$permit = get_akses_permits($_SESSION['user_type_id'],$_SESSION['sub_menu_active']);
switch ($page) {
  case 'list':
    get_header();
    if ($_SESSION['branch_id'] == 3) {
				$where_branch = "";
				$where_branch2 = "";
			}else{
				$where_branch = " where branch_id = '".$_SESSION['branch_id']."' ";
				$where_branch2 = " and b.branch_id = '".$_SESSION['branch_id']."' ";
			}
    $query_tr = select_transaction($where_branch2);
    include '../views/edit_transaksi/edit_transaksi_list.php';
    get_footer();
    break;

}
?>
