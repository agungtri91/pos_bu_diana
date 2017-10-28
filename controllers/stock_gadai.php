<?php
include '../lib/config.php';
include '../lib/function.php';
include '../models/stock_gadai_model.php';
$page = null;
$page = (isset($_GET['page'])) ? $_GET['page'] : "list";
$title = ucwords("Stock Gadai");

$_SESSION['menu_active'] = 1;
$_SESSION['sub_menu_active'] = 14;
$permit = get_akses_permits($_SESSION['user_type_id'],$_SESSION['sub_menu_active']);
$path = "../img/item_gadai/";

switch ($page) {

  case 'list':
    get_header();
    if ($s_cabang == 3) {
      $where_branch_id = '';
    } else {
      $where_branch_id = "WHERE a.branch_id = '$s_cabang'";
    }
    $query = select_gadai_barang($where_branch_id);
    include '../views/stock_gadai/stock_gadai_list.php';
    get_footer();
    break;

  case 'form':
    get_header();
    $id = (isset($_GET['id'])) ? $_GET['id'] : null;
    $where = '';
    $q_jenis = select_config('kategori', $where);
    $q_periode = select_config('periode', $where);


    if ($id) {
      $where_gadai_id = "WHERE gadai_id = '$id'";
      $sudah_dimutasi = select_config_by('mutasi_barang', 'COUNT(*)', $where_gadai_id);
      $where_gadai_id = "WHERE gadai_id = '$id'";
      $q_item_details = select_config('gadai_tmp_details', $where_gadai_id);
      $q_item_details_2 = select_config('gadai_tmp_details', $where_gadai_id);
      $row = select_gadai_detail($id);
      $action = "stock_gadai.php?page=edit_stock_gadai&id=$id";
    }
    $close_button = "stock_gadai.php?page=list";
    include '../views/stock_gadai/stock_gadai_form.php';
    get_footer();
    break;

  case 'edit_stock_gadai':

    $id = (isset($_GET['id'])) ? $_GET['id'] : null;
    $i_name = $_POST['i_name'];
    $kategori = $_POST['kategori'];
    $merk_item = $_POST['merk_item'];
    $tipe_item = $_POST['tipe_item'];
    $administrasi = $_POST['administrasi'];
    $nilai_pembiayaan = $_POST['nilai_pembiayaan'];
    $lama_angsuran = $_POST['lama_angsuran'];
    $periode = $_POST['periode'];
    $angsuran_per_bulan = $_POST['angsuran_per_bulan'];
    $per_tanggal = $_POST['per_tanggal'];
    $per_tanggal_explode = explode('-', $per_tanggal);
    $tanggal_1 = $per_tanggal_explode[0];
    $tanggal_2 = $per_tanggal_explode[1];

    $update_gadai = "
                    nama_item = '$i_name',
                    kategori = '$kategori',
                    merk_item = '$merk_item',
                    tipe_item = '$tipe_item',
                    administrasi = '$administrasi',
                    nilai_pembiayaan = '$nilai_pembiayaan',
                    periode = '$periode',
                    lama_angsuran = '$lama_angsuran',
                    angsuran_per_bulan = '$angsuran_per_bulan',
                    pembayaran_per_tanggal_1 = '$tanggal_1',
                    pembayaran_per_tanggal_2 = '$tanggal_2'";
    var_dump($update_gadai);
    $param = "gadai_id = '$id'";
    update_config2('gadai_tmp', $update_gadai, $param);
    header("Location:stock_gadai.php?page=list&did=2");
    break;

  case 'mutasi_gadai_modal':

    $id = (isset($_GET['id'])) ? $_GET['id'] : null;
    $where_gadai_id = "WHERE gadai_id = '$id'";
    $action = "stock_gadai.php?page=save_mutasi_gadai";
    $nama_item = select_config_by('gadai_tmp', 'nama_item', $where_gadai_id);
    $q_item_details = select_config('gadai_tmp_details', $where_gadai_id);
    $count_item_details = select_config_by('gadai_tmp_details', 'COUNT(*)', $where_gadai_id);

    $where = '';
    $q_bank = select_config('branches',$where);

    $sudah_dimutasi = select_config_by('mutasi_barang', 'COUNT(*)', $where_gadai_id);

    include '../views/stock_gadai/mutasi_gadai_popmodal.php';
    break;

  case 'save_mutasi_gadai':
    $path_item = "../img/menu/";
    $input_checked = $_POST['input_checked'];
    foreach ($input_checked as $key => $value) {
      $item_mutasi = $value;
    }
    $gadai_id = $_POST['gadai_id'];
    $nama_item = $_POST['nama_item'];
    // $branch_id_tujuan = $_POST['branch_id_tujuan'];
    // if ($branch_id_tujuan==0) { $branch_id_tujuan = $s_cabang; }
    $mutasi_code = "M".time();
    $tanggal = new_date();

    $data_mutasi = "'',
                    '$gadai_id',
                    '$mutasi_code',
                    '$tanggal',
                    '$s_cabang',
                    '$s_cabang'";
    create_config('mutasi_barang', $data_mutasi);

    $where_gadai_id = "WHERE gadai_id = '$gadai_id'";
    $r_item = select_object_config('gadai_tmp', $where_gadai_id);

    $data_item = "'',
                  '$r_item->kategori',
                  '',
                  '',
                  '$nama_item',
                  '',
                  '',
                  '$item_mutasi',
                  ''";
    create_config('items', $data_item);
    $item_id = mysql_insert_id();

    $data_item_detail = "'',
                         '$item_id',
                         '$r_item->merk_item',
                         '',
                         '',
                         '',
                         '',
                         '',
                         '',
                         ''";
    create_config('item_details', $data_item_detail);
    $path_item_image = "../img/menu/";
    copy($path.$item_mutasi, $path_item_image.$item_mutasi);
    header("Location:stock.php?page=form&id=$item_id&gadai_id=$gadai_id&status=1;");
    break;
}
