<?php
function select(){
	$query=mysql_query("SELECT a.transaction_id, a.transaction_code FROM transactions a
											JOIN transaction_details b ON b.transaction_id = a.transaction_id
											WHERE b.retur < b.transaction_detail_qty group by a.transaction_id
											ORDER BY a.transaction_code");
	return $query;
}

// function get_item_name($id){
// 	$query = mysql_query("SELECT a.item_name AS result
//                         FROM items a JOIN transaction_details b ON b.item_id = a.item_id
//                         WHERE b.transaction_detail_id = '".$id."'
// 							  			");
// 	$row = mysql_fetch_array($query);
// 	return $row['result'];
// }

function get_item_id($id){
	$query = mysql_query("SELECT a.item_id AS result
                        FROM transaction_details a WHERE a.transaction_detail_id = '".$id."'
							  			");
	$row = mysql_fetch_array($query);
	return $row['result'];
}

function get_transaction_detail_qty($id){
	$query = mysql_query("SELECT a.transaction_detail_qty AS result
                        FROM transaction_details a WHERE a.transaction_detail_id = '".$id."'
							  			");
	$row = mysql_fetch_array($query);
	return $row['result'];
}

function get_stock_retur_tmp($id, $unit_id_jual){
	$query = mysql_query("SELECT a.item_qty AS result FROM retur_tmp a WHERE a.transaction_detail_id = '".$id."'
							  			");
	$row = mysql_fetch_array($query);
	return $row['result'];
}

function get_transaction_retur($id){
	$query = mysql_query("SELECT a.item_stock_real AS result
                        FROM stock_retur_details_penjualan a WHERE a.transaction_detail_id = '".$id."'
							  			");
	$row = mysql_fetch_array($query);
	return $row['result'];
}

function get_transaction_code($id){
	$query = mysql_query("SELECT a.transaction_code AS result
                        FROM transactions a WHERE a.transaction_id = '".$id."'
							  			");
	$row = mysql_fetch_array($query);
	return $row['result'];
}

function get_new_retur_id(){
	$query = mysql_query("SELECT max(retur_id) AS result
                        FROM retur a ");
	$row = mysql_fetch_array($query);
	return $row['result'];
}

function create_retur_tmp($data){
	mysql_query("insert into retur_tmp values(".$data.")");
}

function get_all_item($transaction_id){
	$query = mysql_query("select count(*) as total
							from retur_tmp a
							where transaction_id = '$transaction_id'
							  ");
	$row = mysql_fetch_array($query);

	$jumlah = ($row['total']) ? $row['total'] : 0;
	return $jumlah;
}

function get_all_jumlah($transaction_id){
	$query = mysql_query("SELECT SUM(a.item_qty * a.harga_konversi) AS total
												FROM retur_tmp a
												WHERE a.transaction_id = '$transaction_id'
							  ");
	$row = mysql_fetch_array($query);

	$jumlah = ($row['total']) ? $row['total'] : 0;
	return $jumlah;
}

function delete_retur_tmp($id){
	mysql_query("delete from retur_tmp where transaction_id=".$id);
}

function delete_retur_tmp1($id){
	mysql_query("delete from retur_tmp1 where transaction_id=".$id);
}

function delete_retur_details_tmp1($id){
	mysql_query("delete from retur_details_tmp where transaction_id =".$id);
}

function select_retur_tmp($id){
	$query = mysql_query("SELECT a.*, c.* from retur_tmp a
												JOIN transactions c on c.transaction_id = a.transaction_id
												WHERE a.transaction_id = '$id'");
	return $query;
}

function select_retur_tmp1($id){
	$query = mysql_query("SELECT a.* FROM retur_tmp1 a
												WHERE a.transaction_id = ".$id);
	return $query;
}

function close_retur_tmp($id){
	$query = mysql_query("SELECT * FROM retur_tmp1
												WHERE transaction_id = ".$id);
	return $query;
}

function select_retur_detail($id){
	$query = mysql_query("SELECT a.*, c.* from retur_tmp a
												inner JOIN transaction_details c on c.transaction_detail_id = a.transaction_detail_id
												WHERE a.transaction_id = '$id'");
	return $query;
}

function select_retur_detail_tmp($id){
	$query = mysql_query("SELECT a.* from retur_details_tmp a
												WHERE a.transaction_id = '$id'");
	return $query;
}

function create_data_retur_detail_tmp($data){
	mysql_query("insert into retur_details_tmp values(".$data.")");
}

function create_data_retur($data){
	mysql_query("insert into retur values(".$data.")");
}


function select_member_retur($id){
	$query = mysql_query("SELECT a.member_id,a.lunas, b.* from transactions a
												JOIN members b on b.member_id = a.member_id
												WHERE a.transaction_id = ".$id);
	return $query;
}

// $i_transaction_id,$data_url,'7',$r_retur_tmp['retur_total_price'],$r_retur_tmp['retur_date'],$_SESSION['user_id'],$i_bank_id
function create_journal($data_id, $data_url, $journal_type_id, $i_payment_method, $retur_total_price,$retur_date,
												$user_id, $i_bank_id,$i_bank_account,$i_bank_id_to,$i_bank_account_to){
	mysql_query("insert into journals values(
				'',
				'$journal_type_id',
				'".time()."',
				'$data_url',
				'0',
				'$retur_total_price',
				'0',
				'0',
				'',
				'".$retur_date."',
				'$i_payment_method',
				'$i_bank_id',
				'$i_bank_account',
				'$i_bank_id_to',
				'$i_bank_account_to',
				'".$_SESSION['user_id']."',
				''
	)");
}
function update_retur_trans_detail($id,$qty){
	mysql_query("update transaction_details set retur = retur + '".$qty."' where transaction_detail_id = '".$id."'");
}

function select_transacation($id){
	$query=mysql_query("SELECT a.*, b.*,c.*,d.item_name, e.unit_name as unit_utama_name, f.unit_name as unit_jual_name FROM transactions a
											JOIN transaction_details b ON b.transaction_id = a.transaction_id
											LEFT JOIN members c ON c.member_id = a.member_id
											JOIN items d ON d.item_id = b.item_id
											left JOIN units e ON e.unit_id = d.unit_id
											left JOIN units f ON f.unit_id = b.transaction_detail_unit
											WHERE a.transaction_id = '$id'");
	return $query;
}

function get_unit_jual_name($id){
	$query = mysql_query("SELECT b.unit_name as result FROM transaction_details a
		 										LEFT JOIN units b on b.unit_id = a.transaction_detail_unit
												WHERE a.transaction_detail_id = '$id'");
	$row = mysql_fetch_array($query);
	return $row['result'];
}

function get_unit_jual($id){
	$query = mysql_query("SELECT a.transaction_detail_unit as result FROM transaction_details a
		 										LEFT JOIN units b on b.unit_id = a.transaction_detail_unit
												WHERE a.transaction_detail_id = '$id'");
	$row = mysql_fetch_array($query);
	return $row['result'];
}

function select_satuan_item($item_id, $id){
	$query = mysql_query("SELECT IF(b.unit_konversi, b.unit_konversi, c.unit_id) AS unit FROM unit_konversi a
												LEFT JOIN (
													SELECT a.unit_konversi, a.item_id FROM unit_konversi a
													LEFT JOIN unit_konversi b ON b.item_id = a.item_id
													WHERE a.unit_konversi
													NOT IN (
														SELECT transaction_detail_unit FROM transaction_details
														WHERE transaction_detail_id = '$id'
														) AND a.item_id = '$item_id'
													) AS b ON b.item_id = a.item_id
												LEFT JOIN items c ON c.item_id = a.item_id
												WHERE a.item_id = '$item_id'");
return $query;
}

function get_unit_id_utama($id){
	$query = mysql_query("SELECT unit_id as result FROM items WHERE item_id = '$id'");
	$row = mysql_fetch_array($query);
	$result =  $row['result'];
	return $result;
}

function konversi_qty_retur($item_id ,$i_unit ,$i_stock ,$i_unit_jual, $unit_id_utama){
	$qty = $i_stock;
	if ($i_unit_jual != $unit_id_utama) {
		$query = mysql_query("SELECT * FROM unit_konversi WHERE item_id = '$item_id' AND unit_konversi = $i_unit_jual");
	} else {
		$query = mysql_query("SELECT * FROM unit_konversi WHERE item_id = '$item_id' and unit_id = '$i_unit_jual' AND unit_konversi = '$i_unit' ");
	}
	$row = mysql_fetch_array($query);
	if ($row['unit_konversi_jml']!=null) {
		if ($row['unit_konversi_jml'] < $row['unit_jml']) {
			$qty = $i_stock * $row['unit_jml'];
		} else {
			$qty = $i_stock / $row['unit_konversi_jml'];
		}
	}
	return $qty;
}

function get_harga_konversi($item_id,$i_unit,$i_stock,$i_unit_jual, $unit_id_utama){
	$qty = $i_stock;
	if ($i_unit != $unit_id_utama) {
		$query = mysql_query("SELECT * FROM unit_konversi WHERE item_id = '$item_id' AND unit_konversi = $i_unit");
		$row = mysql_fetch_array($query);
		$harga_konversi = $row['harga_konversi'];
	} else {
		$query = mysql_query("SELECT * FROM item_harga WHERE item_id = '$item_id'");
		$row = mysql_fetch_array($query);
		$harga_konversi = $row['item_price'];
	}

	return $harga_konversi;
}

function get_harga_jual($id){
	$query = mysql_query("SELECT item_price as result FROM item_harga WHERE item_id = '$id'");
	$row = mysql_fetch_array($query);
	$result = $row['result'];
	return $result;
}

function select_widget($id){
	$query = mysql_query("SELECT a.*, b.item_name, c.* FROM retur_tmp a
												LEFT JOIN items b ON b.item_id = a.item_id
												LEFT JOIN transaction_details c
												ON c.transaction_detail_id = a.transaction_detail_id
												WHERE a.transaction_id = '$id'
												ORDER BY a.retur_tmp_id");
	return $query;
}

function update_stock($qty, $item_id, $data, $data_detail){
	$query = mysql_query("SELECT count(*) as result FROM stock_retur_penjualan WHERE item_id = '$item_id'");
	$row = mysql_fetch_array($query);
	$result = $row['result'];
	if ($result == 0) {
		$conn = mysql_query("insert into stock_retur_penjualan values(".$data.")");
	} else {
		mysql_query("update stock_retur_penjualan set item_stock_qty = item_stock_qty + '$qty' where item_id = '$item_id'");
	}
	mysql_query("insert into stock_retur_details_penjualan values(".$data_detail.")");

}

function get_transaction_detail_id($id,$item_id){
	$query = mysql_query("SELECT transaction_detail_id as result FROM transaction_details WHERE transaction_id = '$id' AND item_id = '$item_id'");
	$row = mysql_fetch_array($query);
	$result = $row['result'];
	return $result;
}

 ?>
