<?php
include '../lib/config.php';
include '../lib/function.php';
include '../models/tipe_pembeli_model.php';
$page = null;
$page = (isset($_GET['page'])) ? $_GET['page'] : "list";
$title = ucwords("TIPE CUSTOMER");

$_SESSION['menu_active'] = 1;
$_SESSION['sub_menu_active'] = 16;
$permit = get_akses_permits($_SESSION['user_type_id'],$_SESSION['sub_menu_active']);

switch ($page) {
  case 'list':
  get_header($title);
  $query = select($s_cabang);
  $add_button = "tipe_pembeli.php?page=form";
  include '../views/tipe_pembeli/tipe_list_pembeli.php';
  get_footer();
    break;

  case 'form':
    get_header();
    $close_button = "tipe_pembeli.php?page=list";
    $id = (isset($_GET['id'])) ? $_GET['id'] : null;
    $branch_id = (isset($_GET['branch_id'])) ? $_GET['branch_id'] : null;
    $q_diskon_brlk = select_diskon_brlk();
    $q_diskon = select_diskon($id);
    if($id){
        $row = read_id($id,$branch_id);
        $r_diskon = read_tipe_item_diskon($id,$branch_id);
        $action = "tipe_pembeli.php?page=edit&id=$id&branch_id=$branch_id";
      } else {
        $row = new stdClass();
        $row->type_id_pembeli = false;
        $row->type_pembeli_name = false;
        $row->tipe_diskon_berlaku = false;
        $action = "tipe_pembeli.php?page=save";
      }
      include '../views/tipe_pembeli/tipe_form_pembeli.php';
      get_footer();
    break;

  case 'save':
    extract($_POST);
    $tipe_pembeli_name = get_isset($tipe_pembeli_name);
    $tipe_diskon = get_isset($tipe_diskon);
    $data = "'',
        '$tipe_pembeli_name',
        '',
        '$s_cabang',
        '$tipe_diskon'
        ";
    create_type_pembeli($data);
    $id = mysql_insert_id();
    header("Location: tipe_pembeli.php?page=form&id=$id&branch_id=$s_cabang");
    break;

  case 'edit':
    extract($_POST);
    $id = get_isset($_GET['id']);
    $branch_id = get_isset($_GET['branch_id']);
    $tipe_pembeli_name = get_isset($tipe_pembeli_name);
    $tipe_diskon = get_isset($tipe_diskon);
    $data = " type_pembeli_name = '$tipe_pembeli_name',
              tipe_diskon_berlaku = '$tipe_diskon'
            ";
    update_tipe_pembeli($data,$id,$branch_id);
    header("Location: tipe_pembeli.php?page=list&did=2");
    break;

  case 'delete':
    $type_id_pembeli = $_GET['id'];
    $branch_id = $_GET['branch_id'];
    delete($type_id_pembeli,$branch_id);
    header("Location: tipe_pembeli.php?page=list&did=3");
    break;

  case 'strcmp':
		$data_baru = $_POST['x'];
		$query = select_baru($data_baru);
		$row = mysql_fetch_array($query);
		$data = $row['result'];
		echo json_encode($data);
		break;

  case 'popmodal':
    $kategori_item = (isset($_GET['kategori_item'])) ? $_GET['kategori_item'] : null;
    $tipe_pembeli = (isset($_GET['tipe_pembeli'])) ? $_GET['tipe_pembeli'] : null;
    $branch_id = (isset($_GET['branch_id'])) ? $_GET['branch_id'] : null;
    $tipe_pembeli_diskon_id = (isset($_GET['tipe_pembeli_diskon_id'])) ? $_GET['tipe_pembeli_diskon_id'] : null;
    $id = $_GET['id'];
    $q_tipe_item = select_tipe_item();
    if ($id==2) {
      $r_tipe_item = read_tipe_item_diskon($tipe_pembeli_diskon_id);
      $action = 'tipe_pembeli.php?page=list&page=edit_diskon_pembeli';
    }else {
      $r_tipe_item = new stdClass();
      $r_tipe_item->tipe_pembeli_diskon_id = false;
      $r_tipe_item->kategori_item = false;
      $r_tipe_item->nilai_diskon = false;
      $r_tipe_item->nominal_diskon = false;
      $action = 'tipe_pembeli.php?page=list&page=save_diskon_pembeli';
    }
    include '../views/tipe_pembeli/tipe_pembeli_popmodal.php';
    break;

  case 'save_diskon_pembeli':
    $kategori = $_POST['kategori'];
    $nilai_diskon = $_POST['nilai_diskon'];
    $tipe_pembeli = $_POST['tipe_pembeli'];
    $branch_id = $_POST['branch_id'];
    $nominal_diskon = $_POST['nominal_diskon'];
    $data = "'',
             '$tipe_pembeli',
             '$kategori',
             '$nilai_diskon',
             '$nominal_diskon'
             ";
    create_config("tipe_pembeli_diskon",$data);
    header("Location: tipe_pembeli.php?page=form&id=$tipe_pembeli&branch_id=$branch_id");
    break;

  case 'edit_diskon_pembeli':
    $id = $_POST['tipe_pembeli_diskon_id'];
    $kategori = $_POST['kategori'];
    $nilai_diskon = $_POST['nilai_diskon'];
    $tipe_pembeli = $_POST['tipe_pembeli'];
    $branch_id = $_POST['branch_id'];
    $nominal_diskon = $_POST['nominal_diskon'];
    $data = " kategori_item   = '$kategori',
              nilai_diskon    = '$nilai_diskon',
              nominal_diskon  = '$nominal_diskon'
            ";
    update_diskon($data,$kategori,$id);
    header("Location: tipe_pembeli.php?page=form&id=$tipe_pembeli&branch_id=$branch_id");
    break;

  case 'delete_diskon':
    $id = $_GET['id'];
    $tipe_pembeli = $_GET['tipe_pembeli'];
    $branch_id = $_GET['branch_id'];
    delete_config("tipe_pembeli_diskon","tipe_pembeli_diskon_id = $id");
    header("Location: tipe_pembeli.php?page=form&id=$tipe_pembeli&branch_id=$branch_id");
    break;
}
?>
