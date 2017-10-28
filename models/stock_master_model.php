<?php
  function select($where){
    $query = mysql_query("SELECT a.*, b.*, d.item_price, e.branch_name FROM item_stocks a
                          LEFT JOIN items b ON b.item_id = a.item_id
                          LEFT JOIN item_harga d on d.item_id = a.item_id
                          LEFT JOIN branches e on e.branch_id = a.branch_id
                          $where group by a.item_id order by a.item_id ");
    return $query;
  }

  function read_id($id,$branch_id){
    $query = mysql_query("SELECT a.*, b.*, c.item_type_name FROM item_stocks a
                          JOIN items b ON b.item_id = a.item_id
                          left JOIN items_types c ON c.item_type_id = b.item_type where a.item_id = '$id' and a.branch_id = '$branch_id' ");
    $result = mysql_fetch_object($query);
  	return $result;
  }

  function read_stock($id,$branch_id){
    $query = mysql_query("SELECT a.*, d.* FROM item_stocks a
                          left JOIN item_harga d on d.item_id = a.item_id
                          where a.item_id = '$id' and a.branch_id = '$branch_id'");
    $result = mysql_fetch_object($query);
  	return $result;
  }
  function get_new_date($id,$branch_id){
    $query = mysql_query("SELECT a.*, d.*,MAX(d.purchase_date)  AS new_date FROM item_stocks a
                          JOIN purchases_details d ON d.item_id = a.item_id
                          WHERE a.item_id = '$id' and a.branch_id = '$branch_id'");
    $r_new_date = mysql_fetch_array($query);
    $id= ($r_new_date['new_date']) ? $r_new_date['new_date'] : 0;
  	return $id;

  }
  function read_stock_buy($id, $branch_id){
    $query = mysql_query("SELECT a.*, d.* FROM item_stocks a
                          JOIN purchases_details d on d.item_id = a.item_id
                          where d.purchase_date = '$id' and branch_id = '$branch_id'");
    $read_stock_buy = mysql_fetch_array($query);
    $id= ($read_stock_buy['purchase_price']) ? $read_stock_buy['purchase_price'] : 0;
  	return $id;
  }

  function select_item_type(){
    $query=mysql_query("SELECT * FROM items_types");

    return $query;
  }

  function delete($id){
    mysql_query("delete from item_stocks where item_id = '$id'");
    mysql_query("delete from item_harga where item_id = '$id'");
  }

  function create_stock($data){
  	mysql_query("insert into item_harga values(".$data.")");
  }

  function get_id2($id){
    $query=mysql_query("SELECT * FROM item_harga where item_id = '$id'");
  }

  function update_stock($data, $item_id,$data_new){
    $query = mysql_query("SELECT count(*) as result FROM item_harga WHERE item_id ='$item_id'");
    $row = mysql_fetch_array($query);
    if($row['result']>0){
      mysql_query("update item_harga set $data where item_id = $item_id");
      }else {
      mysql_query("insert into item_harga values(".$data_new.")");
      }
    }

  function get_type_pembeli(){
    $query=mysql_query("SELECT * FROM type_pembeli");
    return $query;
  }

  function get_branch($id){
  	$query = mysql_query("SELECT branch_name FROM branches WHERE branch_id = '$id'");
  	$result = mysql_fetch_array($query);
  	$row = $result['branch_name'];
  	return $row;
  }

  function get_stock($item_id, $s_cabang, $unit_id){
  	$query = mysql_query("select item_stock_qty as result from item_stocks
  												where branch_id = '$s_cabang'
  												and item_id = '$item_id'
  												and unit_id = '$unit_id'
  												");
  	$row = mysql_fetch_array($query);
  	// var_dump($branch_id);
  	$result = ($row['result']) ? $row['result'] : "0";
  	return $result;
  }

  function select_item_purchase($id){
    $query = mysql_query("SELECT a.*, b.*, b.purchase_price as harga_item, b.purchase_total as harga_item_total, b.unit_id as unit_id_beli, c.*, e.unit_name AS unit_name_beli FROM purchases a
                          LEFT JOIN purchases_details b ON b.purchase_id  = a.purchases_id
                          LEFT JOIN suppliers c ON c.supplier_id = a.supplier_id
                          LEFT JOIN items d ON d.item_id = b.item_id
                          LEFT JOIN units e ON e.unit_id = d.unit_id
                          WHERE a.purchases_id = '$id'");
    return $query;
  }

  function select_item_penjualan($id){
    $query = mysql_query("SELECT a.*, b.*, b.transaction_detail_price AS harga_item, b.transaction_detail_total AS harga_item_total,
                          b.transaction_detail_unit AS unit_id_jual, c.*, e.unit_name AS unit_name_jual, f.unit_name as unit_name_jual FROM transactions a
                          LEFT JOIN transaction_details b ON b.transaction_id  = a.transaction_id
                          LEFT JOIN members c ON c.member_id = a.member_id
                          LEFT JOIN items d ON d.item_id = b.item_id
                          LEFT JOIN units e ON e.unit_id = b.transaction_detail_unit
                          LEFT JOIN units f ON f.unit_id = d.unit_id
                          WHERE a.transaction_id = '$id'");
    return $query;
  }

  function select_kategori_keterangan_details($id){
    $query = mysql_query("SELECT a.*, d.* FROM item_stocks a
			                    JOIN items b ON b.item_id = a.item_id
                          LEFT JOIN kategori_keterangan c ON c.kategori_id = b.kategori_id
                          LEFT JOIN item_keterangan_details d ON d.kategori_keterangan_id = c.kategori_keterangan_id
                          WHERE a.item_id = '$id'
                          ");
    return $query;
  }
 ?>
