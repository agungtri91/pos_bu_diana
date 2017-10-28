<?php
function select(){
	$query=mysql_query("SELECT a.purchases_id, a.purchases_code FROM purchases a
											JOIN purchases_details b ON b.purchase_id = a.purchases_id
											WHERE b.retur < b.purchase_qty GROUP by a.purchases_id
											ORDER BY a.purchases_code");
	return $query;
}
function select_purchase($id){
	$query = mysql_query("SELECT a.*, b.*,c.*,d.item_name, e.unit_name, f.item_qty FROM purchases a
										    JOIN purchases_details b ON b.purchase_id = a.purchases_id
										    LEFT JOIN suppliers c ON c.supplier_id = a.supplier_id
										    JOIN items d ON d.item_id = b.item_id
										    left JOIN units e ON e.unit_id = d.unit_id
										    LEFT JOIN retur_pembelian_details f ON f.purchase_detail_id = b.purchase_detail_id
										    WHERE a.purchases_id = '$id'");
	return $query;
}

function get_all_item($purchases_id){
	$query = mysql_query("select count(*) as total
							from wr_pembelian_tmp a
							where purchase_id = '$purchases_id'
							  ");
	$row = mysql_fetch_array($query);
	$jumlah = ($row['total']) ? $row['total'] : 0;
	return $jumlah;
}

function get_all_jumlah($purchase_id){
	$query = mysql_query("SELECT SUM(a.item_qty * a.harga_retur) as total
												FROM wr_pembelian_tmp a
												WHERE a.purchase_id = '$purchase_id'
							  ");
	$row = mysql_fetch_array($query);

	$jumlah = ($row['total']) ? $row['total'] : 0;
	return $jumlah;
}


function get_unit_name_beli($id){
	$query = mysql_query("SELECT b.unit_name as result FROM purchases_details a
		 										LEFT JOIN units b on b.unit_id = a.unit_id
												WHERE a.purchase_detail_id = '$id'");
	$row = mysql_fetch_array($query);
	return $row['result'];
}

function get_harga_beli($id){
	$query = mysql_query("SELECT a.purchase_price as result FROM purchases_details a
												WHERE a.purchase_detail_id = '$id'");
	$row = mysql_fetch_array($query);
	return $row['result'];
}

function get_purchase_qty($id){
	$query = mysql_query("SELECT a.purchase_qty AS result
                        FROM purchases_details a WHERE a.purchase_detail_id = '".$id."'
							  			");
	$row = mysql_fetch_array($query);
	return $row['result'];
}

function get_purchase_retur($id){
	$query = mysql_query("SELECT a.retur AS result
                        FROM purchases_details a WHERE a.purchase_detail_id = '".$id."'
							  			");
	$row = mysql_fetch_array($query);
	return $row['result'];
}

function get_item_id($id){
	$query = mysql_query("SELECT a.item_id AS result
                        FROM purchases_details a WHERE a.purchase_detail_id = '".$id."'
							  			");
	$row = mysql_fetch_array($query);
	return $row['result'];
}

function get_new_retur_id(){
	$query = mysql_query("SELECT max(retur_id) AS result
                        FROM retur_pembelian a ");
	$row = mysql_fetch_array($query);
	return $row['result'];
}

function get_purchase_code($id){
	$query = mysql_query("SELECT a.* AS result
                        FROM purchases a WHERE a.purchases_id = '".$id."'
							  			");
	// $row = mysql_fetch_array($query);
	// return $row['result'];
	return $query;
}

function select_wr_pembelian_tmp($id){
	$query = mysql_query("SELECT a.*, c.* from wr_pembelian_tmp a
												JOIN purchases c on c.purchases_id = a.purchase_id
												WHERE a.purchase_id = '$id'");
	return $query;
}

function select_wr_pembelian_tmp_detail($id){
	$query = mysql_query("SELECT a.* from wr_pembelian_tmp a
												WHERE a.purchase_id = '$id'");
	return $query;
}

function delete_wr_pembelian_tmp($id){
	mysql_query("delete from wr_pembelian_tmp where purchase_id=".$id);
}

function select_supplier_retur($id){
	$query = mysql_query("SELECT a.supplier_id,a.lunas, b.* from purchases a
												JOIN suppliers b on b.supplier_id = a.supplier_id
												WHERE a.purchases_id = ".$id);
	return $query;
}

function select_retur_pembelian_tmp($id){
	$query = mysql_query("SELECT a.* from retur_pembelian_tmp a
												WHERE a.purchase_id = ".$id);
	return $query;
}

function select_retur_pembelian_detail_tmp($id){
	$query = mysql_query("SELECT a.* from retur_details_pembelian_tmp a
												WHERE a.purchase_id = '$id'");
	return $query;
}

function delete_retur_pembelian_tmp($id){
	mysql_query("delete from retur_pembelian_tmp where purchase_id=".$id);
}

function delete_retur_details_pembelian_tmp($id){
	mysql_query("delete from retur_details_pembelian_tmp where purchase_id=".$id);
}

function create_data_retur_pembelian($data){
	mysql_query("insert into retur_pembelian values(".$data.")");
}

function create_data_retur_pembelian_details($data){
	mysql_query("insert into retur_pembelian_details values(".$data.")");
}

function create_journal($data_id, $data_url, $journal_type_id, $i_payment_method, $retur_total_price,$retur_date,$user_id, $i_bank_id,
$i_bank_account,$i_bank_id_to,$i_bank_account_to){
	mysql_query("insert into journals values(
				'',
				'$journal_type_id',
				'".time()."',
				'$data_url',
				'$retur_total_price',
				'0',
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

function update_retur_purch_detail($id,$qty){
	mysql_query("update purchases_details set retur = retur + '".$qty."' where purchase_detail_id = '".$id."'");
}

function get_stock_retur_tmp($id){
	$query = mysql_query("SELECT a.item_qty AS result
                        FROM wr_pembelian_tmp a WHERE a.purchase_detail_id = '".$id."'
							  			");
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
														SELECT unit_id FROM purchases_details
														WHERE unit_id = '$id'
														) AND a.item_id = '$item_id'
													) AS b ON b.item_id = a.item_id
												LEFT JOIN items c ON c.item_id = a.item_id
												WHERE a.item_id = '$item_id'");
return $query;
}

function get_unit_beli($id){
	$query = mysql_query("SELECT a.unit_id as result FROM purchases_details a
												WHERE a.purchase_detail_id = '$id'");
	$row = mysql_fetch_array($query);
	return $row['result'];
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
			$qty = $i_stock / $row['unit_jml'];
		} else {
			$qty = $i_stock * $row['unit_konversi_jml'];
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

function select_widget($id){
	$query = mysql_query("SELECT a.*, b.item_name FROM wr_pembelian_tmp a
															JOIN items b ON b.item_id = a.item_id
															WHERE a.purchase_id = '$id'
															order by a.retur_tmp_id
															");
	return $query;
}

function select_retur_details_pembelian_tmp($id){
	$query = mysql_query("SELECT * FROM retur_details_pembelian_tmp WHERE purchase_id = '$id'");
	return $query;
}

function select_retur_tmp($id){
	$query = mysql_query("SELECT a.*, b.*, SUM(b.item_price_total) AS total FROM retur_pembelian_tmp a
												LEFT JOIN retur_details_pembelian_tmp b on b.purchase_id = a.purchase_id
												WHERE a.purchase_id = '$id'");
	return $query;
}

function update_stock($qty, $item_id, $data, $data_detail){
	$query = mysql_query("SELECT count(*) as result FROM stock_retur_pembelian WHERE item_id = '$item_id'");
	$row = mysql_fetch_array($query);
	$result = $row['result'];
	if ($result == 0) {
		$conn = mysql_query("insert into stock_retur_pembelian values(".$data.")");
	} else {
		mysql_query("update stock_retur_pembelian set item_stock_qty = item_stock_qty + '$qty' where item_id = '$item_id'");
	}
	mysql_query("insert into stock_retur_details_pembelian values(".$data_detail.")");
}

 ?>
