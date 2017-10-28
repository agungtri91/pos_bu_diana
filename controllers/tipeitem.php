<?php
include '../lib/config.php';
include '../lib/function.php';
include '../models/tipe_item_model.php';
$page = null;
$page = (isset($_GET['page'])) ? $_GET['page'] : "list";
$title = ucfirst("TIPE ITEM");

$_SESSION['menu_active'] = 1;


switch ($page) {
  case 'list':
    get_header($title);
    $query = select();
    $add_button = "tipeitem.php?page=form";
    include '../views/tipe_item/tipe_list.php';
    get_footer();
    break;

  case 'form':
    get_header();
    $q_type_pembeli = get_type_pembeli();
    $q_type_pembeli2 = get_type_pembeli();
    $close_button = "tipeitem.php?page=list";
    $id = (isset($_GET['id'])) ? $_GET['id'] : null;
    if($id){
      $row = read_id($id);
      while ($r_type_pembeli = mysql_fetch_array($q_type_pembeli2)) {
        $type_pembeli = $r_type_pembeli['type_id_pembeli'];
        $row2[$r_type_pembeli['type_id_pembeli']] = read_diskon($id,$type_pembeli);
      }
      $action = "tipeitem.php?page=edit&id=$id";
      } else{
      //inisialisasi
      $row = new stdClass();
      $row->item_type_id = false;
      $row->item_type_name = false;
      $row->type_id_pembeli = false;
      // $row->supplier_email = false;
      // $row->supplier_addres = false;
      $action = "tipeitem.php?page=save";
      }
      include '../views/tipe_item/tipe_form.php';
      get_footer();
    break;

  case 'save':
    extract($_POST);

    $item_type_name = get_isset($item_type_name);
    $data = "'',
          '$item_type_name'";
    create_type_item($data);
    $type_item_id= get_type_item();
    $diskon = get_isset($diskon);
    $q_type_pembeli=get_type_pembeli();
    // while ($r_type_pembeli2=mysql_fetch_array($q_type_pembeli)) {
    //   $data_diskon = "'',
    //                   '".$r_type_pembeli2['type_id_pembeli']."',
    //                   '$type_item_id',
    //                   '".$diskon[$r_type_pembeli2['type_id_pembeli']]."'
    //                   ";
      //create_type_pembeli_diskon($data_diskon);
    //}
    var_dump($diskon);
     header("Location: tipeitem.php?page=list&did=1");
    break;

  case 'delete':
    $id = get_isset($_GET['id']);
    delete($id);
    header('Location: tipeitem.php?page=list&did=3');
    break;

  case 'edit':

    extract($_POST);

    $id = get_isset($_GET['id']);
    $item_type_name = get_isset($item_type_name);
    $diskon = get_isset($diskon);
    // var_dump($diskon);

    $data = " item_type_name = '$item_type_name'";
    update_type_item($data,$id);

    $q_type_pembeli=get_type_pembeli();
    while ($r_type_pembeli=mysql_fetch_array($q_type_pembeli)){
      $type_id_pembeli = $r_type_pembeli['type_id_pembeli'];
      $data_diskon = " diskon = '".$diskon[$r_type_pembeli['type_id_pembeli']]."'";
      //update_diskon_pembeli($data_diskon,$id,$type_id_pembeli);
    }
    header("Location: tipeitem.php?page=list&did=1");
    break;
}
 ?>
