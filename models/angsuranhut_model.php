<?php
  function select($s_cabang){
    $query = mysql_query("SELECT b.*, d.*, a.* FROM hutang a
                          JOIN purchases b ON b.supplier_id = a.purchase_id
                          LEFT JOIN  suppliers d ON d.supplier_id = b.supplier_id
                          WHERE b.lunas = 1 AND branch_id = '$s_cabang' GROUP BY b.supplier_id");
    return $query;
  }

  function select_supplier($id){
    $query = mysql_query("SELECT * FROM suppliers WHERE supplier_id = '$id'");
    return $query;
  }

  function get_purchase_id($id){
    $query = mysql_query("SELECT a.purchase_id FROM transactions a WHERE purchases = '".$id."'");
    return $query;
  }

  function   update_hutang($angsuran_byr,$id_hutang){
    mysql_query("UPDATE hutang SET angsuran_now = '".$angsuran_byr."' , hutang = hutang - '".$angsuran_byr."'  WHERE id_hutang = '".$id_hutang."'");
    }

  function   update_hutang1($angsuran_byr,$id_hutang){
    mysql_query("UPDATE hutang1 SET total_hutang = total_hutang - '".$angsuran_byr."'  WHERE id_hutang = '".$id_hutang."'");
    }

    function get_hutang($id){
      mysql_query("SELECT a.*, b.*, c.*, d.* FROM hutang a
                    JOIN purchases b ON b.id_2 = a.purchase_id
                    JOIN items c ON c.item_id = b.item_id
                    JOIN  suppliers d ON d.supplier_id = b.supplier_id WHERE a.id_hutang = '".$id."' AND b.lunas = 1");
      return $query;
    }

  function create_journal($data_id, $data_url, $journal_type_id, $journal_hutang, $i_payment_method, $i_bank_id,$i_bank_account,$i_bank_id_to,$i_bank_account_to,$s_cabang){
  	mysql_query("insert into journals values(
  				'',
  				'$journal_type_id',
  				'".time()."',
  				'$data_url',
  				'0',
  				'0',
  				'0',
          '',
  				'$journal_hutang',
  				'".date("Y-m-d")."',
          '$i_payment_method',
          '$i_bank_id',
          '$i_bank_account',
          '$i_bank_id_to',
          '$i_bank_account_to',
  				'".$_SESSION['user_id']."',
          '$s_cabang'
  	)");
  }

  function create_pengangsuran_hutang($data){
    mysql_query("insert into pengangsuran_hut values(".$data.")");
  }
  function check_cicilan($purchase_id){
    $query = mysql_query("SELECT hutang FROM hutang WHERE purchase_id = '".$purchase_id."'");
    $r_hutang = mysql_fetch_array($query);
    $hutang = $r_hutang['hutang'];
    return $hutang;
  }

  function update_purchase($purchase_id,$id,$angsuran_byr){
    mysql_query("update purchases set lunas = 2 WHERE purchases_id = '".$purchase_id."'");
    mysql_query("UPDATE hutang1 SET total_hutang = total_hutang - '".$angsuran_byr."'  WHERE id_hutang = '".$id."'");
    // mysql_query("delete from hutang1 WHERE id_hutang = '".$id."'");
    // mysql_query("delete from hutang WHERE purchase_id = '".$purchase_id."'");
  }
  // function update_invoice($id,$i_payment){
  //     mysql_query("UPDATE hutang SET angsuran_now = '".$angsuran_byr."' , hutang = hutang - '".$angsuran_byr."'  WHERE id_hutang = '".$id_hutang."'");
  // }

 ?>
