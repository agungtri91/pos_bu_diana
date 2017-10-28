<?php

function select(){
	$query = mysql_query("SELECT a.* FROM items a");
	return $query;
}

function select_unit(){
	$query = mysql_query("SELECT * FROM units ORDER BY unit_id");
	return $query;
}

function select_item_type(){
	$query = mysql_query("select * from items_types order by item_type_id");
	return $query;
}

function select_kat_item(){
	$query = mysql_query("SELECT * FROM kategori ORDER BY kategori_id");
	return $query;
}

function select_branch($where){
	$query = mysql_query("select * from branches $where order by branch_id");
	return $query;
}

function update_stock_unit($unit_konversi_id,$data){
		mysql_query("UPDATE unit_konversi SET ".$data." WHERE unit_konversi_id = '$unit_konversi_id'");
}

function read_id($id){
	$query = mysql_query("SELECT a.*, b.*, c.unit_name
												FROM items a
												LEFT JOIN item_harga b ON b.item_id = a.item_id
												LEFT JOIN units c ON c.unit_id = a.unit_id
												WHERE a.item_id = '$id'");
	$result = mysql_fetch_object($query);
	return $result;
}

function read_id_unit($unit_konversi){
	$query = mysql_query("SELECT * FROM unit_konversi WHERE unit_konversi_id = '$unit_konversi'");
	$result = mysql_fetch_object($query);
	return $result;
}

function read_detail($id){
	$query = mysql_query("select * from item_details where item_id = '$id'");
	$result = mysql_fetch_object($query);
	return $result;
}


function read_unit_konversi($id){
	$query = mysql_query("select * from unit_konversi where item_id = '$id'");
	$result = mysql_fetch_object($query);
	return $result;
}


function create($data){
	mysql_query("insert into items values(".$data.")");
}

function update($data, $id, $s_cabang){
	mysql_query("update items set ".$data." where item_id = '$id'");
}
function update_detail($data_detail,$id,$item_berat,$item_p,$item_l,$item_t,$item_penerbit,$item_desc){
	$query = mysql_query("SELECT count(*) as result from item_details where item_id = '$id'");
	$row = mysql_fetch_array($query);
	if($row['result']>0){
		$conn = mysql_query("update item_details set $data_detail where item_id = '$id'");
	}else {
		mysql_query("insert into item_details values('','$id','$item_berat','$item_p','$item_l','$item_t','$item_penerbit','$item_desc')");
	}
}

function get_stock($item_id, $s_cabang){
	$query = mysql_query("select item_stock_qty as result from item_stocks
												where branch_id = '$s_cabang'
												and item_id = '$item_id'
												");
	$row = mysql_fetch_array($query);
	// var_dump($branch_id);
	$result = ($row['result']) ? $row['result'] : "0";
	return $result;
}


function get_img_old($id){
	$query = mysql_query("select stock_img from items
						where item_id = '".$id."'");
	$result = mysql_fetch_array($query);
	$row = $result['stock_img'];
	return $row;
}

function delete($id){
	mysql_query("delete from items where item_id = '$id'");
	$query=mysql_query("select * from item_details WHERE item_id = '$id'");
	while ($row=mysql_fetch_array($query)) {
		mysql_query("delete from item_details where item_id = '$id'");
	}
	$q_unit=mysql_query("select * from unit_konversi WHERE item_id = '$id'");
	while ($r_unit=mysql_fetch_array($q_unit)) {
		mysql_query("delete from unit_konversi where item_id = '$id'");
	}
}

function get_item_id(){
	$query = mysql_query("select max(item_id) as result from items");
	$result = mysql_fetch_array($query);
	$row = $result['result'];
	return $row;
}

function create_item_detail($data){
	mysql_query("insert into item_details values(".$data.")");
}

function select_kategori($id,$item_id){
	$query = mysql_query("SELECT a.sub_kategori_name, a.sub_kategori_id, id FROM sub_kategori a
												left join (select sub_kategori_id as id from items where
														item_id = '$item_id'
													) AS b ON b.id = a.sub_kategori_id
												WHERE a.kategori_utama_id = '$id'");
	return $query;
}

function select_unit_turunan($id){
	$query = mysql_query("SELECT * FROM units WHERE unit_id != '$id'");
	return $query;
}

function get_new_date($id,$branch_id){
	$query = mysql_query("SELECT a.*, d.*,MAX(d.purchase_date)  AS new_date FROM item_stocks a
												JOIN purchases_details d ON d.item_id = a.item_id
												WHERE a.item_id = '$id' and a.branch_id = '$branch_id'");
	$r_new_date = mysql_fetch_array($query);
	$id= ($r_new_date['new_date']) ? $r_new_date['new_date'] : 0;
	return $id;

}

function get_unit_id_new_buy($id,$branch_id){
	$query = mysql_query("SELECT a.*, d.*,MAX(d.purchase_date)  AS new_date, e.unit_name FROM item_stocks a
												JOIN purchases_details d ON d.item_id = a.item_id
												LEFT JOIN items c ON c.item_id = a.item_id
												LEFT JOIN units e ON IF(d.unit_id != 0, e.unit_id = c.unit_id, e.unit_id = d.unit_id)
												WHERE a.item_id = '$id' and a.branch_id = '$branch_id'");
	$r_new_date = mysql_fetch_array($query);
	$id= ($r_new_date['unit_name']) ? $r_new_date['unit_name'] : "-";
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

function select_baru($data_baru, $id){
  $query = mysql_query("SELECT kode_barang as result FROM items WHERE kode_barang ='$data_baru' and item_id != '$id'");
  return $query;
}

?>
