  <?php
include '../lib/config.php';
include '../lib/function.php';
include '../models/angsuran_model.php';
$page = null;
$page = (isset($_GET['page'])) ? $_GET['page'] : "list";
$title = ucwords("ANGSURAN PIUTANG / KREDIT");

$_SESSION['menu_active'] = 4;
$_SESSION['sub_menu_active'] = 23;
$permit = get_akses_permits($_SESSION['user_type_id'],$_SESSION['sub_menu_active']);
switch ($page) {
  case 'list':
    get_header($title);
    $query = select($s_cabang);
    include '../views/angsuran/list.php';
    get_footer();
    break;

  case 'list_piutang_member':
    get_header();
    $member_id = $_GET['id'];
    $where = "WHERE member_id = '$member_id'";
    $member_name = select_config_by('members', 'member_name', $where);
    $close_button = 'angsuran.php?page=list';
    $q_piutang_pembeli = select_piutang_pembeli($member_id);

    include '../views/angsuran/form_angsuran_piutang.php';
    get_footer();
    break;

  case 'piutang_detail_popmodal':

    $kredit_id = $_GET['id'];
    $where =  "WHERE kredit_id = '$kredit_id'";
    $item_id = select_config_by('kredit','item_id',$where);
    $member_id = select_config_by('kredit','member_id',$where);
    $transaction_id = select_config_by('kredit','transaction_id',$where);
    $where_item_id =  "WHERE item_id = '$item_id'";
    $item_name = select_config_by('items','item_name',$where_item_id);
    $item_gambar = select_config_by('items','stock_img',$where_item_id);
    $q_item_kredit = select_trans_kredit($kredit_id);
    $r_item_kredit = mysql_fetch_array($q_item_kredit);

    $periode = $r_item_kredit['periode'];
    $where_periode = "WHERE periode_id = '$periode'";
    $periode_name = select_config_by('periode', 'periode_name', $where_periode);

    $q_piutang_pembeli_detail = select_piutang_pembeli_detail($kredit_id);

    $where_angsuran_kredit_id = "WHERE kredit_id = '$kredit_id'";
    $angsuran_kredit_id = select_config_by('angsuran_kredit', 'angsuran_kredit_id', $where_angsuran_kredit_id);

    $where_telah_diangsur = "WHERE angsuran_kredit_id = '$angsuran_kredit_id'";
    $telah_diangsur = select_config_by('angsuran_kredit_details', 'COUNT(*)', $where_telah_diangsur);
    $action = "angsuran.php?page=simpan_angsuran_tmp";
    include '../views/angsuran/piutang_detail_popmodal.php';

    break;

  case 'simpan_angsuran_tmp':
    $input = $_POST['input'];
    $kredit_id = $_POST['kredit_id'];
    $member_id = $_POST['member_id'];
    $transaction_id = $_POST['transaction_id'];
    $i_status = $_POST['i_status'];
    $denda = 0;

    $where_code = "WHERE transaction_id = '$transaction_id'";
    $transaction_code = select_config_by('transactions', 'transaction_code', $where_code);
    $no = 0;
    foreach ($input as $key => $value) {
      if ($value == 1) {
        $no ++;
      }
    }
    $where_kredit_id = "WHERE kredit_id = '$kredit_id'";
    $q_kredit = select_config('kredit',$where_kredit_id);
    $r_kredit = mysql_fetch_array($q_kredit);
    $data_angsuran_kredit = "'',
                             '$member_id',
                             '$transaction_id',
                             '$kredit_id',
                             '".$r_kredit['lama_angsuran']."',
                             '".$r_kredit['angsuran_per_bulan']."',
                             '".$r_kredit['kredit_total']."'
                             ";
    create_config('angsuran_kredit_tmp',$data_angsuran_kredit);
    $angsuran_kredit_id = mysql_insert_id();
    $angsuran_date = date('y-m-d');
    $total_angsuran_bayar = 0;

    $denda = 0;
    for ($i=0; $i < $no; $i++) {
      if ($i_status[$i]) {
        $periode_id = select_config_by('kredit', 'periode', $where_kredit_id);
        $denda_persen = get_denda_persen($periode_id);
        $denda_nominal_persen = $denda_persen / 100 * $r_kredit['angsuran_per_bulan'];
      }
      $data_angsuran_kredit_details = "'',
                                       '$angsuran_kredit_id',
                                       '$angsuran_date',
                                       '',
                                       '".$r_kredit['angsuran_per_bulan']."',
                                       '',
                                       '',
                                       '',
                                       '$denda_persen',
                                       '$denda_nominal_persen',
                                       '$i_status[$i]'";
      create_config('angsuran_kredit_details_tmp',$data_angsuran_kredit_details);
      $total_angsuran_bayar = $total_angsuran_bayar + $r_kredit['angsuran_per_bulan'] + $denda_nominal_persen;
    }
    $where_member = "WHERE member_id = '$member_id'";
    $q_member = select_config('members',$where_member);
    $row_member = mysql_fetch_array($q_member);
    $order_bank_id = 'order by bank_id';
    $q_bank = select_config('banks',$order_bank_id);
    $q_bank_to = select_config('banks',$order_bank_id);
    $action = 'angsuran.php?page=simpan_angsuran';
    include '../views/angsuran/pp_list.php';
    break;

  case 'kembali':
    $kredit_id = $_GET['id'];
    $member_id = $_GET['member_id'];
    $where = "WHERE kredit_id = '$kredit_id'";
    $angsuran_kredit_id = select_config_by('angsuran_kredit_tmp', 'angsuran_kredit_id', $where);
    $where_delete = "angsuran_kredit_id = '$angsuran_kredit_id'";
    delete_config('angsuran_kredit_details_tmp',$where_delete);
    delete_config('angsuran_kredit_tmp',$where_delete);
    header("Location: angsuran.php?page=list_piutang_member&id=$member_id");
    break;

  case 'simpan_angsuran':
    $id = $_POST['kredit_id'];
    $member_id = $_POST['i_member'];
    $payment_method = $_POST['i_payment_method'];
    $transaction_id = $_POST['transaction_id'];
    $i_bank_id = '';
    $i_bank_account = '';
    $i_bank_id_to = '';
    $i_bank_account_to = '';
    $i_payment = $_POST['i_payment'];
    $i_grand_total = $_POST['i_grand_total'];
    $i_change = $_POST['i_change'];


    $where = "WHERE kredit_id = '$id'";
    $q_angsuran_kredit_tmp = select_config('angsuran_kredit_tmp',$where);
    $r_angsuran_kredit_tmp = mysql_fetch_array($q_angsuran_kredit_tmp);
    $count_angsuran = get_count_angsuran_kredit($transaction_id);

    if ($count_angsuran == 0) {
      $data_angsuran_kredit = "'',
                               '$member_id',
                               '$transaction_id',
                               '$id',
                               '".$r_angsuran_kredit_tmp['lama_angsuran']."',
                               '".$r_angsuran_kredit_tmp['angsuran_nominal']."',
                               '".$r_angsuran_kredit_tmp['total_kredit']."'
                               ";
      create_config('angsuran_kredit', $data_angsuran_kredit);
      $angsuran_kredit_id = mysql_insert_id();
    } else {
      $where_angsuran_kredit_id = "WHERE transaction_id = '$transaction_id'";
      $angsuran_kredit_id = select_config_by('angsuran_kredit','angsuran_kredit_id', $where_angsuran_kredit_id);
    }

    $where = "WHERE angsuran_kredit_id = '".$r_angsuran_kredit_tmp['angsuran_kredit_id']."'";
    $q_angsuran_kredit_tmp = select_config('angsuran_kredit_details_tmp', $where);

    $angsuran_kredit_details_code = "AK_".time()."";
    if ($payment_method == 3) {
      $i_bank_id = $_POST['i_bank_id'];
      $i_bank_account = $_POST['i_bank_account'];
      $i_bank_id_to = $_POST['i_bank_id_to'];
      $i_bank_account_to = $_POST['i_bank_account_to'];
    }
    while ($r_angsuran_kredit_tmp = mysql_fetch_array($q_angsuran_kredit_tmp)) {
      $data_angsuran_kredit_details = "'',
                                       '$angsuran_kredit_details_code',
                                       '$angsuran_kredit_id',
                                       '".$r_angsuran_kredit_tmp['angsuran_date']."',
                                       '$payment_method',
                                       '$i_bank_id',
                                       '$i_bank_account',
                                       '$i_bank_id_to',
                                       '$i_bank_account_to',
                                       '".$r_angsuran_kredit_tmp['angsuran_nominal']."',
                                       '$i_payment',
                                       '$i_change',
                                       '".$r_angsuran_kredit_tmp['denda_nominal']."',
                                       '".$r_angsuran_kredit_tmp['denda_persen']."',
                                       '".$r_angsuran_kredit_tmp['denda_persen_nominal']."',
                                       '".$_SESSION['user_id']."',
                                       '".$r_angsuran_kredit_tmp['ket']."'
                                       ";
      create_config('angsuran_kredit_details', $data_angsuran_kredit_details);
      $angsuran_kredit_details_id = mysql_insert_id();
    }
    $where = "WHERE kredit_id = '$id'";
    $lama_angsuran = select_config_by('kredit', 'lama_angsuran', $where);
    $yang_sudah_diangsur = get_count_yang_sudah_diangsur($angsuran_kredit_id);
    $count_angsuran = $count_angsuran + $yang_sudah_diangsur;
    if ($lama_angsuran == $count_angsuran) {
      $data = "lunas = 2";
      update_config('transactions',$data,'transaction_id',$transaction_id);
      update_config('kredit',$data,'transaction_id',$transaction_id);
    }
    $where = "WHERE kredit_id = '$id'";
    $angsuran_kredit_id_tmp = select_config_by('angsuran_kredit_tmp', 'angsuran_kredit_id', $where);

    $param = "kredit_id = '$id'";
    delete_config('angsuran_kredit_tmp', $param);

    $param_detail = "angsuran_kredit_id = '$angsuran_kredit_id_tmp'";
    delete_config('angsuran_kredit_details_tmp', $param_detail);

    header("Location: print.php?page=print_angsuran_piutang&id=$id&angsuran_kredit_details_code=$angsuran_kredit_details_code");
    break;

    case 'get_bank_name':
      $bank_id = $_POST['bank_id'];
      $where = "WHERE bank_id = '$bank_id'";
      $bank_account_number = select_config_by('banks', 'bank_account_number', $where);
      echo json_encode($bank_account_number);
      break;

  case 'telat_bayar_popmodal':
    include '../views/angsuran/telat_bayar_popmodal.php';
    break;
}
 ?>
