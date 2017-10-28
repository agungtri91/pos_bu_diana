<?php
include '../lib/config.php';
include '../lib/function.php';
include '../models/satuan_model.php';
$page = null;
$page = (isset($_GET['page'])) ? $_GET['page'] : "list";
$title = ucfirst("Satuan");
$_SESSION['menu_active'] = 1;
$s_cabang = $_SESSION['branch_id'];
$_SESSION['sub_menu_active'] = 15;
$permit = get_akses_permits($_SESSION['user_type_id'],$_SESSION['sub_menu_active']);
switch ($page) {
  case 'list':
    get_header($title);
    $q_tingkat = select_tingkat();
    $query = select_satuan();
    $add_button = 'satuan.php?page=form';
    $add_button_2 = 'satuan.php?page=form_tingkat';
    include '../views/satuan/satuan_list.php';
    get_footer();
    break;

  case 'form_tingkat':
    get_header();
    $close_button = "satuan.php?page=list";
    $id = (isset($_GET['id'])) ? $_GET['id'] : null;
    if($id){
      $row_tingkat = read_tingkat_id($id);
    } else{
      $row_tingkat = new stdClass();
      $row_tingkat->tingkat_id = false;
      $row_tingkat->tingkat_name = false;
    }
    include '../views/satuan/tingkat_form.php';
    get_footer();
    break;

  case 'form':
    get_header();
    $q_tingkat_satuan = select_tingkat();
    $close_button = "satuan.php?page=list";
		$id = (isset($_GET['id'])) ? $_GET['id'] : null;
		if($id){
			$row = read_id($id);
		} else{
			$row = new stdClass();
      $row->unit_id = false;
			$row->unit_name = false;
      $row->tingkat = false;
		}
    include '../views/satuan/satuan_form.php';
    get_footer();
    break;

  case 'save':
    $id_save = $_GET['tipe'];
    $i_name = $_POST['i_name'];
     if ($id_save==1) {
       $data = "'',
                '$i_name',
                ''
                ";
       create_config("tingkat",$data);
     }else {
       $i_unit = $_POST['i_unit'];
       $data = "'',
                '$i_name',
                '',
                ''
                ";
       create_config("units",$data);
     }
    header("Location: satuan.php?page=list&did=1");
    break;

  case 'delete':
    $id_delete = get_isset($_GET['delete']);
    $id_satuan = get_isset($_GET['id']);
    if ($id_delete == 1) {
      delete_tingkat($id_satuan);
    }else {
      delete_satuan($id_satuan);
    }
    header("Location: satuan.php?page=list&did=3");
    break;

  case 'edit':
    $id_edit = $_GET['tipe'];
    $id = (isset($_GET['id'])) ? $_GET['id'] : null;
    $i_name = $_POST['i_name'];
    if ($id_edit == 1) {
      $data = "tingkat_name = '$i_name'";
      update_tingkat($id,$data);
    }else {
      $i_tingkat = '';
      $data = "unit_name = '$i_name',
               tingkat = '$i_tingkat'
              ";
      update_satuan($id,$data);
    }
    header("Location: satuan.php?page=list&did=2");
    break;

  case 'strcmp':
    $satuan_baru = $_POST['x'];
    $id = $_POST['y'];
    if ($id==1) {
      $q_tingkat = select_tingkat_baru($satuan_baru);
      $r_tingkat = mysql_fetch_array($q_tingkat);
      $data = $r_tingkat['tingkat_name'];
    }else {
      $q_satuan = select_satuan_baru($satuan_baru);
      $r_satuan = mysql_fetch_array($q_satuan);
      $data = $r_satuan['unit_name'];
    }
    echo json_encode($data);
    break;

  case 'get_tingkat':
    $tingkat = $_POST['x'];
     $query_2 = mysql_query("SELECT * FROM units ORDER BY unit_name ASC");
     while ($row_2 = mysql_fetch_array($query_2)) {
       $data[]= array('unit_id' => $row_2['unit_id'],
                       'unit_name' => $row_2['unit_name'],
      );};
    echo json_encode($data);
    break;
}
 ?>
