<?php
include '../lib/config.php';
include '../lib/function.php';
include '../models/denda_model.php';
$page = null;
$page = (isset($_GET['page'])) ? $_GET['page'] : "list";
$title = ucwords("Denda");

$_SESSION['menu_active'] = 1;
$_SESSION['sub_menu_active'] = 44;
$permit = get_akses_permits($_SESSION['user_type_id'],$_SESSION['sub_menu_active']);

switch ($page) {
  case 'list':
    get_header();
    $where = '';
    $q_denda = select_config('denda', $where);
    $add_button = 'denda.php?page=form';
    include '../views/denda/denda_list.php';
    get_footer();
    break;

  case 'form':
    get_header();
    $id = (isset($_GET['id'])) ? $_GET['id'] : null;
    $where = '';
    $q_periode = select_config('periode', $where);
    if ($id) {
      $where = "where denda_id = '$id'";
      $row = select_object_config('denda', $where);
      $action = "denda.php?page=edit&id=$id";
    }else {
      $row = new stdClass();

			$row->denda_name = false;
			$row->jenis_denda = false;
			$row->denda_nominal = false;
			$row->denda_persen = false;
      $row->denda_desc = false;

      $action = "denda.php?page=save";
    }
    $close_button = "denda.php?page=list";
    include '../views/denda/denda_form.php';
    get_footer();
    break;

    case 'save':
      $i_name = $_POST['i_name'] ;
      $i_jenis = $_POST['i_jenis'] ;
      $i_nominal = '';
      $i_persen = $_POST['i_persen'] ;
      $i_desc = $_POST['i_desc'] ;

      $data_denda = " '',
                      '$i_name',
                      '$i_jenis',
                      '$i_nominal',
                      '$i_persen',
                      '$i_desc',
                      '$s_cabang'";
      create_config('denda',$data_denda);
      header("location:denda.php?page=list&did=1");
      break;

    case 'edit':
      $id = $_GET['id'];
      $i_name = $_POST['i_name'] ;
      $i_jenis = $_POST['i_jenis'] ;
      $i_nominal = $_POST['i_nominal'] ;
      $i_persen = '';
      $i_desc = $_POST['i_desc'] ;
      $data_update_denda = "
                            denda_name = '$i_name',
                            jenis_denda = '$i_jenis',
                            denda_nominal = '$i_nominal',
                            denda_persen = '$i_persen',
                            denda_desc = '$i_desc'
                            ";
      $where = "denda_id = '$id'";
      update_config2('denda', $data_update_denda, $where);
      header("location:denda.php?page=list&did=2");
      break;

    case 'delete':
      $id = $_GET['id'];
      $where = "denda_id = '$id'";
      delete_config('denda');
      header("location:denda.php?page=list&did=3");
      break;
}
