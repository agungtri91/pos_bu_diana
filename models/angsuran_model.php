<?php
  function select($s_cabang){
    $query = mysql_query("SELECT a.*,b.transaction_code, SUM(c.harga_item) AS total_harga, SUM(c.uang_muka_barang) AS uang_muka,
                          SUM(c.harga_item)-SUM(c.uang_muka_barang) AS total_piutang
                          FROM members a LEFT JOIN transactions b ON b.member_id = a.member_id
                          LEFT JOIN kredit c ON c.transaction_id = b.transaction_id
                          WHERE b.lunas = 1 AND b.branch_id = '$s_cabang' GROUP BY a.member_id");
    return $query;
  }

  function select_piutang_pembeli($id){
    $query = mysql_query("SELECT a.*, d.user_name AS admin FROM kredit a
                          -- LEFT JOIN angsuran_kredit b on b.kredit_id = a.kredit_id
                          -- LEFT JOIN angsuran_kredit_details c on c.angsuran_kredit_id = b.angsuran_kredit_id
                          LEFT JOIN users d on d.user_id = a.user_id
                          WHERE a.member_id = '$id'");
    return $query;
  }

  function select_piutang_pembeli_detail($id){
    $query = mysql_query("SELECT a.*, b.* FROM kredit a
                          LEFT JOIN transactions b on b.transaction_id = a.transaction_id
                          WHERE a.kredit_id = '$id'");
    return $query;
  }

  function select_trans_kredit($id){
    $query = mysql_query("SELECT a.*, a.lama_angsuran AS lama, b.*, c.*, d.*, e.*, count(e.angsuran_kredit_details_id) as pengangsuran FROM kredit a
                          LEFT JOIN items b on b.item_id = a.item_id
                          LEFT JOIN item_harga c on c.item_id = a.item_id
                          LEFT JOIN angsuran_kredit d on d.kredit_id = a.kredit_id
                          LEFT JOIN angsuran_kredit_details e on e.angsuran_kredit_id = d.angsuran_kredit_id
                          WHERE a.kredit_id = '$id'
                          GROUP by a.kredit_id");
    return $query;
  }

  function get_count_angsuran_kredit($id){
    $query = mysql_query("SELECT count(*) as result FROM angsuran_kredit WHERE transaction_id = '$id'");
    $row = mysql_fetch_array($query);
    $result = $row['result'];
    return $result;
  }

  function get_count_yang_sudah_diangsur($id){
    $query = mysql_query("SELECT COUNT(*) as result FROM angsuran_kredit_details WHERE angsuran_kredit_id = '$id'");
    $row = mysql_fetch_array($query);
    $result = $row['result'];
    return $result;
  }

  function get_denda_nominal($id){
    $query = mysql_query("SELECT denda_nominal as result FROM denda WHERE jenis_denda = '$id'");
    $row = mysql_fetch_array($query);
    $result = $row['result'];
    return $result;
  }

  function get_denda_persen($id){
    $query = mysql_query("SELECT denda_persen as result FROM denda WHERE jenis_denda = '$id'");
    $row = mysql_fetch_array($query);
    $result = $row['result'];
    return $result;
  }

  function create_journal($data_id, $data_url, $journal_type_id, $i_payment_method, $journal_piutang, $i_bank_id,
  $i_bank_account,$i_bank_id_to,$i_bank_account_to,$s_cabang){
  	mysql_query("insert into journals values(
  				'',
  				'$journal_type_id',
  				'".time()."',
  				'$data_url',
          '$journal_piutang',
  				'0',
  				'0',
  				'0',
          '',
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
 ?>
