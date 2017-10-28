<?php
include '../lib/config.php';
include '../lib/function.php';
include '../models/retur_model.php';
$page = null;
$page = (isset($_GET['page'])) ? $_GET['page'] : "list";
$title = ucfirst("RETUR PENJUALAN");

$_SESSION['menu_active'] = 4;
$_SESSION['sub_menu_active'] = 34;
$permit = get_akses_permits($_SESSION['user_type_id'],$_SESSION['sub_menu_active']);
switch ($page) {
  case 'list':
  get_header($title);
  $query = select();
  include '../views/retur/retur_list.php';
  get_footer();
  break;

  case 'search':
  $id = $_POST['x'];
  $query = select_transacation($id);
  while($r_trans = mysql_fetch_array($query)){
    if ($r_trans['lunas']==1) {
      $lunas = 'Belum lunas';
    }elseif ($r_trans['lunas']==2) {
      $lunas = 'Sudah lunas';
    }else {
      $lunas = 'Lunas';
    }
    $item_id = $r_trans['item_id'];
    $where_transaction_id_item_id = "WHERE transaction_id = '$id' AND item_id = '$item_id'";

    $unit_id_retur = select_config_by('stock_retur_details_penjualan', 'item_stock_real', $where_transaction_id_item_id);
    $retur = select_config_by('stock_retur_details_penjualan', 'item_stock_real', $where_transaction_id_item_id);
    $where_item_id = "WHERE item_id = '$item_id'";
    $unit_id_utama = select_config_by('items', 'unit_id', $where_item_id);
    $where_unit_id_utama = "WHERE unit_id = '$unit_id_utama'";
    $unit_utama_name = select_config_by('units', 'unit_name', $where_unit_id_utama);


    if ($unit_id_utama != $unit_id_retur) {
      $jml_stock_satuan_utama = konversi_ke_satuan_utama($item_id, $unit_id_retur, $r_trans['transaction_detail_qty']);
    }
    $jml_stock_setelah_retur = $r_trans['transaction_detail_qty'];
    if ($retur > 0) {
      $jml_stock_setelah_retur = $jml_stock_satuan_utama - $retur;
    }

    $member_phone = $r_trans['member_phone'] ? $r_trans['member_phone']: "";
    $data[] = array(
      'transaction_detail_id'                 => $r_trans['transaction_detail_id'],
      'transaction_id'                        => $r_trans['transaction_id'],
      'lunas'                                 => $lunas,
      'member_name'                           => $r_trans['member_name'],
      'member_alamat'                         => $r_trans['member_alamat'],
      'member_phone'                          => $member_phone,
      'member_email'                          => $r_trans['member_email'],
      'member_discount'                       => $r_trans['member_discount'],
      'member_id'                             => $r_trans['member_id'],
      'item_name'                             => $r_trans['item_name'],
      'transaction_detail_price'              => $r_trans['transaction_detail_price'],
      'transaction_detail_grand_price'        => $r_trans['transaction_detail_grand_price'],
      'retur'                                 => $r_trans['retur'],
      'transaction_detail_qty'                => $jml_stock_setelah_retur,
      'transaction_detail_qty_setelah_retur'  => $retur ? $retur : "",
      'transaction_detail_total'              => $r_trans['transaction_detail_total'],
      'transaction_code'                      => $r_trans['transaction_code'],
      'transaction_detail_persen_discount'    => $r_trans['transaction_detail_persen_discount'],
      'transaction_detail_nominal_discount'   => $r_trans['transaction_detail_nominal_discount'],
      'unit_id_utama'                         => $unit_id_utama,
      'unit_utama_name'                       => $unit_utama_name,
      'unit_name'                             => $r_trans['unit_jual_name'],
      'item_id'                               => $r_trans['item_id'],
      'total_all'                             => $r_trans['total_all'],
    );
  };
  $menu['status'] = '200';
  echo json_encode($data);
    break;

    case 'retur_item_popmodal':
      $id = $_GET['id'];
      $item_id = $_GET['item_id'];
      $transaction_id = $_GET['transaction_id'];
      $q_item = get_item_name($item_id);
      $r_item = mysql_fetch_array($q_item);
      $item_name = $r_item['item_name'];
      $retur = get_transaction_retur($id);
      $unit_id_jual = get_unit_jual($id);
      $unit_jual_name = get_unit_jual_name($id);
      $transaction_detail_qty = get_transaction_detail_qty($id);
      $stock_retur_tmp = get_stock_retur_tmp($id, $unit_id_jual);
      $q_item_satuan = select_satuan_item($item_id,$id);
      $harga_jual = get_harga_jual($item_id);
      $qty = $transaction_detail_qty- ($retur + $stock_retur_tmp);
      include '../views/retur/popmodal.php';
      break;

    case 'save_tmp':

    $id = $_POST['transaction_detail_id'];
    var_dump($id);
    $transaction_id = $_POST['transaction_id'];
    $i_qty_popmodal = $_POST['i_qty_popmodal'];
    $i_desc = $_POST['i_desc'];
    $item_id = $_POST['i_item_id_popmodal'];
    $harga_konversi = $_POST['harga_konversi'];
    $i_unit_retur = $_POST['i_unit'];
    $i_unit_jual = $_POST['i_unit_jual'];
    if ($i_unit_retur == 0) {
      $i_unit_retur = $_POST['i_unit_jual'];
    }
    $total = $harga_konversi * $i_qty_popmodal;
    $data="'',
          '$transaction_id',
          '$id',
          '".$_SESSION['user_id']."',
          '$item_id',
          '$i_qty_popmodal',
          '$i_unit_jual',
          '$i_unit_retur',
          '$harga_konversi',
          '$total',
          '$i_desc'
          ";
    $_SESSION['transaction_id'] = $transaction_id;
    // // // unset($_SESSION['transaction_id']);
    create_retur_tmp($data);
    var_dump($data);
    header("Location: retur.php?page=list");
    break;

    //widget
    case 'delete_widget':

    $id = get_isset($_GET['id']);
    // $transaction_id = get_isset($_GET['transaction_id']);
    var_dump($id);
    delete_config("retur_tmp", "retur_tmp_id = '$id'");
    // delete_config("widget_tmp_details", "wt_id = '$id'");

    header("Location: retur.php?page=list");

    break;

    case 'reset':

    $transaction_id = get_isset($_GET['transaction_id']);
    // hapus retur_tmp
    $q_retur_tmp = mysql_query("select * from retur_tmp where transaction_id = '$transaction_id'");
    while($r_retur_tmp = mysql_fetch_array($q_retur_tmp)){
      delete_retur_tmp($transaction_id);
    }
    unset($_SESSION['transaction_id']);
    // session_destroy($_SESSION['transaction_id']);
    header("Location: retur.php?page=list");
    break;

    case 'save_retur':

    $transaction_id = get_isset($_GET['transaction_id']);
    $i_transaction_id = get_isset($transaction_id);
    $retur_price = get_isset($_GET['retur_price']);
    $query=select_retur_tmp($transaction_id);
    $r_retur_tmp=mysql_fetch_array($query);
    $now_date = date("Y-m-d m:i:s");
    if ($retur_price>0) {
      $data = "'',
      '".$r_retur_tmp['transaction_id']."',
      '".$now_date."',
      '".$r_retur_tmp['transaction_date']."',
      '".$retur_price."',
      '".$_SESSION['user_id']."',
      '".$r_retur_tmp['lunas']."'
      ";
      // var_dump($data);
      create_config("retur_tmp1",$data);
      $q_retur_detail = select_retur_detail($transaction_id);
      while ($r_retur_detail=mysql_fetch_array($q_retur_detail)) {
        $total = $r_retur_detail['harga_konversi'] * $r_retur_detail['item_qty'];
        $data_detail = "'',
                       '".$r_retur_detail['transaction_id']."',
                       '".$r_retur_detail['transaction_detail_id']."',
                       '".$r_retur_detail['item_id']."',
                       '".$r_retur_detail['item_qty']."',
                       '".$r_retur_detail['unit_id_retur']."',
                       '".$r_retur_detail['harga_konversi']."',
                       '$total',
                       '".$r_retur_detail['retur_desc']."'
                       ";
        var_dump($data_detail);
        create_config("retur_details_tmp",$data_detail);
      }
        header("Location: retur.php?page=pay_retur&transaction_id=$transaction_id");
    }else {
      header("Location: retur.php?page=list&err=1&transaction_id=$transaction_id");
    }
    break;

    case 'pay_retur':
      $transaction_id = $_GET['transaction_id'];
      $i_transaction_id = get_isset($transaction_id);
      $q_member = select_member_retur($transaction_id);
      $r_member = mysql_fetch_array($q_member);
      $transaction_code = get_transaction_code($transaction_id);
      $q_retur_tmp = select_retur_tmp($transaction_id);
      $r_retur_tmp = mysql_fetch_array($q_retur_tmp);
      $total = $r_retur_tmp['harga_konversi'] * $r_retur_tmp['item_qty'];
      $where = '';
      $q_bank_to = select_config('banks', $where);

      $action="retur.php?page=pay_retur2";


      $close = "retur.php?page=close&transaction_id=$transaction_id";

      include '../views/retur/pay_retur.php';
      break;

    case 'close':

    $transaction_id = get_isset($_GET['transaction_id']);
    $i_transaction_id = get_isset($transaction_id);
    // hapus retur_tmp
    $where_transaction_id = "WHERE transaction_id = '$i_transaction_id'";
    $q_retur_tmp = select_config('retur_tmp1', $where_transaction_id);
    while($r_retur_tmp = mysql_fetch_array($q_retur_tmp)){
      delete_retur_tmp1($transaction_id);
      delete_retur_details_tmp1($i_transaction_id);
    }
    header("Location: retur.php?page=list");
      break;

    case 'pay_retur2':
      $i_transaction_id = $_POST['i_transaction_id'];
      $i_payment_method = $_POST['i_payment_method'];
      $i_payment        = $_POST['i_payment'];
      $q_retur_tmp      = select_retur_tmp1($i_transaction_id);
      $r_retur_tmp      = mysql_fetch_array($q_retur_tmp);
      $i_change         = $_POST['i_change'];

      $data_url='retur.php?page=pay_retur';

      if ($i_payment_method==1) {
        $i_bank_id = '';
        $i_bank_id_to = '';
        $i_bank_account = '';
        $i_bank_account_to = '';
        $data = "'',
                '".$r_retur_tmp['transaction_id']."',
                '".$r_retur_tmp['transaction_date']."',
                '".$r_retur_tmp['retur_date']."',
                '1',
                '0',
                '0',
                '0',
                '0',
                '".$_SESSION['user_id']."',
                '".$r_retur_tmp['retur_total_price']."',
                '$i_payment',
                '$i_change',
                '".$r_retur_tmp['lunas']."'
                ";
      } elseif ($i_payment_method==2||$i_payment_method==3) {
        $i_bank_id = $_POST['i_bank_id'];
        $i_bank_id_to = $_POST['i_bank_id_to'];
        $i_bank_account = $_POST['i_bank_account'];
        $i_bank_account_to = $_POST['i_bank_account_to'];
        $data = "'',
                '".$r_retur_tmp['transaction_id']."',
                '".$r_retur_tmp['transaction_date']."',
                '".$r_retur_tmp['retur_date']."',
                '$i_payment_method',
                '$i_bank_id',
                '$i_bank_account',
                '$i_bank_id_to',
                '$i_bank_account_to',
                '".$_SESSION['user_id']."',
                '".$r_retur_tmp['retur_total_price']."',
                '$i_payment',
                '$i_change',
                '".$r_retur_tmp['lunas']."'
                ";
      }

      create_config("retur",$data);
      $retur_id = mysql_insert_id();

      if($r_retur_tmp['lunas']==0||$r_retur_tmp['lunas']==2){
        create_journal($i_transaction_id,$data_url,'7',$i_payment_method,$r_retur_tmp['retur_total_price'],
        $r_retur_tmp['retur_date'],$_SESSION['user_id'],$i_bank_id,$i_bank_account,$i_bank_id_to,$i_bank_account_to);
      } else {
        create_journal($i_transaction_id,$data_url,'7',$i_payment_method,'',
        $r_retur_tmp['retur_date'],$_SESSION['user_id'],'','','','');
      }

      $q_retur_detail = select_retur_detail_tmp($i_transaction_id);

      while ($r_retur_detail=mysql_fetch_array($q_retur_detail)) {
        $data_detail = "'',
                      '$retur_id',
                      '".$r_retur_detail['transaction_id']."',
                      '".$r_retur_detail['transaction_detail_id']."',
                      '".$r_retur_detail['item_id']."',
                      '".$r_retur_detail['item_qty']."',
                      '".$r_retur_detail['unit_id']."',
                      '".$r_retur_detail['item_price']."',
                      '".$r_retur_detail['item_price_total']."',
                      '".$r_retur_detail['retur_desc']."'
                      ";
        create_config("retur_details",$data_detail);
        $item_id = $r_retur_detail['item_id'];
        $unit_id = $r_retur_detail['unit_id'];
        $qty = $r_retur_detail['item_qty'];
        $qty_real = konversi_qty($item_id, $unit_id,$qty);
        $q_transaction = select_transacation($i_transaction_id);
        $transaction_detail_id = get_transaction_detail_id($i_transaction_id,$item_id);
        $r_transaction = mysql_fetch_array($q_transaction);
        $member_id = $r_transaction['member_id'];

        $data_stock_retur = "'',
                             '$item_id',
                             '$qty_real',
                             '$s_cabang'
                             ";

        $data_stock_retur_detail = "'',
                                    '$item_id',
                                    '$member_id',
                                    '$i_transaction_id',
                                    '$transaction_detail_id',
                                    '$qty_real',
                                    '$qty',
                                    '$unit_id',
                                    '".$r_retur_tmp['transaction_date']."'
                                    ";

        update_stock($qty, $item_id, $data_stock_retur, $data_stock_retur_detail);
      }
      $q_retur_tmp_2 = select_retur_tmp1($i_transaction_id);
      while($r_retur_tmp = mysql_fetch_array($q_retur_tmp_2)){

        delete_retur_tmp($i_transaction_id);
        delete_retur_tmp1($i_transaction_id);
        delete_retur_details_tmp1($i_transaction_id);

      }
      unset($_SESSION['transaction_id']);
      header("Location: print.php?page=print_retur_penjualan&transaction_id=$i_transaction_id&retur_id=$retur_id");
      break;

    case 'bank_to':

    $id = $_POST['x'];
    $query=mysql_query("SELECT * from banks WHERE bank_id = ".$id);
    $r_bank=mysql_fetch_array($query);
    $bank['data'][] = array(
      'bank_name'   => $r_bank['bank_name'],
      'bank_account_number' => $r_bank['bank_account_number'],
    );
    $menu['status'] = '200';
    echo json_encode($bank);
    break;

  case 'get_konversi':
    $i_unit_jual = $_POST['a'];
    $i_unit = $_POST['x'];
    $i_stock = $_POST['y'];
    $item_id = $_POST['z'];
    $unit_id_utama = get_unit_id_utama($item_id);
    $qty = konversi_qty_retur($item_id,$i_unit,$i_stock,$i_unit_jual, $unit_id_utama);
    $harga_konversi = get_harga_konversi($item_id,$i_unit,$i_stock,$i_unit_jual, $unit_id_utama);
    $data= array(
                  'qty'          	 => $qty,
                  'harga_konversi' => $harga_konversi,
               );
    echo json_encode($data);
    break;

  case 'kembali':
    $transaction_id = $_GET['id'];
    $q_retur_tmp_2 = select_retur_tmp1($transaction_id);
    while($r_retur_tmp = mysql_fetch_array($q_retur_tmp_2)){
      delete_retur_tmp1($transaction_id);
      delete_retur_details_tmp1($transaction_id);
    }
    header("Location: retur.php?page=list");
    break;

  case 'retur_widget_popmodal':
    $transaction_id = $_GET['id'];
    include '../views/retur/retur_widget_popmodal.php';
    break;

  }

  ?>
