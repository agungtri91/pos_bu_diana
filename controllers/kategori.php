<?php
include '../lib/config.php';
include '../lib/function.php';
include '../models/kategori_model.php';
$page = null;
$page = (isset($_GET['page'])) ? $_GET['page'] : "list";
$title = ucfirst("KATEGORI");

$_SESSION['menu_active'] = 1;
$_SESSION['sub_menu_active'] = 18;
$permit = get_akses_permits($_SESSION['user_type_id'],$_SESSION['sub_menu_active']);
switch ($page) {
  case 'list':
    get_header($title);
    $query = select();
    $add_button = "kategori.php?page=form";
    include '../views/kategori/kategori_list.php';
    get_footer();
    break;

  case 'form':
    get_header();
    $close_button = "kategori.php?page=list";
    $id = (isset($_GET['id'])) ? $_GET['id'] : null;
    $where_kategori_id = "WHERE kategori_id = '$id'";
    $q_kategori_ket = select_config('kategori_keterangan', $where_kategori_id);
    if($id){
      $row = read_id($id);
      $q_sub_kategori = select_sub_kategori($id);
      $row_sub_kategori = read_id_kategori($id);
      $action = "kategori.php?page=edit&id=$id";
      } else{
      //inisialisasi
      $row = new stdClass();
      $row_sub_kategori = new stdClass();
      $row->kategori_id = false;
      $row->kategori_name = false;
      $row_sub_kategori->sub_kategori_id = false;
      $row_sub_kategori->sub_kategori_name = false;
      $row_sub_kategori->kategori_utama_id = false;
      $action = "kategori.php?page=save";
      }
      include '../views/kategori/kategori_form.php';
      get_footer();
    break;

  case 'save':
    $id = (isset($_GET['id'])) ? $_GET['id'] : null;
    extract($_POST);

    $kategori_name = get_isset($kategori_name);
    $data = "'',
          '$kategori_name'";
    create_kategori($data);
    $id = mysql_insert_id();
    header("Location: kategori.php?page=form&id=$id");
    break;

  case 'delete':
    $id = get_isset($_GET['id']);
    delete($id);
    header('Location: kategori.php?page=list&did=3');
    break;

  case 'edit':

    extract($_POST);

    $id = get_isset($_GET['id']);
    $kategori_name = get_isset($kategori_name);
    $data = " kategori_name = '$kategori_name'";
    update_kategori($data,$id);

    header("Location: kategori.php?page=list&did=2");
    break;

  case 'popmodal_sub_kategori':
    $id = (isset($_GET['kategori_id'])) ? $_GET['kategori_id'] : null;
    $id2 = (isset($_GET['sub_kategori_id'])) ? $_GET['sub_kategori_id'] : null;
    if ($id2) {
      $row_sub_kategori = read_id_sub_kategori($id2);
      $action = "kategori.php?page=edit_sub_kategori&id=$id&id2=$id2";
    }else {
      $row_sub_kategori = new stdClass();
      $row_sub_kategori->sub_kategori_id = false;
      $row_sub_kategori->sub_kategori_name = false;
      $action = "kategori.php?page=save_sub_kategori&id=$id&id2=$id2";
    }
    include '../views/kategori/sub_kategori_popmodal.php';
    break;

  case 'save_sub_kategori':
    $id = (isset($_GET['id'])) ? $_GET['id'] : null;
    $sub_kategori_name = $_POST['sub_kategori_name'];
    $data = "'',
             '$sub_kategori_name',
             '$id'
             ";
    create_config("sub_kategori",$data);
    header("Location: kategori.php?page=form&id=$id");
    break;

  case 'delete_sub_kategori':
    $id = get_isset($_GET['id']);
    $id2 = (isset($_GET['id2'])) ? $_GET['id2'] : null;
    delete_sub_kategori($id2);
    header("Location: kategori.php?page=form&id=$id");
    break;

  case 'edit_sub_kategori':

    extract($_POST);

    $id = get_isset($_GET['id']);
    $id2 = (isset($_GET['id2'])) ? $_GET['id2'] : null;
    $sub_kategori_name = $_POST['sub_kategori_name'];
    $data = " sub_kategori_name = '$sub_kategori_name'";
    update_sub_kategori($data,$id2);
    header("Location: kategori.php?page=form&id=$id");
    break;

  case 'popmodal_keterangan':
    $kategori_id = $_GET['kategori_id'];
    $id = (isset($_GET['id'])) ? $_GET['id'] : null;
    if ($id !== null) {
      $where_kategori_id = "WHERE kategori_keterangan_id = '$id'";
      $row = select_object_config('kategori_keterangan', $where_kategori_id);
      $action = "kategori.php?page=edit_kategori_keterangan&id=$id&kategori_id=$kategori_id";
    } else {
      $row = new stdClass();
      $row->kategori_id = false;
      $row->kategori_keterangan_name = false;
      $row->keterangan = false;
      $action = "kategori.php?page=save_kategori_keterangan&kategori_id=$kategori_id";
    }
    include '../views/kategori/kategori_keterangan_popmodal.php';
    break;

  case 'save_kategori_keterangan':
    $kategori_id = $_GET['kategori_id'];
    $ket_name = $_POST['ket_name'];
    $data = "'',
             '$kategori_id',
             '$ket_name',
             ''";
    create_config('kategori_keterangan',$data);
    header("Location: kategori.php?page=form&id=$kategori_id");
    break;

  case 'edit_kategori_keterangan':
    $id = (isset($_GET['id'])) ? $_GET['id'] : null;
    $kategori_id = $_GET['kategori_id'];
    $ket_name = $_POST['ket_name'];
    $data = " kategori_keterangan_name = '$ket_name'";
    $where_kategori_id = "kategori_keterangan_id = '$id'";
    update_config2('kategori_keterangan', $data,$where_kategori_id);
    header("Location: kategori.php?page=form&id=$kategori_id");
    break;

  case 'delete_kategori_keterangan':
    $id = $_GET['kategori_keterangan'];
    $kategori_id = $_GET['kategori_id'];
    $where_kategori_id = "kategori_keterangan_id = '$id'";
    delete_config('kategori_keterangan', $where_kategori_id);
    header("Location: kategori.php?page=form&id=$kategori_id");
    break;
}

 ?>
