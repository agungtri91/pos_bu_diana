<?php
include '../lib/config.php';
include '../lib/function.php';
include '../models/angsuranhut_model.php';

$page = null;
$page = (isset($_GET['page'])) ? $_GET['page'] : "list";
$title = ucfirst("ANGSURAN HUTANG");
$_SESSION['menu_active'] = 4;
$_SESSION['sub_menu_active'] = 24;
$s_cabang = $_SESSION['branch_id'];
$permit = get_akses_permits($_SESSION['user_type_id'],$_SESSION['sub_menu_active']);
  switch ($page) {
    case 'list':

    get_header($title);
    $query = select($s_cabang);
    include '../views/angsuran/listhutang.php';
    get_footer();
      break;

    case 'angsuranhut_v_2':

      $id = $_POST['x'];
      $query = mysql_query("SELECT a.*, b.*, c.*, d.*,e.* FROM hutang a
                            JOIN purchases b ON b.purchases_id = a.purchase_id
                            JOIN purchases_details e ON e.purchase_id = a.purchase_id
                            JOIN items c ON c.item_id = e.item_id
                            JOIN  suppliers d ON d.supplier_id = b.supplier_id WHERE b.supplier_id = '".$id."' AND a.hutang !=0 GROUP by purchases_code");
      while ($r_item = mysql_fetch_array($query)) {
        $data['data'][] = array(
          'id_hutang'         => $r_item['id_hutang'],
          'purchases_code'    => $r_item['purchases_code'],
          'purchase_price'    => $r_item['purchase_price'],
          'purchase_qty'      => $r_item['purchase_qty'],
          'purchase_total'    => $r_item['purchase_total'],
          'purchase_date'     => format_back_date3($r_item['purchase_date']),
          'batas_tanggal'     => format_back_date3($r_item['batas_tanggal']),
          'uang_muka'         => $r_item['uang_muka'],
          'hutang'            => $r_item['hutang'],
          'supplier_name'     => $r_item['supplier_name'],
        );
      }
    $data['status'] = '200';
    echo json_encode($data);
      break;

      case 'angsuranhut_v_4':

        $id = $_POST['x'];
        $query=mysql_query("SELECT a.*, b.*, c.*, d.* FROM hutang a
                            JOIN purchases b ON b.purchases_id = a.purchase_id
                            JOIN purchases_details c ON c.purchase_id = b.purchases_id
                            JOIN items d ON d.item_id = c.item_id
                            JOIN  suppliers e ON e.supplier_id = b.supplier_id WHERE a.id_hutang = '".$id."' AND b.lunas = 1");
        $r_angsuran = mysql_fetch_array($query);
         $data['data'][] = array(
           'id_hutang'         => $r_angsuran['id_hutang'],
           'item_name'         => $r_angsuran['item_name'],
           'purchase_price'    => $r_angsuran['purchase_price'],
           'purchase_qty'      => $r_angsuran['purchase_qty'],
           'purchase_date'     => $r_angsuran['purchase_date'],
           'batas_tanggal'     => $r_angsuran['batas_tanggal'],
           'uang_muka'         => $r_angsuran['uang_muka'],
           'hutang'            => $r_angsuran['hutang'],
           'now_date'          => date("Y-m-d m:i:s"),
         );
         echo json_encode($data);
        break;

        case 'save_angsuran_hut':

          $id = $_GET['id_hutang'];
          $q_hutang=mysql_query("SELECT a.*, b.*, c.*, d.*,e.* FROM hutang a
                              JOIN purchases b ON b.purchases_id = a.purchase_id
                              JOIN purchases_details c ON c.purchase_id = b.purchases_id
                              JOIN items d ON d.item_id = c.item_id
                              JOIN  suppliers e ON e.supplier_id = b.supplier_id WHERE a.id_hutang = '".$id."' AND b.lunas = 1");
          $r_hutang=mysql_fetch_array($q_hutang);
          $action = "angsuranhut.php?page=save_payment&id=$id";
          $q_supplier = select_supplier($r_hutang['supplier_id']);
          $r_supplier = mysql_fetch_array($q_supplier);
          include '../views/angsuran/pp_listhut.php';
          break;

        case 'save_payment':

              $id = $_GET['id'];
              $angsuran_byr = $_POST['i_payment'];
              $i_payment_method = $_POST['i_payment_method'];
              $purchase_id = $_POST['purchase_id'];
              $now_date = date("Y-m-d m:i:s");
              $i_bank_id = '';
              $i_bank_id_to = '';
              $i_bank_account = '';
              $i_bank_account_to = '';
              // var_dump($i_payment_method);
              if($i_payment_method < 2){
                $data_hutang="'',
                              '".$purchase_id."',
                              '".$id."',
                              '".$angsuran_byr."',
                              '1',
                              '0',
                              '0',
                              '0',
                              '0',
                              '$now_date'
                ";
              }elseif ($i_payment_method == 2||$i_payment_method == 3) {
                $i_bank_id = $_POST['i_bank_id'];
                $i_bank_id_to = $_POST['i_bank_id_to'];
                $i_bank_account = $_POST['i_bank_account'];
                $i_bank_account_to = $_POST['i_bank_account_to'];
                $data_hutang="'',
                              '".$purchase_id."',
                              '".$id."',
                              '".$angsuran_byr."',
                              '$i_payment_method',
                              '$i_bank_id',
                              '$i_bank_account',
                              '$i_bank_id_to',
                              '$i_bank_account_to',
                              '$now_date'
                ";
              }
              update_hutang($angsuran_byr,$id);
              update_hutang1($angsuran_byr,$id);
              create_pengangsuran_hutang($data_hutang);
              create_journal($id, "angsuran/pp_listhut.php", 5,$i_payment_method ,$angsuran_byr, $i_bank_id,
                             $i_bank_account,$i_bank_id_to,$i_bank_account_to,$s_cabanng);
              $check_cicilan = check_cicilan($purchase_id);
              // var_dump($check_cicilan);
              if($check_cicilan == 0){
                update_purchase($purchase_id,$id,$angsuran_byr);
              }
          	header("location: print.php?page=angsuran_hutang&id_hutang=$id&purchase_id=$purchase_id");
          break;
  }
?>
