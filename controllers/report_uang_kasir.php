<?php
include '../lib/config.php';
include '../lib/function.php';
include '../models/report_uang_kasir_model.php';
$page = null;
$page = (isset($_GET['page'])) ? $_GET['page'] : "list";
$title = ucfirst("Laporan Uang Kasir");

$_SESSION['menu_active'] = 7;
$_SESSION['sub_menu_active'] = 41;
$permit = get_akses_permits($_SESSION['user_type_id'],$_SESSION['sub_menu_active']);
switch ($page) {
  case 'list':
    get_header();
    $cabang_active = get_cabang_name($s_cabang);
    $query = select_uang_kasir($s_cabang);
    $id = (isset($_GET['id'])) ? $_GET['id'] : null;
    include '../views/report_uang_kasir/list.php';
    get_footer();
    break;
}
