<?php
  include '../lib/config.php';
  include '../lib/function.php';
  include '../models/piutang_model.php';
  $page = null;
  $page = (isset($_GET['page'])) ? $_GET['page'] : "list";
  $title = ucfirst("DAFTAR PIUTANG");

  $_SESSION['menu_active'] = 7;
  $_SESSION['sub_menu_active'] = 29;
$permit = get_akses_permits($_SESSION['user_type_id'],$_SESSION['sub_menu_active']);
switch ($page) {

  case 'list':
    get_header($title);
    $query = select();
    include '../views/piutang/list.php';
    get_footer();
    break;

  case 'form':
    get_header();
    $member_id = get_isset($_GET['id']);

    $member_detail = (isset($_GET['member_detail'])) ? $_GET['member_detail'] : null;

    $where = "WHERE member_id = '$member_id'";
    $q_member = select_config('members', $where);
    $r_member =  mysql_fetch_array($q_member);
    $q_piutang = select_transaction_piutang($member_id);
    if ($member_detail == 1) {
      $close_button = "member.php?page=history_member&id=$member_id";
    } else {
      $close_button = "piutang.php?page=list";
    }
    include '../views/piutang/form.php';
    get_footer();
    break;

  case 'piutang_popmodal':

    $transaction_id = $_GET['id'];
    $member_id = $_GET['member_id'];
    $where_transaction_id = "WHERE transaction_id = '$transaction_id'";
    $q_angsuran_kredit = select_angsuran_kredit($transaction_id);
    include '../views/piutang/piutang_popmodal.php';
    break;
  }
?>
