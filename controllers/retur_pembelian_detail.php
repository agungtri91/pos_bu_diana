<?php
include '../lib/config.php';
include '../lib/function.php';
include '../models/retur_pembelian_detail_model.php';
$page = null;
$page = (isset($_GET['page'])) ? $_GET['page'] : "list";
$title = ucfirst("Retur pembelian Detail");
$_SESSION['menu_active'] = 7;
$_SESSION['sub_menu_active'] = 37;
$permit = get_akses_permits($_SESSION['user_type_id'],$_SESSION['sub_menu_active']);
switch ($page) {
  case 'list':

    get_header($title);
    $q_retur_pembelian1 = select();
    include '../views/retur_pembelian_detail/retur_detail_list.php';
    get_footer();
    break;

  case 'form':

    get_header();
    $purchase_id = get_isset($_GET['id']);
    // var_dump($purchase_id);
    $q_retur_pembelian = select_retur($purchase_id);
    $q_retur_pembelian2 = select_retur($purchase_id);
    // $supplier_id = get_supplier_id($id_hutang);
    // $r_lunas = ket_lunas($supplier_id);
    // $query3 = get_tot_hutang($supplier_id);
    $close_button = "returdetail.php?page=list";
    include '../views/retur_pembelian_detail/form_retur_pembelian_detail.php';
    get_footer();
    break;
  }
 ?>
