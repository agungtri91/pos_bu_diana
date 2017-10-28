<?php
include '../lib/config.php';
include '../lib/function.php';
include '../models/gudang_model.php';
$page = null;
$page = (isset($_GET['page'])) ? $_GET['page'] : "list";
$title = ucwords("Gudang");

$_SESSION['menu_active'] = 1;
$_SESSION['sub_menu_active'] = 8; 

$s_cabang = $_SESSION['branch_id'];
$cabang_active = get_cabang_name($s_cabang);
$permit = get_akses_permits($_SESSION['user_type_id'],$_SESSION['sub_menu_active']);
switch ($page) {
  case 'list':
  get_header();
  $add_button = "gudang.php?page=form";
  $q_gudang = select_gudang();
  include '../views/gudang/gudang_list.php';
  get_footer();
    break;

  case 'form':
  get_header();
  $action = "gudang.php?page=save";
  $close_button = "gudang.php?page=list";
  $id = (isset($_GET['id'])) ? $_GET['id'] : null;
  if($id){
    $row = read_id($id);
    $action = "gudang.php?page=edit&id=$id";
  } else{
    //inisialisasi
    $row = new stdClass();
    $row->gudang_name = false;
    $row->gudang_address = false;
    $row->gudang_phone = false;
    $action = "gudang.php?page=save";
  }
  include '../views/gudang/gudang_form.php';
  get_footer();
    break;

  case 'save':

    extract($_POST);

    $i_name = get_isset($i_name);
    $i_address = get_isset($i_address);
    $i_phone = get_isset($i_phone);
    $data ="'',
            '$i_name',
            '$i_address',
            '$i_phone'
            ";
    create($data);

    header('Location: gudang.php?page=list&did=1');
    break;

  case 'delete':

    $id = get_isset($_GET['id']);
    delete($id);

		header('Location: gudang.php?page=list&did=3');
    break;

  case 'edit':

    $id = get_isset($_GET['id']);
    extract($_POST);
    $i_name = get_isset($i_name);
    $i_address = get_isset($i_address);
    $i_phone = get_isset($i_phone);
    $data = "
            gudang_name = '$i_name',
            gudang_address = '$i_address',
            gudang_address = '$i_address'
    ";
    // var_dump($data);
    update($data,$id);
    header('Location: gudang.php?page=list&did=2');
    break;
  case 'add_stock':

    $id = get_isset($_GET['id']);
    get_header();
    $gudang_name = get_gudang_name2($id);
    // $action = "gudang.php?page=save";
    $q_item_gudang = get_item_gudang($id);
    $q_gudang_mutasi = get_gudang_name();
    $q_branch_mutasi = get_branch_name();
    $close_button = "gudang.php?page=list";
    $q_gudang = get_item_gudang($id);
    $id = (isset($_GET['id'])) ? $_GET['id'] : null;
    if($id){
      $row = read_id($id);
      $action = "gudang.php?page=edit&id=$id";
    } else{
      //inisialisasi
      $row = new stdClass();
      $row->gudang_name = false;
      $row->gudang_address = false;
      $row->gudang_phone = false;
      $action = "gudang.php?page=save";
    }
    // include '../views/gudang/gudang_form.php';
    $action="gudang.php?page=save_tmp";
    include '../views/gudang/gudang_item.php';
    get_footer();
    break;

    case 'save_tmp':
      $i_gudang_id = $_POST['i_gudang_id'];
      $i_item_id = $_POST['i_item_id'];
      $i_item_qty = $_POST['i_item_qty'];
      $data="'',
            '$i_gudang_id',
            '$i_item_id',
            '$i_item_qty'
            ";
      create_mutasi_tmp($data);
      header("Location: gudang.php?page=add_stock&id=$i_gudang_id");
      break;

    case 'detail_item':

      $item_id = $_GET['item_id'];
      $gudang_id = $_GET['gudang_id'];
      $q_gudang_detail_item = get_gudang_detail_item($item_id,$gudang_id);
      //var_dump($_GET);
      include '../views/gudang/item_detail_popmodal.php';
      break;

    case 'select_item':

    $id = $_POST['i_item_id'];
    $gudang_id = $_POST['gudang_id'];
    $query_tmp = mysql_query("SELECT sum(item_qty) as tot_item_tmp FROM mutasi_tmp WHERE gudang_id = '$gudang_id' and item_id = '$id'");
    $r_item_mutasi_tmp = mysql_fetch_array($query_tmp);
    $query = mysql_query("SELECT sum(item_qty) as tot_item_qty FROM gudang WHERE gudang_id = '$gudang_id' and item_id = '$id' GROUP by item_id");
    while($r_item = mysql_fetch_array($query)) {
      $response['data'][] = array(
        'item_qty'   => $r_item['tot_item_qty']-$r_item_mutasi_tmp['tot_item_tmp'],
      );
    };
    $response['status'] = '200';
    echo json_encode($response);
      break;

    case 'kirim_gudang':
    $gudang_id=get_isset($_GET['gudang_id']);
    $q_gudang_mutasi = get_gudang_name();
    include '../views/gudang/kirim_gudang_item_popmodal.php';
      break;

    case 'kirim_cabang':
    $gudang_id=get_isset($_GET['gudang_id']);
    $q_branch_mutasi = get_branch_name();
    include '../views/gudang/kirim_item_cabang_popmodal.php';
      break;

    case 'kirim1':
      $kirim_status = $_POST['item_status'];
      $i_gudang_id=$_POST['i_gudang'];
      // $supplier_id = get_supplier_id($i_item_id,$i_gudang_id);
      $now_date = date("Y-m-d m:i:s");
      $q_mutasi_item = get_mutasi_tmp($i_gudang_id);
        if($kirim_status==1){
          $i_cabang_tujuan = $_POST['i_cabang_tujuan'];
          $r_mutasi_item = mysql_fetch_array($q_mutasi_item);
          $data = "'',
                  '".time()."',
                  '$kirim_status',
                  '$now_date',
                  '$i_gudang_id',
                  '$i_cabang_tujuan'
          ";
      }else {
        $r_mutasi_item = mysql_fetch_array($q_mutasi_item);
          $i_gudang_tujuan = $_POST['i_gudang_tujuan'];
          $data = "'',
                  '".time()."',
                  '$kirim_status',
                  '$now_date',
                  '$i_gudang_id',
                  '$i_gudang_tujuan'
          ";
      }
      create_mutasi($data);
      $mutasi_id = get_id_mutasi();
      $q_mutasi_item_details = get_mutasi_tmp($i_gudang_id);
      while ($r_mutasi_item_details=mysql_fetch_array($q_mutasi_item_details)) {
        $data_details ="'',
                        '$mutasi_id',
                        '".$r_mutasi_item_details['item_id']."',
                        '".$r_mutasi_item_details['item_qty']."'
                        ";
      create_mutasi_details($data_details);
      $item_type = get_item_type($r_mutasi_item_details['item_id']);
      update_item_gudang($i_gudang_id,$r_mutasi_item_details['item_id'],$r_mutasi_item_details['item_qty']);
      if ($kirim_status==1){
        kirim_cabang($item_type,$r_mutasi_item_details['item_id'],$i_cabang_tujuan,$r_mutasi_item_details['item_qty']);
      }else {
        kirim_gudang($item_type,$r_mutasi_item_details['item_id'],$i_gudang_tujuan,$r_mutasi_item_details['item_qty']);
        }
      }
      delete_mutasi_tmp($i_gudang_id);
      header("location: print.php?page=print_gudang&mutasi_id=$mutasi_id");
      break;

    case 'delete_widget':
      $id=get_isset($_GET['id']);
      $gudang_id = get_isset($_GET['gudang_id']);
      delete_widget($id);
      header("Location: gudang.php?page=add_stock&id=$gudang_id");
      break;

    case 'reset':
      $gudang_id = get_isset($_GET['gudang_id']);
      $q_mutasi_tmp = mysql_query("select * from mutasi_tmp");
      while ($q_mutasi_tmp = mysql_fetch_array($q_mutasi_tmp)) {
        reset_widget($gudang_id);
      }
      header("Location: gudang.php?page=add_stock&id=$gudang_id");
      break;
}

 ?>
