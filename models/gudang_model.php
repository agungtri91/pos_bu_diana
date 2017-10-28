<?php
function select_gudang(){
  $query = mysql_query("SELECT a.* FROM gudang_identitas a");
  return $query;
}
function create($data){
  mysql_query("insert into gudang_identitas values(".$data.")");
}

function read_id($id){
  $query = mysql_query("SELECT * FROM gudang_identitas where gudang_id = ".$id);
  $result = mysql_fetch_object($query);
	return $result;
}

function update($data,$id){
    mysql_query("UPDATE gudang_identitas set ".$data." where gudang_id = ".$id);
}

function delete($id){
  mysql_query("DELETE FROM gudang_identitas WHERE gudang_id = ".$id);
}

function get_item_gudang($id){
  $query=mysql_query("SELECT a.*, b.*, c.item_type_name, SUM(a.item_qty) as tot_item FROM gudang a
                      JOIN items b ON b.item_id = a.item_id
                      LEFT JOIN items_types c on c.item_type_id = a.item_type
                      WHERE a.gudang_id = '$id' GROUP by a.item_id");
  return $query;
}

function get_gudang_name(){
  $query=mysql_query("SELECT a.* FROM gudang_identitas a ");
  return $query;
}
function get_gudang_detail_item($item_id,$gudang_id){
    $query = mysql_query("SELECT a.*,b.* ,d.item_name, e.supplier_name FROM purchases a
                           JOIN purchases_details b on b.purchase_id = a.purchases_id
                           JOIN gudang c on c.item_id = b.item_id
                           JOIN items d on d.item_id = b.item_id
                           JOIN suppliers e on e.supplier_id = a.supplier_id
                           WHERE b.item_id = '$item_id' and c.gudang_id = '$gudang_id'");
    return $query;
}

function get_branch_name(){
  $query=mysql_query("SELECT a.* FROM branches a ");
  return $query;
}

function get_item_type($id){
  $query=mysql_query("SELECT item_type FROM gudang WHERE item_id = ".$id);
  $row = mysql_fetch_array($query);
	return $row['item_type'];
}

function get_supplier_id($id,$i_gudang_id){
  $query=mysql_query("SELECT supplier_id FROM gudang WHERE item_id = '$id' and gudang_id = '$i_gudang_id'");
  $row = mysql_fetch_array($query);
	return $row['supplier_id'];
}

function kirim_cabang($item_type,$i_item_id,$i_cabang_tujuan,$i_item_qty){
  $q_cabang = mysql_query("SELECT COUNT(item_id) as result FROM item_stocks WHERE item_id = '$i_item_id' and branch_id = '".$i_cabang_tujuan."'");
  $result_cabang = mysql_fetch_array($q_cabang);
  if($result_cabang['result'] > 0){
    mysql_query("update item_stocks set item_stock_qty = item_stock_qty + $i_item_qty where item_id = $i_item_id and branch_id = '$i_cabang_tujuan'");
	}else{
    mysql_query("insert into item_stocks values('', $i_item_id, $item_type, $i_item_qty,$i_cabang_tujuan)");
  }
}

function kirim_gudang($item_type,$i_item_id,$i_gudang_tujuan,$i_item_qty){
  $q_gudang = mysql_query("SELECT COUNT(*) as result FROM gudang WHERE item_id = '$i_item_id' and gudang_id = '$i_gudang_tujuan'");
  $result_gudang = mysql_fetch_array($q_gudang);
  if($result_gudang['result'] > 0){
    mysql_query("update gudang set item_qty = item_qty + $i_item_qty where item_id = $i_item_id and gudang_id = $i_gudang_tujuan");
	}else{
    mysql_query("insert into gudang values('', $i_gudang_tujuan, $item_type, $i_item_id, $i_item_qty)");
  }
}

function create_journal_mutasi($kirim_status,$now_date,$i_gudang_id,$i_gudang_tujuan){
  mysql_query("insert into mutasi_barang values(
        '',
        '".time()."',
        '$kirim_status',
        '$now_date',
        '$i_gudang_id',
        '$i_gudang_tujuan'
  )");
}

function update_item_gudang($i_gudang_id,$i_item_id,$i_item_qty){
  mysql_query("update gudang set item_qty = item_qty - $i_item_qty WHERE item_id= '$i_item_id' and gudang_id='$i_gudang_id'");
}
// function update_item_gudang_tujuan($i_gudang_id,$i_item_id,$i_item_qty){
//   mysql_query("update gudang set item_qty = item_qty + $i_item_qty WHERE item_id= '$i_item_id' and gudang_id='$i_gudang_id'");
// }
// function update_item_cabang_tujuan($i_cabang_tujuan,$i_item_id,$i_item_qty){
//   mysql_query("update item_stocks set item_stock_qty = item_stock_qty + $i_item_qty WHERE item_id= '$i_item_id' and branch_id='$i_cabang_tujuan'");
// }

function get_id_mutasi(){
  $query = mysql_query("SELECT max(id_mutasi) as result FROM mutasi_barang");
  $r_id= mysql_fetch_array($query);
  return $r_id['result'];
}

function create_mutasi($data){
  mysql_query("insert into mutasi_barang values(".$data.")");
}

function create_mutasi_details($data){
  mysql_query("insert into mutasi_details values(".$data.")");
}

function get_gudang_name2($id){
  $query = mysql_query("SELECT gudang_name FROM gudang_identitas WHERE gudang_id =".$id);
  $r_gudang= mysql_fetch_array($query);
  return $r_gudang['gudang_name'];
}

function get_all_item($id){
  $query = mysql_query("SELECT count(*) as total FROM mutasi_tmp WHERE gudang_id =".$id);
  $row= mysql_fetch_array($query);
  $jumlah = ($row['total']) ? $row['total'] : 0;
  return $jumlah;
}

function create_mutasi_tmp($data){
  mysql_query("insert into mutasi_tmp values(".$data.")");
}

function get_mutasi_tmp($id){
  $query = mysql_query("SELECT * FROM mutasi_tmp WHERE gudang_id =".$id);
  return $query;
}

function get_mutasi_tmp_details($id){
  $query = mysql_query("SELECT * FROM mutasi_details WHERE mutasi_id =".$id);
  return $query;
}

function delete_mutasi_tmp($id){
  $query=mysql_query("SELECT * FROM mutasi_tmp WHERE gudang_id = ".$id);
  while ($row = mysql_fetch_array($query)) {
    mysql_query("delete from mutasi_tmp  where gudang_id = '$id'");
  }
}

function delete_widget($id){
  mysql_query("DELETE FROM mutasi_tmp WHERE item_id = ".$id);
}

function reset_widget($id){
  mysql_query("DELETE FROM mutasi_tmp WHERE gudang_id = ".$id);
}
 ?>
