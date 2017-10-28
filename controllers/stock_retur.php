<?php
include '../lib/config.php';
include '../lib/function.php';
include '../models/stock_retur_model.php';
$page = null;
$page = (isset($_GET['page'])) ? $_GET['page'] : "list";
$title = ucfirst("STOCK RETUR PEMBELIAN");

$_SESSION['menu_active'] = 1;
$_SESSION['sub_menu_active'] = 13;
$permit = get_akses_permits($_SESSION['user_type_id'],$_SESSION['sub_menu_active']);
switch ($page) {
  case 'list':
    get_header($title);
    $query = select();
    include '../views/stock_retur/stock_retur_list.php';
    get_footer();
    break;

  case 'form':
    get_header();

    $id = $_GET['id'];
    $where_item_id = "WHERE item_id = '$id'";

    $item_name = select_config_by('items', 'item_name', $where_item_id);

    $q_item_retur_detail = select_item_retur_detail($id);

    include '../views/stock_retur/stock_retur_form.php';
    get_footer();
    break;
}
