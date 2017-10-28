<?php

include '../lib/config.php';
include '../lib/function.php';
include '../models/report_penyesuaian_stock_model.php';
$page = null;
$page = (isset($_GET['page'])) ? $_GET['page'] : "list";
$title = ucfirst("Laporan penyesuaian stock");

$_SESSION['menu_active'] = 7;
$_SESSION['sub_menu_active'] = 40;

$s_cabang = $_SESSION['branch_id'];
$branch_active = get_branch($s_cabang);
$permit = get_akses_permits($_SESSION['user_type_id'],$_SESSION['sub_menu_active']);
switch ($page) {
  case 'list':
  get_header();
  $query = select($s_cabang);
  include '../views/report_penyesuaian_stock/report_penyesuaian_stock_list.php';
  get_footer();
    break;
}
 ?>
