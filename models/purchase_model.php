<?php

function select($where){
	$query = mysql_query("SELECT a.* , b.supplier_name,c.unit_name, d.item_name, e.branch_name
												FROM purchases a
												JOIN suppliers b ON b.supplier_id = a.supplier_id
												JOIN items d ON d.item_id = a.item_id
												JOIN units c ON c.unit_id = d.unit_id
												JOIN branches e ON e.branch_id = a.branch_id
												$WHERE
												ORDER BY purchase_id");
	return $query;
}

function select_baru($data_baru){
  $query = mysql_query("SELECT kode_barang as result FROM items WHERE kode_barang ='$data_baru'");
  return $query;
}

function select_purchases($id){
	$query = mysql_query("SELECT * FROM purchases_tmp
												where purchases_id = '$id'");
	return $query;
}

function select_purchases_details($id){
	$query = mysql_query("SELECT * FROM purchases_details_tmp
												where purchase_id = '".$id."'");
	return $query;
}
function select_supplier(){
	$query = mysql_query("select * from suppliers order by supplier_id ");
	return $query;
}

function select_kategori(){
	$query = mysql_query("SELECT * FROM kategori");
	return $query;
}

function get_konversi_qty($item_id,$i_unit,$i_qty){
	$qty = $i_qty;
	$query = mysql_query("SELECT * FROM unit_konversi WHERE item_id = '$item_id' and unit_konversi = '$i_unit'");
	$row = mysql_fetch_array($query);
	if ($row['unit_konversi_jml'] > $row['unit_jml']) {
		$qty = $i_qty / $row['unit_konversi_jml'];
	} else {
		$qty = $i_qty * $row['unit_jml'];
	}
	return $qty;
}

function select_item($where){
	$query = mysql_query("SELECT a.*, b.unit_name
												FROM items a
												JOIN units b ON b.unit_id = a.unit_id
												$where
												ORDER BY a.item_id");
	return $query;
}

function select_item_type(){
	$query = mysql_query("select * from kategori");
	return $query;
}


function select_branch(){
	$query = mysql_query("select * from branches order by branch_id");
	return $query;
}

function read_id($id){
	$query = mysql_query("select a.*,b.supplier_name
			from purchases a
			join suppliers b on b.supplier_id = a.supplier_id
			where purchase_id = '$id'");
	$result = mysql_fetch_object($query);
	return $result;
}

function get_item($id){
	$query=mysql_query("SELECT * from item_tmp WHERE purchases_id = '".$id."'");
	return $query;
}

function create($data){
	mysql_query("insert into purchases_tmp values(".$data.")");
}

function create_details($data){
	mysql_query("insert into purchases_details_tmp values(".$data.")");
}

function create_hutang($data){
	mysql_query("insert into hutang values(".$data.")");
}

function create_journal($data_id, $data_url, $journal_type_id, $i_payment_method, $journal_credit, $uang_sisa,
												$journal_desc, $i_bank_id, $i_bank_account, $i_bank_id_to, $i_bank_account_to, $s_cabang){
	mysql_query("insert into journals values(
				'',
				'$journal_type_id',
				'".time()."',
				'$data_url',
				'0',
				'$journal_credit',
				'0',
				'$uang_sisa',
				'$journal_desc',
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

function add_stock($item_id, $item_type, $i_supplier, $qty, $s_cabang, $unit_id){
		$q_branch = mysql_query("select count(item_id) as result from item_stocks
														 where item_id = $item_id
														 and branch_id = $s_cabang");
		$row = mysql_fetch_array($q_branch);
		$result = $row['result'];
		if($result == 0){
			mysql_query("insert into item_stocks values('', '$item_id', '$item_type', '$qty','$s_cabang')");
		}else{
			mysql_query("update item_stocks set item_stock_qty = item_stock_qty + $qty
									 where item_id = $item_id and branch_id = '$s_cabang'");
		}
	}
function update($data, $id){
	mysql_query("update purchases set ".$data." where purchase_id = '$id'");
}

function delete_item_tmp($id){
	mysql_query("delete from item_tmp where purchases_id = '$id'");
}

function delete_purchases_details_tmp($id){
	mysql_query("delete from purchases_details_tmp where purchase_id = '$id'");
}

function delete_purchases_tmp($id){
	mysql_query("delete from purchases_tmp where purchases_id = '$id'");
}

function get_item_type($item_id){
	$query = mysql_query("select item_type result from items where item_id= '$item_id'");
	$row = mysql_fetch_array($query);

	$result = ($row['result']);
	return $result;
}

function select_item_tmp($id){
	$query = mysql_query("SELECT * FROM item_tmp WHERE purchases_id = '$id'");
	return $query;
	}
function create_item_tmp($data){
	mysql_query("insert into item_tmp values(".$data.")");
}

function check_supplier_id($id){
		$query = mysql_query("select count(*) as jumlah
								  from hutang1
								  where supplier_id = '".$id."'
								  ");
		$row = mysql_fetch_array($query);
		$jumlah = $row['jumlah'];
		return $jumlah;
	}
function update_supplier_id($data, $supplier_id){
	mysql_query("update hutang1 set total_hutang = total_hutang + '$data' where supplier_id = '$supplier_id'");
}

function get_bank_account($id){
	$query = mysql_query("select bank_account_number from banks where bank_id = '$id'");
	$row = mysql_fetch_array($query);
	$result = ($row['bank_account_number']);
	return $result;
}

function select_item_2($id){
	$query = mysql_query("SELECT a.*,b.*, c.* FROM item_stocks a
												JOIN items b ON b.item_id = a.item_id
												JOIN item_harga c ON c.item_id = b.item_id
												WHERE b.sub_kategori_id = '$id'
												ORDER BY a.item_id");
	return $query;
}


function select_unit_item($id){
	$query = mysql_query("SELECT a.* FROM units a
												LEFT JOIN unit_konversi b ON b.unit_konversi = a.unit_id
												WHERE b.item_id = '$id'");
	return $query;
}

function select_same_word($word){
		$query = mysql_query("SELECT a.* from items a
													WHERE a.item_name like '%$word%'
													order by a.item_id
													");
		return $query;
}

function select_satuan_item_from_konv($id){
	$query = mysql_query("SELECT a.* FROM units a
												JOIN unit_konversi b ON b.unit_konversi = a.unit_id
												WHERE b.item_id = '$id'");
	return $query;
}

function select_satuan_item($id){
	$query = mysql_query("SELECT a.unit_id, unit_name, satuan, tingkat FROM units a JOIN items b ON b.unit_id = a.unit_id WHERE b.item_id = '$id'");
	return $query;
}


function select_widget_purchase($id){
	$query = mysql_query("SELECT a.*, b.*, c.unit_name FROM item_tmp a
											  JOIN items b ON b.item_id= a.item_id
											  LEFT JOIN units c on c.unit_id = a.unit_id
											  WHERE a.purchases_id = '$id'");
	return $query;
}

?>
