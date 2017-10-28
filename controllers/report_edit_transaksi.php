<?php
include '../lib/config.php';
include '../lib/function.php';
include '../models/report_edit_transaksi_model.php';
$page = null;
$page = (isset($_GET['page'])) ? $_GET['page'] : "list";
$title = ucfirst("EDIT TRANSAKSI");

$_SESSION['menu_active'] = 7;
$_SESSION['sub_menu_active'] = 42;
$permit = get_akses_permits($_SESSION['user_type_id'],$_SESSION['sub_menu_active']);
switch ($page) {
  case 'list':
    get_header();
    if ($_SESSION['branch_id'] == 3) {
				$where_branch = "";
				$where_branch2 = "";
			}else{
				$where_branch = " where b.branch_id = '".$_SESSION['branch_id']."' ";
				$where_branch2 = " and b.branch_id = '".$_SESSION['branch_id']."' ";
			}
      $action = "report_edit_transaksi.php?page=form_result&preview=1";
      include '../views/report_edit_transaksi/report_edit_transaksi_form.php';
      if(isset($_GET['preview'])){
  				if(isset($_GET['i_trans_type'])){
  					$i_trans_type = $_GET['i_trans_type'];
  				}else{
  					extract($_POST);
  					$i_trans_type = $_GET['i_trans_type'];
  				}
          if ($i_trans_type==1) {
            $query_tr = select_transaction($where_branch);
            include '../views/report_edit_transaksi/report_edit_transaksi_list.php';
          }else {
            $query_purchase = select_purchase($where_branch);
            include '../views/report_edit_transaksi/report_edit_pembelian_list.php';
          }
        }
    // $query_tr = select_transaction($where_branch2);
    get_footer();
    break;

    case 'form_result':
      var_dump($_POST);
      $i_trans_type = (isset($_POST['i_trans_type'])) ? $_POST['i_trans_type'] : null;
      header("Location: report_edit_transaksi.php?page=list&preview=1&i_trans_type=$i_trans_type");
      break;

      case 'popmodal':
    	  $purchases_code = get_isset($_GET['purchases_code']);
    		$branch_id = get_isset($_GET['branch_id']);
    	  $q_detail_trans = select_detail_purchases($purchases_code,$branch_id);
    		$purchase_total = get_purchase_total($purchases_code,$branch_id);
    	  include '../views/report_edit_transaksi/popmodal.php';
    	break;

    	case 'popmodal_penjualan':
    	  $transaction_code = get_isset($_GET['transaction_code']);
    		$branch_id = get_isset($_GET['branch_id']);
    	  $q_detail_transaction = select_detail_transaction($transaction_code,$branch_id);
    		$total_all = get_transaction_total($transaction_code,$branch_id);
    	  include '../views/report_edit_transaksi/popmodal_penjualan.php';
    	break;
}
?>
