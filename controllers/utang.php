<?php
include '../lib/config.php';
include '../lib/function.php';
include '../models/utang_model.php';

$page = null;
$page = (isset($_GET['page'])) ? $_GET['page'] : "list";
$title = ucfirst("ANGSURAN HUTANG");
$_SESSION['menu_active'] = 7;
$_SESSION['sub_menu_active'] = 30;;
$permit = get_akses_permits($_SESSION['user_type_id'],$_SESSION['sub_menu_active']);

  switch ($page) {
    case 'list':

      get_header($title);
      $query = select();
      include '../views/hutang/list.php';
      get_footer();
      break;

    case 'form':

      get_header();
      $id_hutang = get_isset($_GET['id']);
      $query = select_hutang($id_hutang);
      $supplier_id = get_supplier_id($id_hutang);
      $r_lunas = ket_lunas($supplier_id);
      $query3 = get_tot_hutang($supplier_id);
      $close_button = "hutang.php?page=list";
      include '../views/hutang/form.php';
      get_footer();
      break;
    }
 ?>
